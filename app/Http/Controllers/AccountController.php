<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)->orderByDesc('created_at')->limit(10)->get();
        return view('account.index', compact('user', 'orders'));
    }

    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->orderByDesc('created_at')->paginate(10);
        return view('account.orders', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(404);
        }
        $order->load('items');
        return view('account.order-show', compact('order'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
        ]);
        auth()->user()->update($request->only('name', 'phone', 'address'));
        return back()->with('success', 'Profil mis à jour.');
    }
}
