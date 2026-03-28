<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('payment')) {
            $query->where('payment_status', $request->payment);
        }
        $orders = $query->latest()->paginate(20);
        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'user']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|in:pending,processing,shipped,delivered,cancelled']);
        $order->update(['status' => $request->status]);

        if ($order->user) {
            \Illuminate\Support\Facades\Notification::send(
                $order->user, 
                new \App\Notifications\OrderStatusUpdated($order)
            );
        }

        return back()->with('success', 'Statut mis à jour.');
    }

    public function updatePaymentStatus(Request $request, Order $order)
    {
        $request->validate(['payment_status' => 'required|in:pending,paid,failed,refunded']);
        $order->update(['payment_status' => $request->payment_status]);
        return back()->with('success', 'Statut de paiement mis à jour.');
    }
}
