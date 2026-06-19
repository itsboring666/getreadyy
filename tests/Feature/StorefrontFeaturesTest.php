<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\Review;
use App\Models\Wishlist;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StorefrontFeaturesTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $product;

    protected function setUp(): void
    {
        parent::setUp();

        // Create or get user
        $this->user = User::factory()->create();

        // Create a product with category and size for checkout & pricing tests
        $category = \App\Models\Category::firstOrCreate(
            ['slug' => 'test-essentials'],
            ['name' => 'Test Essentials', 'status' => 'active', 'image' => 'test.jpg']
        );

        $this->product = Product::create([
            'name' => 'Test Editorial Tee',
            'category_id' => $category->id,
            'description' => 'A test vintage graphic tee.',
            'status' => 'active',
            'image' => 'test.jpg'
        ]);

        ProductSize::create([
            'product_id' => $this->product->id,
            'size' => 'M',
            'price' => 500.00,
            'stock' => 50
        ]);
    }

    /**
     * Test Shipping Cost Calculation: ₹99 for subtotal < ₹999.
     */
    public function test_shipping_cost_for_order_under_999()
    {
        // Add 1 item of size M (price 500.00) to cart -> subtotal = 500.00
        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'size' => 'M',
            'quantity' => 1
        ]);

        $this->actingAs($this->user);

        $response = $this->get(route('checkout'));
        $response->assertStatus(200);
        $response->assertViewHas('subtotal', 500.00);
        $response->assertViewHas('shipping', 99.00);
        $response->assertViewHas('grandTotal', 599.00);
    }

    /**
     * Test Shipping Cost Calculation: Free shipping (₹0) for subtotal >= ₹999.
     */
    public function test_shipping_cost_for_order_over_999()
    {
        // Add 2 items of size M (price 500.00 each) to cart -> subtotal = 1000.00
        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'size' => 'M',
            'quantity' => 2
        ]);

        $this->actingAs($this->user);

        $response = $this->get(route('checkout'));
        $response->assertStatus(200);
        $response->assertViewHas('subtotal', 1000.00);
        $response->assertViewHas('shipping', 0.00);
        $response->assertViewHas('grandTotal', 1000.00);
    }

    /**
     * Test Wishlist Toggle.
     */
    public function test_wishlist_add_and_remove()
    {
        $this->actingAs($this->user);

        // Toggle add to wishlist
        $response = $this->post(route('wishlist.toggle', $this->product->id));
        $response->assertRedirect();
        
        $this->assertDatabaseHas('wishlists', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id
        ]);

        // Toggle remove from wishlist
        $response = $this->post(route('wishlist.toggle', $this->product->id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('wishlists', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id
        ]);
    }

    /**
     * Test Coupon Codes Application (GET20 - 20% discount).
     */
    public function test_coupon_discount_percent()
    {
        // Create Coupon
        Coupon::updateOrCreate(
            ['code' => 'GET20'],
            [
                'type' => 'percent',
                'value' => 20.00,
                'min_order_value' => 400.00,
                'is_active' => true
            ]
        );

        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'size' => 'M',
            'quantity' => 1 // subtotal 500
        ]);

        $this->actingAs($this->user);

        $response = $this->post(route('checkout.apply-coupon'), [
            'coupon_code' => 'GET20'
        ]);

        $response->assertRedirect();
        $this->assertEquals('GET20', session('applied_coupon'));

        // View checkout to assert pricing with discount
        $response = $this->get(route('checkout'));
        $response->assertViewHas('discountAmount', 100.00); // 20% of 500
        $response->assertViewHas('grandTotal', 499.00); // 500 subtotal + 99 shipping - 100 discount
    }

    /**
     * Test Coupon Codes Application (FLAT150 - flat 150 discount).
     */
    public function test_coupon_discount_flat()
    {
        Coupon::updateOrCreate(
            ['code' => 'FLAT150'],
            [
                'type' => 'fixed',
                'value' => 150.00,
                'min_order_value' => 400.00,
                'is_active' => true
            ]
        );

        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'size' => 'M',
            'quantity' => 1 // subtotal 500
        ]);

        $this->actingAs($this->user);

        $response = $this->post(route('checkout.apply-coupon'), [
            'coupon_code' => 'FLAT150'
        ]);

        $response->assertRedirect();
        $this->assertEquals('FLAT150', session('applied_coupon'));

        // View checkout to assert pricing
        $response = $this->get(route('checkout'));
        $response->assertViewHas('discountAmount', 150.00);
        $response->assertViewHas('grandTotal', 449.00); // 500 + 99 - 150
    }

    /**
     * Test Product Review submission and calculation.
     */
    public function test_product_review_submission_and_rating()
    {
        $this->actingAs($this->user);

        // Submit review
        $response = $this->post(route('reviews.store', $this->product->id), [
            'rating' => 5,
            'comment' => 'This is a premium product.'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $this->user->id,
            'product_id' => $this->product->id,
            'rating' => 5,
            'comment' => 'This is a premium product.'
        ]);

        // Submit review from a second user to test average calculation
        $user2 = User::factory()->create();
        $this->actingAs($user2);

        $response = $this->post(route('reviews.store', $this->product->id), [
            'rating' => 3,
            'comment' => 'Decent quality but could be softer.'
        ]);

        $response->assertRedirect();

        // Get product details page
        $response = $this->get(route('product.view', $this->product->id));
        $response->assertStatus(200);

        // Assert average rating is 4.0
        $product = Product::with('reviews')->find($this->product->id);
        $this->assertEquals(4.0, round($product->reviews->avg('rating'), 1));
        
        // Assert reviews lists both comments
        $response->assertSee('This is a premium product.');
        $response->assertSee('Decent quality but could be softer.');
    }

    /**
     * Test adding a product from the admin dashboard with size and image.
     */
    public function test_admin_can_add_product_with_image()
    {
        $this->user->user_type = 'admin';
        $this->user->save();

        $this->actingAs($this->user);

        // Mock upload file
        \Illuminate\Support\Facades\Storage::fake('public');
        $file = \Illuminate\Http\UploadedFile::fake()->create('new_tee.jpg', 100, 'image/jpeg');

        $response = $this->post(route('admin.products.store'), [
            'name' => 'Admin New Tee',
            'category_id' => 1,
            'description' => 'Fine print cotton tee.',
            'status' => 'active',
            'image' => $file,
            'sizes' => [
                ['size' => 'S', 'price' => 499.00, 'stock' => 10],
                ['size' => 'M', 'price' => 499.00, 'stock' => 20],
                ['size' => 'L', 'price' => 549.00, 'stock' => 15],
                ['size' => 'XL', 'price' => 549.00, 'stock' => 5],
            ]
        ]);

        $response->assertRedirect();
        
        $this->assertDatabaseHas('products', [
            'name' => 'Admin New Tee',
            'status' => 'active',
        ]);

        $product = Product::where('name', 'Admin New Tee')->first();
        $this->assertNotNull($product->image);
        
        // Assert the file is stored
        \Illuminate\Support\Facades\Storage::disk('public')->assertExists($product->image);
    }
}
