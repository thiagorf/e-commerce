<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Order;

class CartController extends Controller
{
    public function index()
    {  
        $carts = Cart::all();

        return response()->json(['carts' => $carts], 200);
    }

    public function show($id)
    {
        if (Cart::where('id', $id)->exists()) {
            $cart = Cart::find($id);

            return response()->json(['cart' => $cart], 200);
        }
        return response()->json(['message' => 'Cart not found'], 404);
    }

    public function store(Request $request, $id)
    {

        $cart = Cart::find($id)->products();
        $order = new Order;
        $order->qty = 2;
        $order->user()->associate(1);
        $order->payment()->associate($request->payment);
        $order->save();

        
        for ($i=0; $i < count($request->products); $i++) { 
            $order->products()->attach($request->products[$i]);
        }
        
        return response()->json(['message' => 'Order has been sended'], 200);
    }

    public function getProductsInCart($id)
    {
        $cart = Cart::find($id)->products()->get();

        return response()->json(['products' => $cart], 200);
    }

    public function addProductsToCart(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);
        $cart->products()->attach($request->id);
        
        return response()->json(['message' => 'Product added in shopping cart'], 200);
    }

    public function deleteProductsInCart(Request $request, $id)
    {
        $cart = Cart::find($id);
        $cart->products()->detach($request->id);
        
        return response()->json(['message' => 'Product deleted from cart'], 200);
    }
}
