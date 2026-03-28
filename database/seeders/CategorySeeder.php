<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Viande poulet locale', 'description' => 'Viande de poulet élevé localement, frais et de qualité.'],
            ['name' => 'Viande caille', 'description' => 'Viande de caille, délicate et savoureuse.'],
            ['name' => 'Viande agneau', 'description' => 'Viande d\'agneau locale, tendre et goûteuse.'],
            ['name' => 'Vente de lait', 'description' => 'Lait frais local.'],
            ['name' => 'Lait caillé, yaourt, fromage locale', 'description' => 'Produits laitiers transformés : lait caillé, yaourt et fromage traditionnel.'],
            ['name' => 'Aliment de bétail', 'description' => 'Aliments pour l\'élevage et le bétail.'],
            ['name' => 'Vente de poussin Goliath', 'description' => 'Poussins Goliath pour l\'élevage.'],
        ];

        foreach ($categories as $index => $cat) {
            Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
