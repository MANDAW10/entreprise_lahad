<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $productsByCategory = [
            'Viande poulet locale' => [
                ['name' => 'Poulet entier', 'price' => 3500, 'unit' => 'kg', 'stock' => 50],
                ['name' => 'Cuisses de poulet', 'price' => 3200, 'unit' => 'kg', 'stock' => 30],
                ['name' => 'Blanc de poulet', 'price' => 4000, 'unit' => 'kg', 'stock' => 25],
            ],
            'Viande caille' => [
                ['name' => 'Caille entière', 'price' => 2500, 'unit' => 'pièce', 'stock' => 40],
                ['name' => 'Viande caille (découpée)', 'price' => 4500, 'unit' => 'kg', 'stock' => 15],
            ],
            'Viande agneau' => [
                ['name' => 'Gigot d\'agneau', 'price' => 5500, 'unit' => 'kg', 'stock' => 20],
                ['name' => 'Côtelettes d\'agneau', 'price' => 6000, 'unit' => 'kg', 'stock' => 18],
            ],
            'Vente de lait' => [
                ['name' => 'Lait frais (1 L)', 'price' => 800, 'unit' => 'L', 'stock' => 100],
                ['name' => 'Lait frais (5 L)', 'price' => 3500, 'unit' => 'L', 'stock' => 50],
            ],
            'Lait caillé, yaourt, fromage locale' => [
                ['name' => 'Lait caillé', 'price' => 500, 'unit' => 'pot', 'stock' => 80],
                ['name' => 'Yaourt nature', 'price' => 400, 'unit' => 'pot', 'stock' => 120],
                ['name' => 'Fromage local', 'price' => 2500, 'unit' => 'kg', 'stock' => 25],
            ],
            'Aliment de bétail' => [
                ['name' => 'Aliment poulet de chair (25 kg)', 'price' => 12500, 'unit' => 'sac', 'stock' => 40],
                ['name' => 'Aliment ponte (25 kg)', 'price' => 11500, 'unit' => 'sac', 'stock' => 35],
            ],
            'Vente de poussin Goliath' => [
                ['name' => 'Poussin Goliath (1 jour)', 'price' => 1200, 'unit' => 'pièce', 'stock' => 200],
                ['name' => 'Lot 10 poussins Goliath', 'price' => 11000, 'unit' => 'lot', 'stock' => 30],
            ],
        ];

        foreach ($productsByCategory as $categoryName => $products) {
            $category = Category::where('name', $categoryName)->first();
            if (!$category) {
                continue;
            }
            foreach ($products as $p) {
                $product = Product::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'name' => $p['name'],
                    ],
                    [
                        'slug' => Str::slug($p['name']),
                        'description' => 'Produit de qualité Lahad Enterprise.',
                        'price' => $p['price'],
                        'unit' => $p['unit'],
                        'stock' => $p['stock'],
                        'stock_alert' => 5,
                        'is_active' => true,
                    ]
                );
                $product->update(['slug' => Str::slug($product->name) . '-' . $product->id]);
            }
        }
    }
}
