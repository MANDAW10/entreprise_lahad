<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useBootstrapFive();
        
        // Force HTTPS on Vercel
        if (env('APP_ENV') === 'production' || isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Auto-initialize Database on Vercel (SQLite in /tmp)
        if (config('database.default') === 'sqlite' && env('APP_ENV') === 'production') {
            try {
                // Check if categories table exists, if not, migrate and seed
                if (!\Schema::hasTable('categories') || \DB::table('categories')->count() === 0) {
                    \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
                    \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
                    
                    // Specific fail-safe for admin user
                    if (!\App\Models\User::where('email', 'admin@lahad.com')->exists()) {
                        \App\Models\User::create([
                            'name' => 'Admin Lahad',
                            'email' => 'admin@lahad.com',
                            'password' => \Illuminate\Support\Facades\Hash::make('password'),
                            'is_admin' => true,
                        ]);
                    }
                }
            } catch (\Throwable $e) {
                // Silent fail to avoid crashing the app
            }
        }
    }
}
