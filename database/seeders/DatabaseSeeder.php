<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $users = [
            [
                'name' => env('SEED_SUPERADMIN_NAME', 'Fashion Super Admin'),
                'email' => env('SEED_SUPERADMIN_EMAIL', 'superadmin@fashionflair.test'),
                'password' => env('SEED_SUPERADMIN_PASSWORD'),
                'role' => User::ROLE_SUPERADMIN,
            ],
            [
                'name' => env('SEED_ADMIN_NAME', 'Fashion Admin'),
                'email' => env('SEED_ADMIN_EMAIL', 'admin@fashionflair.test'),
                'password' => env('SEED_ADMIN_PASSWORD'),
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => env('SEED_CUSTOMER_NAME', 'Demo Customer'),
                'email' => env('SEED_CUSTOMER_EMAIL', 'customer@fashionflair.test'),
                'password' => env('SEED_CUSTOMER_PASSWORD'),
                'role' => User::ROLE_CUSTOMER,
            ],
        ];

        foreach ($users as $user) {
            if (empty($user['password'])) {
                $this->command?->warn("Skipping {$user['email']} because its seed password is not configured.");
                continue;
            }

            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }

        $categories = collect([
            ['name' => 'Dresses', 'icon' => 'DR', 'description' => 'Occasion-ready silhouettes and everyday dresses.'],
            ['name' => 'Tops', 'icon' => 'TP', 'description' => 'Soft blouses, shirts, knits, and statement tops.'],
            ['name' => 'Bottoms', 'icon' => 'BT', 'description' => 'Denim, trousers, skirts, and easy coordinates.'],
            ['name' => 'Co-ords', 'icon' => 'CO', 'description' => 'Matched sets for effortless styling.'],
        ])->mapWithKeys(function (array $data) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                $data + ['slug' => Str::slug($data['name']), 'is_active' => true]
            );

            return [$category->name => $category];
        });

        $products = [
            ['Dresses', 'Rose Satin Midi Dress', 2499, 12, 'women', 'Fashion Flair', 'Satin blend', 24, true],
            ['Tops', 'Pearl Button Wrap Top', 1299, 0, 'women', 'Fashion Flair', 'Viscose', 32, true],
            ['Bottoms', 'High Waist Wide Leg Trousers', 1899, 8, 'women', 'Fashion Flair', 'Cotton twill', 18, false],
            ['Co-ords', 'Soft Blush Lounge Co-ord', 2799, 15, 'women', 'Fashion Flair', 'Rib knit', 16, true],
            ['Dresses', 'Meadow Print Day Dress', 2199, 0, 'women', 'Fashion Flair', 'Rayon', 21, false],
            ['Tops', 'Ivory Ribbed Tank', 899, 0, 'women', 'Fashion Flair', 'Cotton rib', 40, false],
            ['Bottoms', 'Sage A-line Skirt', 1499, 10, 'women', 'Fashion Flair', 'Linen blend', 14, false],
            ['Co-ords', 'Plum Tailored Co-ord Set', 3299, 18, 'women', 'Fashion Flair', 'Crepe', 10, true],
        ];

        foreach ($products as [$categoryName, $name, $price, $offer, $gender, $brand, $material, $stock, $featured]) {
            $product = Product::updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'slug' => Str::slug($name),
                    'description' => 'A polished wardrobe piece designed for comfort, movement, and a flattering everyday fit.',
                    'price' => $price,
                    'offer_percent' => $offer,
                    'category_id' => $categories[$categoryName]->id,
                    'brand' => $brand,
                    'material' => $material,
                    'gender' => $gender,
                    'stock_qty' => $stock,
                    'is_featured' => $featured,
                    'is_active' => true,
                ]
            );

            if ($product->variants()->count() === 0) {
                foreach (['XS', 'S', 'M', 'L', 'XL'] as $size) {
                    $product->variants()->create(['size' => $size, 'stock_qty' => 8]);
                }
            }
        }
    }
}
