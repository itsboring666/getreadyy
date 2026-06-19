<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SearchAutocompleteTest extends TestCase
{
    use DatabaseTransactions;

    protected $activeProduct;
    protected $inactiveProduct;

    protected function setUp(): void
    {
        parent::setUp();

        $category = Category::firstOrCreate(
            ['slug' => 'tees'],
            ['name' => 'Tees', 'status' => 'active', 'image' => 'tees.jpg']
        );

        $this->activeProduct = Product::create([
            'name' => 'Vintage Denim Jacket',
            'category_id' => $category->id,
            'description' => 'A classic over-engineered outerwear.',
            'status' => 'active',
            'image' => 'jacket.jpg'
        ]);

        ProductSize::create([
            'product_id' => $this->activeProduct->id,
            'size' => 'L',
            'price' => 1299.00,
            'stock' => 15
        ]);

        $this->inactiveProduct = Product::create([
            'name' => 'Vintage Denim Jeans',
            'category_id' => $category->id,
            'description' => 'Faded look denim jeans.',
            'status' => 'inactive',
            'image' => 'jeans.jpg'
        ]);

        ProductSize::create([
            'product_id' => $this->inactiveProduct->id,
            'size' => 'S',
            'price' => 1499.00,
            'stock' => 20
        ]);
    }

    /**
     * Test autocomplete returns matches for active products.
     */
    public function test_autocomplete_returns_active_matches()
    {
        $response = $this->getJson(route('products.autocomplete') . '?q=Denim');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
        $response->assertJsonFragment([
            'name' => 'Vintage Denim Jacket',
            'category' => 'Tees',
            'price' => '₹1,299.00'
        ]);

        // Inactive product should NOT be in the results
        $response->assertJsonMissing([
            'name' => 'Vintage Denim Jeans'
        ]);
    }

    /**
     * Test autocomplete excludes inactive products completely.
     */
    public function test_autocomplete_excludes_inactive_products()
    {
        // Try searching specifically for the inactive product's name
        $response = $this->getJson(route('products.autocomplete') . '?q=Jeans');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    /**
     * Test autocomplete returns empty list for queries shorter than 2 characters.
     */
    public function test_autocomplete_ignores_short_queries()
    {
        $response = $this->getJson(route('products.autocomplete') . '?q=V');

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }

    /**
     * Test autocomplete returns empty list for empty query.
     */
    public function test_autocomplete_ignores_empty_query()
    {
        $response = $this->getJson(route('products.autocomplete'));

        $response->assertStatus(200);
        $response->assertJsonCount(0);
    }
}
