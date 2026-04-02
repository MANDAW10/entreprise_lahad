<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        if (is_string($request->items)) {
            $request->merge(['items' => json_decode($request->items, true) ?? []]);
        }
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'nullable|string|max:50',
            'delivery_zone_id' => 'required|exists:delivery_zones,id',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:wave,orange_money',
            'payment_phone' => 'required|string|max:50',
            'transaction_id' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
        ]);

        $orderNumber = Order::generateOrderNumber();
        $subtotal = 0;
        $itemsData = [];

        foreach ($request->items as $item) {
            $product = Product::findOrFail($item['product_id']);
            $qty = (float) $item['quantity'];
            $qty = min($qty, $product->stock);
            if ($qty <= 0) {
                continue;
            }
            $total = round($product->price * $qty, 2);
            $subtotal += $total;
            $itemsData[] = [
                'product' => $product,
                'quantity' => $qty,
                'total' => $total,
            ];
        }

        if (empty($itemsData)) {
            return response()->json(['message' => 'Panier vide ou produits indisponibles.'], 422);
        }

        $deliveryZone = \App\Models\DeliveryZone::findOrFail($request->delivery_zone_id);
        $shippingCost = $deliveryZone->fee;
        
        $total = $subtotal + $shippingCost;

        $order = Order::create([
            'order_number' => $orderNumber,
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'delivery_zone_id' => $deliveryZone->id,
            'shipping_address' => $request->shipping_address,
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'payment_phone' => $request->payment_phone,
            'transaction_id' => $request->transaction_id,
            'payment_status' => 'pending', // Keeps pending until admin verifies
            'status' => 'pending',
        ]);

        foreach ($itemsData as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'product_name' => $item['product']->name,
                'price' => $item['product']->price,
                'quantity' => $item['quantity'],
                'unit' => $item['product']->unit,
                'total' => $item['total'],
            ]);
            $item['product']->decrement('stock', $item['quantity']);
        }

        \Illuminate\Support\Facades\Notification::send(
            \App\Models\User::where('is_admin', true)->get(),
            new \App\Notifications\NewOrder($order)
        );

        if (auth()->check()) {
            return response()->json(['redirect' => route('account.orders.show', $order->id), 'order_id' => $order->id]);
        }
        return response()->json(['redirect' => route('order.confirmation', $order->order_number), 'order_id' => $order->id]);
    }

    public function confirmation(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->with('items')->firstOrFail();
        return view('order.confirmation', compact('order'));
    }
}
