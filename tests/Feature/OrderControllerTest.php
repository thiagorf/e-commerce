<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\Product;
use App\Models\CreditCard;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function the_endpoint_should_return_all_orders()
    {
        $card = CreditCard::factory()->create();
        $orders = Order::factory()->create();
        
        $response = $this->get('/api/orders');

        dd($response->json());
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'orders' => [
                '*' => [
                    'id',
                    'credit_card_id',
                    'user_id',
                    
                ]
            ]
        ]);
        $this->assertDatabaseCount('orders', 1);
    }

    /**
     * @test
     */
    public function the_endpoint_should_order_products_in_cart()
    {
       
        $products = Product::factory()->count(3)->create();
        $order = Order::factory()->create();    
    
        $response = $this->post('/api/orders/' . $order->id . '/products', [
            'productId' => [1,2,3]
        ]);


        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message'
        ]);

        $this->assertDatabaseCount('order_product', 3);


    }
}
