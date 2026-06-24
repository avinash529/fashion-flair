<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_saved_address_is_selected_without_showing_new_address_fields(): void
    {
        $user = User::factory()->create();
        $user->addresses()->create($this->addressPayload());
        $product = $this->createProduct();

        $response = $this
            ->actingAs($user)
            ->withSession(['cart' => $this->cartFor($product)])
            ->get(route('checkout.index'));

        $response->assertOk();
        $response->assertSee('data-new-address-panel hidden', false);
    }

    public function test_saved_address_can_be_used_without_reentering_shipping_fields(): void
    {
        $user = User::factory()->create();
        $address = $user->addresses()->create($this->addressPayload());
        $product = $this->createProduct();

        $response = $this
            ->actingAs($user)
            ->withSession(['cart' => $this->cartFor($product)])
            ->post(route('checkout.store'), [
                'address_id' => $address->id,
                'payment_method' => 'cod',
            ]);

        $order = Order::firstOrFail();

        $response->assertRedirect(route('orders.show', $order));
        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'user_id' => $user->id,
            'ship_name' => 'Test Receiver',
            'ship_phone' => '+91 98765 43210',
            'ship_line1' => '123 Fashion Street',
            'ship_city' => 'Mumbai',
            'ship_state' => 'Maharashtra',
            'ship_pincode' => '400001',
        ]);
        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
    }

    private function createProduct(): Product
    {
        $category = Category::create([
            'name' => 'Dresses',
            'slug' => 'dresses',
        ]);

        return Product::create([
            'name' => 'Silk Dress',
            'slug' => 'silk-dress',
            'price' => 1299,
            'category_id' => $category->id,
            'stock_qty' => 5,
            'is_active' => true,
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function addressPayload(): array
    {
        return [
            'name' => 'Test Receiver',
            'phone' => '+91 98765 43210',
            'line1' => '123 Fashion Street',
            'line2' => 'Near Market',
            'city' => 'Mumbai',
            'state' => 'Maharashtra',
            'pincode' => '400001',
        ];
    }

    /**
     * @return array<string, array<string, int>>
     */
    private function cartFor(Product $product): array
    {
        return [
            'product-'.$product->id => [
                'product_id' => $product->id,
                'quantity' => 1,
            ],
        ];
    }
}
