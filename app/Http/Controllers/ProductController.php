<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)->with('category');
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->q . '%')
                  ->orWhere('description', 'like', '%' . $request->q . '%');
            });
        }
        $products = $query->orderBy('name')->paginate(12);
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        return view('products.index', compact('products', 'categories'));
    }

    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->where('is_active', true)->with('category')->firstOrFail();
        $related = Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->where('is_active', true)->limit(4)->get();
        return view('products.show', compact('product', 'related'));
    }

    public function apiList()
    {
        $products = Product::where('is_active', true)->with('category:id,name,slug')->get(['id', 'name', 'slug', 'price', 'unit', 'stock', 'image', 'category_id']);
        return response()->json($products);
    }
}
