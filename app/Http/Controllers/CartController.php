<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $deliveryZones = \App\Models\DeliveryZone::where('is_active', true)->get();
        return view('cart', compact('deliveryZones'));
    }

    public function syncFromLocalStorage(Request $request)
    {
        $request->validate(['items' => 'array', 'items.*.id' => 'required|exists:products,id', 'items.*.quantity' => 'required|numeric|min:0.01']);
        $cart = [];
        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            if ($product && $product->is_active) {
                $qty = (float) $item['quantity'];
                $max = $product->stock;
                if ($max > 0) {
                    $qty = min($qty, $max);
                    $cart[] = ['id' => $product->id, 'name' => $product->name, 'slug' => $product->slug, 'price' => (float) $product->price, 'unit' => $product->unit, 'quantity' => $qty, 'stock' => $product->stock];
                }
            }
        }
        return response()->json(['cart' => $cart]);
    }
}
