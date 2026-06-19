<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\NewArrival;
use Illuminate\Support\Facades\DB;

class DummyProductsSeeder extends Seeder
{
    public function run(): void
    {
        // Disable foreign key checks to safely truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Delete all storefront data related to products
        DB::table('cart_items')->truncate();
        DB::table('wishlists')->truncate();
        DB::table('reviews')->truncate();
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('product_sizes')->truncate();
        DB::table('new_arrivals')->truncate();
        DB::table('products')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Seed 3 high-quality dummy products
        $p1 = Product::create([
            'name' => 'Classic Trench Coat',
            'category_id' => 1, // Men
            'description' => 'An editorial double-breasted trench coat crafted from premium cotton gabardine. Detailed with buttoned epaulettes, a waist-cinching belt, and storm flaps. Timeless, vintage style for any season.',
            'image' => 'products/carousel_1.jpg',
            'status' => 'active'
        ]);

        $sizes1 = [
            ['size' => 'S', 'price' => 2499.00, 'stock' => 15],
            ['size' => 'M', 'price' => 2499.00, 'stock' => 25],
            ['size' => 'L', 'price' => 2599.00, 'stock' => 20],
            ['size' => 'XL', 'price' => 2599.00, 'stock' => 10],
        ];
        foreach ($sizes1 as $sz) {
            ProductSize::create(array_merge(['product_id' => $p1->id], $sz));
        }

        $p2 = Product::create([
            'name' => 'Structured Linen Blazer',
            'category_id' => 1, // Men
            'description' => 'Designed for a relaxed, modern silhouette. This single-breasted blazer is cut from lightweight, breathable organic linen and features notch lapels, buttoned cuffs, and patch pockets.',
            'image' => 'products/carousel_2.jpeg',
            'status' => 'active'
        ]);

        $sizes2 = [
            ['size' => 'S', 'price' => 1899.00, 'stock' => 8],
            ['size' => 'M', 'price' => 1899.00, 'stock' => 12],
            ['size' => 'L', 'price' => 1999.00, 'stock' => 15],
            ['size' => 'XL', 'price' => 1999.00, 'stock' => 5],
        ];
        foreach ($sizes2 as $sz) {
            ProductSize::create(array_merge(['product_id' => $p2->id], $sz));
        }

        $p3 = Product::create([
            'name' => 'Editorial Ribbed Knit Sweater',
            'category_id' => 2, // Women
            'description' => 'A premium heavy-weight ribbed knit sweater. Spun from soft merino wool blend, offering unmatched comfort and warmth in a relaxed vintage cut with drop shoulders.',
            'image' => 'products/carousel_3.jpg',
            'status' => 'active'
        ]);

        $sizes3 = [
            ['size' => 'S', 'price' => 1299.00, 'stock' => 20],
            ['size' => 'M', 'price' => 1299.00, 'stock' => 30],
            ['size' => 'L', 'price' => 1399.00, 'stock' => 25],
            ['size' => 'XL', 'price' => 1399.00, 'stock' => 15],
        ];
        foreach ($sizes3 as $sz) {
            ProductSize::create(array_merge(['product_id' => $p3->id], $sz));
        }

        // Seed new arrivals pointing to these products
        NewArrival::create([
            'name' => $p1->name,
            'description' => 'Double-breasted timeless classic.',
            'price' => 2499.00,
            'image' => $p1->image,
            'status' => 'active',
            'product_id' => $p1->id
        ]);

        NewArrival::create([
            'name' => $p2->name,
            'description' => 'Lightweight breathable organic linen.',
            'price' => 1899.00,
            'image' => $p2->image,
            'status' => 'active',
            'product_id' => $p2->id
        ]);

        NewArrival::create([
            'name' => $p3->name,
            'description' => 'Heavy-weight soft merino wool blend.',
            'price' => 1299.00,
            'image' => $p3->image,
            'status' => 'active',
            'product_id' => $p3->id
        ]);
    }
}
