<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Cart;
use App\Models\Product;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function the_endpoint_should_return_all_carts()
    {
        //Arrange
        $carts = Cart::factory()->create();
        
        //Act
        $response = $this->get('/api/carts');

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'carts' => [
                '*' => [
                    'id',
                    'user_id'
                ]
            ]
        ]);
        $this->assertDatabaseCount('users', 1);
    }

    /**
     * @test
     */
    public function the_endpoint_should_return_one_cart()
    {
        //Arrange
        $cart = Cart::factory()->create();

        //Act
        $response = $this->get('/api/carts/' . $cart->id);

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'cart' => [
                'id',
                'user_id'
            ]
        ]);
        //olhar a tabela pivot
        $this->assertDatabaseCount('carts', 1);
    }

    /**
     * @test
     */
    public function the_endpoint_should_return_all_products_in_cart()
    {
        //Arrange
        $cart = Cart::factory()
                    ->has(Product::factory()->count(3))
                    ->create();
        
        //Act
        $response = $this->get('/api/carts/'. $cart->id . '/products');

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'products' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'price'
                ]
            ]
        ]);
        $this->assertDatabaseCount('carts', 1);
        $this->assertDatabaseCount('products', 3);
    }

    /**
     * @test
     */
    public function the_endpoint_should_associate_products_in_cart()
    {
        //Arrange
        $cart = Cart::factory()->create();
        $product = Product::factory()->create();

        //Act
        $response = $this->post('/api/carts/' . $cart->id . '/products', [
            'id' => $product->id
        ]);

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);

    }

    /**
     * @test
     */
    public function the_endpoint_should_delete_products_in_cart()
    {
        //Arrange
        $cart = Cart::factory()
                    ->has(Product::factory()->count(3))
                    ->create();

        //Act
        $response = $this->delete('/api/carts/' . $cart->id . '/products', [
            'id' => 1
        ] );

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseCount('cart_item', 2);
    }
}
