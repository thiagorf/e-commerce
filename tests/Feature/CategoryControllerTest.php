<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Product;

class CategoryControllerTest extends TestCase
{
    use RefreshDatabase;
    // 6 endpoints
    /**
     * A basic feature test example.
     *
     * @return void
     * @test
     */
    public function the_endpoint_should_return_all_categories()
    {
        //Arrange
        $categories = Category::factory()->count(3)->create();

        //Act
        $response = $this->get('/api/categories');

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'categories' => [
                '*' => [
                    'id',
                    'tag'
                ]
            ]
        ]);
        $this->assertDatabaseCount('categories', 3);
    }

    /**
     * @test
     */
    public function the_endpoint_should_return_one_category()
    {
        //Arrange
        $category = Category::factory()->create();

        //Act
        $response = $this->get('/api/categories/' . $category->id);

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'category' => [
                'id',
                'tag'
            ]
        ]);
    }

    /**
     * @test
     */
    public function the_endpoint_should_create_one_category()
    {
        //Arrange
        //Act
        $response = $this->post('/api/categories', [
            'tag' => 'Eletronico'
        ]);

        //Assert
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseCount('categories', 1);
    }

    /**
     * @test
     */
    public function the_endpoint_should_updated_one_category()
    {
        //Arrange
        $category = Category::factory()->create();

        //Act
        $response = $this->put('/api/categories/' . $category->id, [
            'tag' => 'eletronicos'
        ]);

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseHas('categories', [
            'tag' => 'eletronicos',
        ]);
    }

    /**
     * @test
     */
    public function the_endpoint_should_delete_one_category()
    {
        //Arraange
        $category = Category::factory()->create();

        //Act
        $response = $this->delete('/api/categories/' . $category->id);

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseCount('categories', 0);
    }

    /**
     * @test
     */
    public function the_endpoint_should_return_all_products_in_category()
    {
        //Arrange
        $category = Category::factory()
                            ->has(Product::factory()->count(3))
                            ->create();

        //Act
        $response = $this->get('/api/categories/' . $category->id . '/products');

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'category' => [
                'id',
                'tag',
                'products' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'price'
                    ]
                ]
                
            ]
        ]);
    }
}
