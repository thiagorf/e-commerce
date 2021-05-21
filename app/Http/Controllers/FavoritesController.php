<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    public function index()
    {
        $favorites = Favorite::all();
        return response()->json(['favorites' => $favorites], 200);
    }

    public function show($id)
    {
        $favorite = Favorite::find($id)->get();

        return response()->json(['favorite' => $favorite], 200);
    }

    public function getFavoriteProducts($id)
    {
        $products = Favorite::find($id)->products()->get();

        return response()->json(['products' => $products], 200);
    }

    public function addProductsInFavorite(Request $request, $id)
    {
        $favorite = Favorite::find($id);
        $favorite->products()->attach($request->id);

        return response()->json(['message' => 'Product favorited'], 201);
    }

    public function deleteProductsInFavorite(Request $request, $id)
    {
        
        $favorite = Favorite::find($id);
        $favorite->products()->detach($request->id);
        
        return response()->json(['message' => $request->id], 200);
        //return response()->json(['message' => 'Products removed from favorites'], 200);
        
    }
    public function teste(Request $request, $id)
    {
        //return response()->json(['message' => $request->id]);
        
        $favorite = Favorite::find($id);
        $favorite->products()->detach($request->id);
        
        return response()->json(['message' => 'Products removed from favorites'], 200);
        
    }
}
