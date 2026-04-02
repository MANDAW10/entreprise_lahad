<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ContactMessageController as AdminMessageController;
use App\Http\Controllers\Admin\DeliveryZoneController as AdminDeliveryZoneController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\BroadcastController as AdminBroadcastController;
use App\Http\Controllers\NotificationController as ClientNotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/setup', function () {
    try {
        echo "Environnement : " . php_uname() . "<br>";
        echo "Version PHP : " . PHP_VERSION . "<br>";
        $sqlite_version = \DB::select('select version() as version')[0]->version;
        echo "Base de données : " . $sqlite_version . "<br><br>";
        
        echo "Initialisation de la base de données...<br>";
        // Fresh migrate first to be sure
        Artisan::call('migrate:fresh', ['--force' => true]);
        echo "Migrations terminées.<br>";
        
        echo "Chargement des catégories et produits...<br>";
        Artisan::call('db:seed', ['--force' => true]);
        echo "Seeding terminé.<br>";
        
        // Force admin creation
        if (!\App\Models\User::where('email', 'admin@lahad.com')->exists()) {
            \App\Models\User::create([
                'name' => 'Admin Lahad',
                'email' => 'admin@lahad.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'is_admin' => true,
            ]);
            echo "Utilisateur Admin recréé.<br>";
        }
        
        return "⚡ Installation terminée avec succès ! <a href='/'>Retour à l'accueil</a>";
    } catch (\Exception $e) {
        return "❌ Erreur lors de l'installation : " . $e->getMessage();
    }
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produits', [ProductController::class, 'index'])->name('products.index');
Route::get('/produits/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/panier', [CartController::class, 'index'])->name('cart');
Route::post('/panier/sync', [CartController::class, 'syncFromLocalStorage'])->name('cart.sync');

Route::get('/api/produits', [ProductController::class, 'apiList'])->name('api.products');

Route::get('/connexion', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/connexion', [LoginController::class, 'login']);
Route::post('/deconnexion', [LoginController::class, 'logout'])->name('logout');
Route::get('/inscription', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/inscription', [RegisterController::class, 'register']);

use App\Http\Controllers\Auth\PasswordResetController;
Route::get('/mot-de-passe/oublie', [PasswordResetController::class, 'showDirectResetForm'])->name('password.request');
Route::post('/mot-de-passe/oublie', [PasswordResetController::class, 'resetDirect'])->name('password.update');

Route::middleware('auth')->group(function () {
    Route::get('/compte', [AccountController::class, 'index'])->name('account.index');
    Route::get('/compte/commandes', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/compte/commandes/{order}', [AccountController::class, 'showOrder'])->name('account.orders.show');
    Route::put('/compte', [AccountController::class, 'updateProfile'])->name('account.update');
    
    Route::get('/notifications/{id}/read', [ClientNotificationController::class, 'read'])->name('account.notifications.read');
    Route::post('/notifications/read-all', [ClientNotificationController::class, 'readAll'])->name('account.notifications.readAll');
});

Route::post('/commande', [OrderController::class, 'store'])->name('order.store');
Route::get('/commande/confirmation/{orderNumber}', [OrderController::class, 'confirmation'])->name('order.confirmation');

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->names('products');
    Route::resource('delivery-zones', AdminDeliveryZoneController::class)->names('delivery_zones');
    Route::resource('orders', AdminOrderController::class)->only(['index', 'show']);
    Route::resource('messages', AdminMessageController::class)->only(['index', 'show', 'destroy']);
    
    Route::get('broadcast/create', [AdminBroadcastController::class, 'create'])->name('broadcast.create');
    Route::post('broadcast', [AdminBroadcastController::class, 'store'])->name('broadcast.store');

    Route::get('notifications/{id}/read', [AdminNotificationController::class, 'read'])->name('notifications.read');
    Route::post('notifications/read-all', [AdminNotificationController::class, 'readAll'])->name('notifications.readAll');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('orders/{order}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.payment');
});
