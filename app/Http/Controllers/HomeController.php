<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->withCount(['activeProducts'])->get();
        $featuredProducts = Product::where('is_active', true)->where('stock', '>', 0)->inRandomOrder()->limit(8)->get();
        return view('home', compact('categories', 'featuredProducts'));
    }
}
