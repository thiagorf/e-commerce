<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/us', function (Request $request) {
//     return $request->user();
//     Route::get('/user', 'ApiController@index');
//     Route::get('/users/{id}', 'ApiController@show');
//     Route::put('/users/{id}', 'ApiController@update');
//     Route::delete('/users/{id}', 'ApiController@destroy');
// });

Route::group(['middleware' => ['auth:sanctum']], function () {
    
    Route::get('/users/{id}', 'ApiController@show');
    Route::put('/users/{id}', 'ApiController@update');
    Route::delete('/users/{id}', 'ApiController@destroy');
    
});

Route::middleware('auth:sanctum')->get('/autenticathe', function () {
    return true;
});

Route::get('/login', 'AuthController@checkLogin');
Route::get('/check/favorites', 'AuthController@checkFavorites');
Route::get('/check/roles', 'AuthController@checkRole');
Route::get('/checkPermission', 'AuthController@checkPermission');
Route::get('/users', 'ApiController@index');

Route::post('/users', 'ApiController@store');
Route::post('/users/login', 'ApiController@enter');

//Route::get('/users/logout', 'ApiController@leave');
Route::get('/logout', 'ApiController@logout');

//LEGENDA * = talvez nao seja necessario

//Products
Route::get('/products/categories', 'ProductController@allProductsWithCategories');
Route::get('/products', 'ProductController@index');
Route::get('/products/{id}', 'ProductController@show');

Route::post('/products', 'ProductController@store');
//Aqui
Route::put('/products/{id}', 'ProductController@update');
Route::delete('/products/{id}', 'ProductController@destroy');


Route::get('/products/{id}/categories', 'ProductController@getProductsCategories');
Route::put('/products/{id}/categories', 'ProductController@updateProductsCategories');

Route::post('/products/{id}/favorites', 'ProductController@addProductToFavorites');


//Categories
Route::get('/categories', 'CategoryController@index');
Route::get('/categories/{id}', 'CategoryController@show');
Route::post('/categories', 'CategoryController@store');
Route::put('/categories/{id}', 'CategoryController@update');
Route::delete('/categories/{id}', 'CategoryController@destroy');

Route::get('/categories/{id}/products', 'CategoryController@getProductsInCategory');


//Cart
Route::get('/carts', 'CartController@index');
Route::get('/carts/{id}', 'CartController@show');

//subresource de cart
Route::post('/carts/{id}/orders', 'CartController@store');// o carrinho que manda o pedido ou ao contrario? um pedido nao existe sem um carrinho
Route::get('/carts/{id}/products', 'CartController@getProductsInCart');
Route::post('/carts/{id}/products', 'CartController@addProductsToCart');
Route::delete('/carts/{id}/products', 'CartController@deleteProductsInCart');


//Orders
//Mudar para Order
//E alterar os endpoints desse resource

Route::get('/orders', 'OrderController@index');
Route::get('/orders/{id}', 'OrderController@show');
Route::post('/orders', 'OrderController@makeOrder');
Route::get('/orders/{id}/products', 'OrderController@get_products');
Route::post('/orders/{id}/products', 'OrderController@orderProducts');// talvez o resource 'carrinho' tenha que assumir esse metodo

//Favorites

Route::get('/favorites', 'FavoritesController@index');
Route::get('/favorites/{id}', 'FavoritesController@show');

Route::get('/favorites/{id}/products', 'FavoritesController@getFavoriteProducts');
Route::post('/favorites/{id}/products', 'FavoritesController@addProductsInFavorite');
Route::delete('/favorites/{id}/products', 'FavoritesController@deleteProductsInFavorite');
//Route::delete('/favorites/{id}/products', 'FavoritesController@teste');

Route::post('/favorites', 'FavoritesController@store');//*
Route::put('/favorites', 'FavoritesController@update');//*
Route::delete('/favorites', 'FavoritesController@destroy');//*

/**
 * Um resource é um equivalente à um model do laravel(resumindo)
 * certos resource precisam de outros resources para poderem fazer sentido
 * como por exemplo um resource 'Book' nao faz sentido se nao existir
 * um resource 'Author'
 * a leitura é a seguinte Book é um subresource de Author
 * Book nao faz sentido existir sem um Author
 * assim como seu endpoint nao ira fazer sentido
 * Ex: POST /books  como voce publica um livro sem o autor?
 *     POST /authors/:id/books o autor x publicou certo livro
 */