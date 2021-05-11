<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryCollection;

class CategoryController extends Controller
{
    public function index()
    {
       $categories =  Category::all();

        return new CategoryCollection($categories);
        //return response()->json(['categories' => $categories],200);
    }

    public function show($id)
    {
        if (Category::where('id', $id)->exists()) {
            $category= Category::find($id);

            return new CategoryResource($category);
            //return response()->json(['category' => $category], 200);
        }

        return response()->json(['message' => 'Category not found'], 404);
    }

    public function store(Request $request)
    {
        $input = $request->validate([
            'tag' => 'required'
        ]);

        $category = new Category;
        $category->tag = $input['tag'];
        $category->save();

        return response()->json(['message' => 'Category created with success'], 201);
    }
    
    public function update(Request $request, $id)
    {
        if (Category::where('id', $id)->exists()) {
            $input = $request->validate([
                'tag' => 'required'
            ]);

            $category = Category::find($id);
            $category->tag = $input['tag'];
            $category->save();

            return response()->json(['message' => 'Category updated with success'],200);
        }
        return response()->json(['message' => 'Category not found'], 404);
    }

    public function destroy($id)
    {
        if (Category::where('id', $id)->exists()) {
           $category = Category::find($id);
           $category->delete();

           return response()->json(['message' => 'Category deleted with success'], 200);
        }

        return response()->json(['message' => 'Category not found'], 404); 
    }

    public function getProductsInCategory($id)
    {
        //precisa
        $category = Category::with('products')->find($id);
        //2 forma
        $products = Category::find($id)->products()->get();

        return new CategoryResource($category);
        //return response()->json(['products' => $products], 200);
    }

  
}
