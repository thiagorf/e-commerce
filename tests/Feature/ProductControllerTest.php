<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     * @test 
     */
    public function the_endpoint_should_return_all_products()
    {
        //Arrange
        $product = Product::factory()->create();
        
        //Act
        $response = $this->get('/api/products');

        //Assert
        $this->assertDatabaseCount('products', 1);
        $this->assertDatabaseHas('products', [
            'name' => 'TV',
        ]);
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
        $this->isJson($response);
        $this->assertIsObject($response);
        //$this->assertArrayHasKey('name', $response->content());
        $response->assertStatus(200); // or $data->assertCreated()
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $product->categories);
    }

    /**
     * @test
     */
    public function the_endpoint_should_create_a_post()
    {
        //Arrange
        $categories = Category::factory()->create();

        //Act
        $response = $this->post('/api/products', [
            'name' => 'Nintendo Switch',
            'description' => 'Um console ai',
            'price' => 5000,
            'tags' => [1]
        ]);

        //Assert
        $response->assertStatus(201);
        $a = $this->get('/api/products');
        //dd($a->content()); 
        //$response->assertStatus(201);
        //$this->assertEquals(2, $product->categories->count()); 
        //$this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $product->categories);
        $this->assertDatabaseCount('products', 1);
    }

    /**
     * @test
     */
    public function the_endpoint_should_return_one_product()
    {
        // Arrange
        $product = Product::factory()->create();

        //Act
        $response = $this->get('/api/products/'. $product->id);

        //Assert
        $response->assertJsonStructure([
            'product' => [
                    'id',
                    'name',
                    'description',
                    'price'
            ]
        ]);
        $this->assertCount(1, $response->json());
        //dd(count($response->json()));
    }

    /**
     * @test
     */
    public function the_endpoint_should_update_one_product()
    {
        //Arrange
        $product = Product::factory()->create();
        $category = Category::factory()->create();

        //Act
        $response = $this->put('/api/products/' . $product->id, [
            'name' => 'Nintendo Switch',
            'description' => 'Um console ai',
            'price' => 5000,
            'tags' => [1]
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
    public function the_endpoint_should_delete_one_product()
    {
        //Arrange
        $product = Product::factory()->create();

        //Act
        $response = $this->delete('/api/products/' . $product->id);

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
        $this->assertDatabaseCount('products', 0);
    }
    
    /**
     * @test
     */
    public function the_endpoint_should_return_the_categories_of_one_product()
    {
        //Arrange
        $product = Product::factory()
                        ->has(Category::factory()->count(3))
                        ->create();

        //Act
        $response = $this->get('/api/products/' . $product->id . '/categories');

        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'product' => [
                'id',
                'name',
                'description',
                'price',
                'categories' => [
                    '*' => [
                        'id',
                        'tag'
                    ]
                ]

            ]
        ]);
        
    }

    /**
     * @test
     */
    public function the_endpoint_should_updated_n_categories_in_product()
    {
        //Arrange
        $product = Product::factory()
                            ->has(Category::factory()->count(3))
                            ->create();

        //Act
        $response = $this->put('/api/products/' . $product->id . '/categories', [
            'tag' => [1, 2]
        ]);
        //dd($response->json());
        //Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'message'
        ]);
    }

    /**
     * @test
     */
    public function sort_products_when_querystring_is_defined()
    {
        //Arrange
        $product = Product::factory()->create();
        $secondProduct = Product::factory()
                            ->create([
                                'name' => 'geladeira',
                                'description' => 'Uma geladeira',
                                'price' => 6500
                            ]);
        
        $expect = [
            'products' => [
                0 => $product,
                1 => $secondProduct
            ]
        ];
        //Act
        $response = $this->get('/api/products?sort=g');
        $res = $response->json();
        $sorted = $res['products'][0]['name'];

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
        $this->assertMatchesRegularExpression('/^g/i', $sorted);
    }
    /**
     * @test
     */
    public function sort_products_based_on_tag_selected()
    {
        //Arrange

        //Wrong
        $product = Product::factory()
                            ->has(Category::factory()->count(2))
                            ->create();

        //Act
        $response = $this->get('/api/products?tags[]=1$tags[]=2');

        //Assert
        $response->assertStatus(200);
        //as tags usam o nome delas e não o id
        //dd($response->json());
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
    }
    
    /**
     * @test
     */
    public function sort_should_return_with_all_querystrings()
    {
        //Arrange
        $product = Product::factory()
                            ->has(Category::factory()->count(2))
                            ->create();

        //Act
        $response = $this->get('/api/products?sort=t&tags[]=1');

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

    }
    /**
     * @test
     */
    public function the_endpoint_should_return_all_products_with_categories()
    {
        //Arrange
        $products = Product::factory()
                    ->has(Category::factory()->count(3))
                    ->count(5)
                    ->create();

        //Act
        $response = $this->get('/api/products/categories');

        //Assert
        //dd($response->json());
        $response->assertStatus(200);
        $this->assertDatabaseCount('category_product', 15);
    }
}
