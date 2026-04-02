<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        $products = $query->orderBy('name')->paginate(15);
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'stock' => 'required|integer|min:0',
            'stock_alert' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,bmp,tiff,heic,heif,avif,ico|max:10240',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $slug = Str::slug($request->name);
        $product = Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'stock' => $request->stock,
            'stock_alert' => $request->stock_alert ?? 5,
            'is_active' => $request->boolean('is_active'),
            'image' => $imagePath,
        ]);
        $product->update(['slug' => $slug . '-' . $product->id]);
        return redirect()->route('admin.products.index')->with('success', 'Produit créé.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('sort_order')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:20',
            'stock' => 'required|integer|min:0',
            'stock_alert' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp,bmp,tiff,heic,heif,avif,ico|max:10240',
        ]);

        $data = [
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . $product->id,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'stock' => $request->stock,
            'stock_alert' => $request->stock_alert ?? 5,
            'is_active' => $request->boolean('is_active'),
        ];

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé.');
    }
}
