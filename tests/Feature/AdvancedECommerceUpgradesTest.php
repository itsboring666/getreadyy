<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentLog;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdvancedECommerceUpgradesTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;
    protected $adminUser;
    protected $category;
    protected $product1;
    protected $product2;
    protected $product3;

    protected function setUp(): void
    {
        parent::setUp();

        // Users
        $this->user = User::factory()->create(['user_type' => 'customer']);
        $this->adminUser = User::factory()->create(['user_type' => 'admin']);

        // Category
        $this->category = Category::firstOrCreate(
            ['slug' => 'heritage-tees'],
            ['name' => 'Heritage Tees', 'status' => 'active', 'image' => 'heritage.jpg']
        );

        // Products for Outfit Builder (need at least 3)
        $this->product1 = Product::create([
            'name' => 'Vintage Oversized Shirt',
            'category_id' => $this->category->id,
            'description' => 'vintage shirt',
            'status' => 'active',
            'image' => 'shirt.jpg'
        ]);
        ProductSize::create([
            'product_id' => $this->product1->id,
            'size' => 'M',
            'price' => 1200.00,
            'stock' => 15
        ]);

        $this->product2 = Product::create([
            'name' => 'Classic Denim Jeans',
            'category_id' => $this->category->id,
            'description' => 'jeans',
            'status' => 'active',
            'image' => 'jeans.jpg'
        ]);
        ProductSize::create([
            'product_id' => $this->product2->id,
            'size' => 'L',
            'price' => 1500.00,
            'stock' => 20
        ]);

        $this->product3 = Product::create([
            'name' => 'Printed Leather Jacket',
            'category_id' => $this->category->id,
            'description' => 'jacket',
            'status' => 'active',
            'image' => 'jacket.jpg'
        ]);
        ProductSize::create([
            'product_id' => $this->product3->id,
            'size' => 'S',
            'price' => 3500.00,
            'stock' => 5
        ]);
    }

    /**
     * Test Razorpay redirect on checkout.
     */
    public function test_razorpay_gateway_mock_checkout_redirect()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_id' => 'ORD-' . time() . rand(100, 999),
            'name' => 'Kathir',
            'email' => 'kathir@example.com',
            'phone' => '9876543210',
            'address' => '123 Retro St',
            'city' => 'Vintage City',
            'state' => 'VC',
            'zip' => '123456',
            'shipping_fee' => 0.00,
            'discount_amount' => 0.00,
            'total_amount' => 1200.00,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->user)
            ->get(route('checkout.razorpay', ['orderId' => $order->order_id]));

        $response->assertStatus(200);
        $response->assertSee('RAZORPAY PAYMENT GATEWAY');
        $response->assertSee($order->order_id);
    }

    /**
     * Test Razorpay sandbox processing and payment log generation.
     */
    public function test_razorpay_gateway_mock_checkout_completion()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_id' => 'ORD-' . time() . rand(100, 999),
            'name' => 'Kathir',
            'email' => 'kathir@example.com',
            'phone' => '9876543210',
            'address' => '123 Retro St',
            'city' => 'Vintage City',
            'state' => 'VC',
            'zip' => '123456',
            'shipping_fee' => 0.00,
            'discount_amount' => 0.00,
            'total_amount' => 1200.00,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($this->user)
            ->post(route('checkout.razorpay.process', ['orderId' => $order->order_id]), [
                'razorpay_payment_id' => 'pay_mock_' . uniqid(),
                'razorpay_order_id' => 'order_mock_' . uniqid(),
                'razorpay_signature' => 'sig_mock_' . uniqid()
            ]);

        $response->assertRedirect(route('checkout.thankyou', ['orderId' => $order->order_id]));

        // Check database
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid'
        ]);

        $this->assertDatabaseHas('payment_logs', [
            'order_id' => $order->id,
            'payment_gateway' => 'razorpay',
            'status' => 'successful',
            'amount' => 1200.00
        ]);
    }

    /**
     * Test user order cancellation request and admin approvals.
     */
    public function test_user_cancellation_request_and_admin_approval_and_rejection()
    {
        // 1. Setup Order
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_id' => 'ORD-' . time() . rand(100, 999),
            'name' => 'Kathir',
            'email' => 'kathir@example.com',
            'phone' => '9876543210',
            'address' => '123 Retro St',
            'city' => 'Vintage City',
            'state' => 'VC',
            'zip' => '123456',
            'shipping_fee' => 0.00,
            'discount_amount' => 0.00,
            'total_amount' => 1200.00,
            'status' => 'paid'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product1->id,
            'product_name' => $this->product1->name,
            'size' => 'M',
            'quantity' => 2,
            'price' => 1200.00
        ]);

        // Stock initial state is 15
        $size = $this->product1->sizes->firstWhere('size', 'M');
        $this->assertEquals(15, $size->stock);

        // 2. User Cancellation Request
        $response = $this->actingAs($this->user)
            ->post(route('orders.cancel', ['orderId' => $order->order_id]));

        $response->assertRedirect();
        
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'cancel_requested'
        ]);

        // 3. Admin Rejects Request
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.orders.requests.reject', ['id' => $order->id]));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'paid'
        ]);

        // 4. Request Cancel Again
        $this->actingAs($this->user)
            ->post(route('orders.cancel', ['orderId' => $order->order_id]));

        // 5. Admin Approves Cancel
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.orders.requests.approve', ['id' => $order->id]));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'cancelled'
        ]);

        // Check stock is restored (+2)
        $size->refresh();
        $this->assertEquals(17, $size->stock);

        // Check refund payment log
        $this->assertDatabaseHas('payment_logs', [
            'order_id' => $order->id,
            'payment_gateway' => 'razorpay',
            'status' => 'refunded'
        ]);
    }

    /**
     * Test user order return request and admin approvals.
     */
    public function test_user_return_request_and_admin_approval_and_rejection()
    {
        $order = Order::create([
            'user_id' => $this->user->id,
            'order_id' => 'ORD-' . time() . rand(100, 999),
            'name' => 'Kathir',
            'email' => 'kathir@example.com',
            'phone' => '9876543210',
            'address' => '123 Retro St',
            'city' => 'Vintage City',
            'state' => 'VC',
            'zip' => '123456',
            'shipping_fee' => 0.00,
            'discount_amount' => 0.00,
            'total_amount' => 1200.00,
            'status' => 'delivered'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $this->product2->id,
            'product_name' => $this->product2->name,
            'size' => 'L',
            'quantity' => 1,
            'price' => 1500.00
        ]);

        $size = $this->product2->sizes->firstWhere('size', 'L');
        $this->assertEquals(20, $size->stock);

        // User Return Request
        $response = $this->actingAs($this->user)
            ->post(route('orders.return', ['orderId' => $order->order_id]));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'return_requested'
        ]);

        // Admin Rejects Return
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.orders.requests.reject', ['id' => $order->id]));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'delivered'
        ]);

        // User Request Return Again
        $this->actingAs($this->user)
            ->post(route('orders.return', ['orderId' => $order->order_id]));

        // Admin Approves Return
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.orders.requests.approve', ['id' => $order->id]));

        $response->assertRedirect();
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'returned'
        ]);

        // Check stock is restored (+1)
        $size->refresh();
        $this->assertEquals(21, $size->stock);
    }

    /**
     * Test Outfit Builder page rendering, category filter, and slot locks.
     */
    public function test_outfit_builder_rendering_and_filtering_and_locking()
    {
        // View Outfit Builder without params
        $response = $this->get(route('outfit-builder'));
        $response->assertStatus(200);
        $response->assertSee('THE <span class="highlight">OUTFIT</span> WHEEL', false);

        // View with category filter
        $response = $this->get(route('outfit-builder') . '?category_id=' . $this->category->id);
        $response->assertStatus(200);
        $response->assertSee($this->product1->name);

        // View with locks
        $response = $this->get(route('outfit-builder') . '?lock_top=' . $this->product1->id . '&lock_bottom=' . $this->product2->id);
        $response->assertStatus(200);
        // Make sure both products are visible in response
        $response->assertSee($this->product1->name);
        $response->assertSee($this->product2->name);
    }

    /**
     * Test admin dashboard analytics charts.
     */
    public function test_admin_dashboard_charts_analytics()
    {
        // 1. Unauthenticated or Customer should be redirected/unauthorized (403 Forbidden)
        $response = $this->actingAs($this->user)
            ->get(route('admin.dashboard'));
        $response->assertStatus(403);

        // 2. Admin should get dashboard page with sales data & category popularity
        $response = $this->actingAs($this->adminUser)
            ->get(route('admin.dashboard'));
        
        $response->assertStatus(200);
        $response->assertViewHas('salesData');
        $response->assertViewHas('categoryPopularity');
    }
}
