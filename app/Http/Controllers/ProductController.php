<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if (!Cache::has('product')) {
            Cache::put('product', Product::all(), 60);
        }
        $products = Cache::get('product');

        // Possivel refatoração do codigo abaixo
        
        if ($request->has('sort') && $request->has('tags')) {
            $sort = "{$request->query('sort')}%";
            $tag = $request->query('tags');
            $products = Product::where('name', 'like', $sort)
                            ->whereHas('categories', function ($query) use ($tag){
                                $query->whereIn('tag', $tag);
                            })->get();

            
            return new ProductCollection($products);
        }
        if ($request->has('sort')) {
            $sort = "{$request->query('sort')}%";
            $products = Product::where('name', 'like', $sort)->get();

            
            return new ProductCollection($products);
        }
        if ($request->has('tags')) {
            $tag = $request->query('tags');
            
            $products = Product::whereHas('categories', function ($query) use ($tag){
                $query->whereIn('tag', $tag);
            })->get();;
           
            return new ProductCollection($products);
        }
        //Até aqui
        
        $p = Product::all();

        return new ProductCollection($p);
        //return response()->json(['products' => $products], 200);
    }

    public function show($id)
    {
        if(Product::where('id', $id)->exists()) {
            $product = Product::with('categories')->find($id);
            
            return new ProductResource($product);
            //return response()->json(['product' => $product], 200);
        }
        
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function allProductsWithCategories()
    {
        $products = Product::with('categories')->get();

        return response()->json(['products' => $products], 200);
    }

    public function store(Request $request)
    {
       
        $input = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'tags' => 'required'
        ]);
        //O produto deve possuir alguma categorias pra ser criado
        $product = new Product;
        $product->name = $input['name'];
        $product->description = $input['description'];
        $product->price = $input['price'];
        $product->save();
        foreach($request->tags as $tag){
            $product->categories()->attach($tag);
        }
        

        return response()->json(['message' => 'Product created'], 201);
    }

    public function update(Request $request, $id)
    {
        if (Product::where('id', $id)->exists()) {
            $input = $request->validate([
                'name' => 'required',
                'description' => 'required',
                'price' => 'required',
                'tags' => 'required'
            ]);
            
            $product = Product::find($id);
            $product->name = $input['name'];
            $product->description = $input['description'];
            $product->price = $input['price'];
            $product->save();

            $data = [];
            for ($i=0; $i < count($request->tags); $i++) { 
                array_push($data, $request->tags[$i]);
            }

            $product->categories()->sync($data);

            return response()->json(['message' => 'Product updated']);
        }
        
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function destroy($id)
    {
        if (Product::where('id', $id)->exists()) {
            $product = Product::find($id);
            $product->delete();

            return response()->json(['message' => 'Product has been deleted'], 200);
        }
        
        return response()->json(['message' => 'Product not found'], 404);
    }

    public function getProductsCategories($id)
    {
        //old name getCategories
        if (Product::where('id', $id)->exists()) {
            $product = Product::with('categories')->find($id);
            //opçao numero 2
            //isso substitui a necessidade de chamar a relaçao na hora de retornar para o front
            //Ex: $products->categories
            //$categories = Product::find($id)->categories()->get();
            $categories = Product::with('categories')->find($id);
            //retornar o produto completo ou so as categorias?

            return new ProductResource($categories);
            //return new CategoriesCollection($categories);
            //return response()->json(['categories' => $categories], 200);
        }
        
        return response()->json(['message' => 'Product not found'], 404);
    }




    //DELETAR ABAIXO?

    public function createCategories(Request $request, $id)
    {
        //Produto nao pode existir sem categoria
        //excluir?

        if (Product::where('id', $id)->exists()) {
           $tags = $request->input('tag');

           $product = Product::find($id);
           
           foreach ($tags as $tag) {
                $product->categories()->attach($tag->id);
                $product->save();
           }

           return response()->json(['message' => 'Categories created in product'], 201);
        }

        return response()->json(['message' => 'Product not found']);
    }

    public function updateProductsCategories(Request $request, $id)
    {
        //necessario!!
        if (Product::where('id', $id)->exists()) {
            $tags = $request->input('tag');
            $data = [];
            
            $product = Product::with('categories')->find($id);
        
            foreach ($tags as $tag) {
                array_push($data, $tag);
            }
            
            $product->categories()->sync($data);

            return response()->json(['message' => 'Categories updated in product'], 200);
         }
 
         return response()->json(['message' => 'Product not found']);
    }

    // public function addProductToFavorites(Request $request, $id)
    // {

    // }
}
