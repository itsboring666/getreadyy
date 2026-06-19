<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\CartItem;
use App\Models\UserAddress;
use App\Models\Order;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressBookTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test address book index page.
     */
    public function test_user_can_view_address_book()
    {
        $this->actingAs($this->user);

        // Add a saved address
        UserAddress::create([
            'user_id' => $this->user->id,
            'address_name' => 'Home Base',
            'name' => 'John Wick',
            'phone' => '9876543210',
            'address' => 'Continental Hotel Room 101',
            'city' => 'New York',
            'state' => 'New York',
            'zip' => '10001',
            'is_default' => true
        ]);

        $response = $this->get(route('addresses.index'));
        $response->assertStatus(200);
        $response->assertSee('Home Base');
        $response->assertSee('John Wick');
        $response->assertSee('Continental Hotel Room 101');
    }

    /**
     * Test storing a new address.
     */
    public function test_user_can_store_address()
    {
        $this->actingAs($this->user);

        $response = $this->post(route('addresses.store'), [
            'address_name' => 'Office',
            'name' => 'Thomas Anderson',
            'phone' => '9998887776',
            'address' => 'Meta Cortex Building Floor 4',
            'city' => 'Chicago',
            'state' => 'Illinois',
            'zip' => '60601',
            'is_default' => '1'
        ]);

        $response->assertRedirect(route('addresses.index'));
        $this->assertDatabaseHas('user_addresses', [
            'user_id' => $this->user->id,
            'address_name' => 'Office',
            'name' => 'Thomas Anderson',
            'zip' => '60601',
            'is_default' => 1
        ]);
    }

    /**
     * Test updating an address.
     */
    public function test_user_can_update_address()
    {
        $this->actingAs($this->user);

        $address = UserAddress::create([
            'user_id' => $this->user->id,
            'address_name' => 'Home',
            'name' => 'Neo',
            'phone' => '9998887776',
            'address' => 'Zion Central Chambers',
            'city' => 'Zion',
            'state' => 'Zion',
            'zip' => '400001',
            'is_default' => true
        ]);

        $response = $this->put(route('addresses.update', $address->id), [
            'address_name' => 'Zion Chamber',
            'name' => 'The One',
            'phone' => '9888777666',
            'address' => 'Zion Core Level 3',
            'city' => 'Zion City',
            'state' => 'Zion State',
            'zip' => '400002',
            'is_default' => '1'
        ]);

        $response->assertRedirect(route('addresses.index'));
        $this->assertDatabaseHas('user_addresses', [
            'id' => $address->id,
            'address_name' => 'Zion Chamber',
            'name' => 'The One',
            'zip' => '400002'
        ]);
    }

    /**
     * Test deleting an address.
     */
    public function test_user_can_delete_address()
    {
        $this->actingAs($this->user);

        $address = UserAddress::create([
            'user_id' => $this->user->id,
            'address_name' => 'Temp',
            'name' => 'Smith',
            'phone' => '9998887776',
            'address' => 'Matrix Void System Area',
            'city' => 'Matrix',
            'state' => 'Matrix',
            'zip' => '500001',
            'is_default' => false
        ]);

        $response = $this->delete(route('addresses.destroy', $address->id));
        $response->assertRedirect(route('addresses.index'));
        $this->assertDatabaseMissing('user_addresses', [
            'id' => $address->id
        ]);
    }

    /**
     * Test setting an address as default.
     */
    public function test_user_can_set_default_address()
    {
        $this->actingAs($this->user);

        $address1 = UserAddress::create([
            'user_id' => $this->user->id,
            'address_name' => 'First',
            'name' => 'Morpheus',
            'phone' => '9998887776',
            'address' => 'Nebuchadnezzar Deck A',
            'city' => 'Zion',
            'state' => 'Zion',
            'zip' => '400001',
            'is_default' => true
        ]);

        $address2 = UserAddress::create([
            'user_id' => $this->user->id,
            'address_name' => 'Second',
            'name' => 'Trinity',
            'phone' => '9888777666',
            'address' => 'Nebuchadnezzar Deck B',
            'city' => 'Zion',
            'state' => 'Zion',
            'zip' => '400001',
            'is_default' => false
        ]);

        $response = $this->post(route('addresses.default', $address2->id));
        $response->assertRedirect(route('addresses.index'));

        // Assert address2 is now default, and address1 is not
        $this->assertEquals(0, $address1->refresh()->is_default);
        $this->assertEquals(1, $address2->refresh()->is_default);
    }

    /**
     * Test checkout page loads saved addresses.
     */
    public function test_checkout_loads_addresses()
    {
        // Add a product & cart item to allow loading checkout
        $category = \App\Models\Category::firstOrCreate(
            ['slug' => 'test-essentials'],
            ['name' => 'Test Essentials', 'status' => 'active', 'image' => 'test.jpg']
        );

        $product = Product::create([
            'name' => 'Test Item',
            'category_id' => $category->id,
            'description' => 'A test item.',
            'status' => 'active',
            'image' => 'test.jpg'
        ]);

        ProductSize::create([
            'product_id' => $product->id,
            'size' => 'M',
            'price' => 500.00,
            'stock' => 10
        ]);

        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'size' => 'M',
            'quantity' => 1
        ]);

        // Add saved address
        UserAddress::create([
            'user_id' => $this->user->id,
            'address_name' => 'Home Coordinates',
            'name' => 'Sherlock Holmes',
            'phone' => '9876543210',
            'address' => '221B Baker Street',
            'city' => 'London',
            'state' => 'London',
            'zip' => '500001',
            'is_default' => true
        ]);

        $this->actingAs($this->user);

        $response = $this->get(route('checkout'));
        $response->assertStatus(200);
        $response->assertSee('HOME COORDINATES');
        $response->assertSee('Sherlock Holmes');
    }

    /**
     * Test checkout processes and saves address to address book.
     */
    public function test_checkout_saves_address_to_address_book()
    {
        $category = \App\Models\Category::firstOrCreate(
            ['slug' => 'test-essentials'],
            ['name' => 'Test Essentials', 'status' => 'active', 'image' => 'test.jpg']
        );

        $product = Product::create([
            'name' => 'Test Item',
            'category_id' => $category->id,
            'description' => 'A test item.',
            'status' => 'active',
            'image' => 'test.jpg'
        ]);

        ProductSize::create([
            'product_id' => $product->id,
            'size' => 'M',
            'price' => 500.00,
            'stock' => 10
        ]);

        CartItem::create([
            'user_id' => $this->user->id,
            'product_id' => $product->id,
            'size' => 'M',
            'quantity' => 1
        ]);

        $this->actingAs($this->user);

        // Submit checkout with save_address = 1 and address_name = 'HQ'
        $response = $this->post(route('checkout.process'), [
            'name' => 'Bruce Wayne',
            'email' => 'bruce@waynecorp.com',
            'phone' => '9998887776',
            'address' => 'Wayne Manor, Batcave Level 1',
            'city' => 'Gotham',
            'state' => 'New Jersey',
            'zip' => '535401',
            'payment_method' => 'cod',
            'save_address' => '1',
            'address_name' => 'Batcave'
        ]);

        $response->assertRedirect();
        
        // Assert address was saved to database
        $this->assertDatabaseHas('user_addresses', [
            'user_id' => $this->user->id,
            'address_name' => 'Batcave',
            'name' => 'Bruce Wayne',
            'zip' => '535401',
            'is_default' => 1
        ]);

        // Assert order was placed successfully
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'name' => 'Bruce Wayne',
            'status' => 'paid' // COD order
        ]);
    }
}
