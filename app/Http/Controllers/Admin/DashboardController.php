<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_count' => Order::count(),
            'orders_today' => Order::whereDate('created_at', today())->count(),
            'total_revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'products_count' => Product::count(),
            'low_stock' => Product::whereColumn('stock', '<=', 'stock_alert')->where('stock', '>', 0)->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
            'customers_count' => User::where('is_admin', false)->count(),
        ];

        $driver = \Illuminate\Support\Facades\DB::connection()->getDriverName();
        if ($driver === 'pgsql') {
            $revenueByMonth = Order::where('payment_status', 'paid')
                ->selectRaw("to_char(created_at, 'YYYY-MM') as month, sum(total) as total")
                ->groupByRaw("to_char(created_at, 'YYYY-MM')")
                ->orderBy('month')
                ->limit(12)
                ->get();
        } else {
            $revenueByMonth = Order::where('payment_status', 'paid')
                ->selectRaw('strftime("%Y-%m", created_at) as month, sum(total) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->limit(12)
                ->get();
        }

        $topProducts = Order::join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->select('order_items.product_name', DB::raw('sum(order_items.quantity) as qty'), DB::raw('sum(order_items.total) as revenue'))
            ->groupBy('order_items.product_name')
            ->orderByDesc('qty')
            ->limit(10)
            ->get();

        $recentOrders = Order::with('user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'revenueByMonth', 'topProducts', 'recentOrders'));
    }
}
