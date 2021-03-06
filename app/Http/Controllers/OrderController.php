<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'credit_card', 'products'])->get();

        return response()->json(['orders' => $orders], 200);
    }

    public function show($id)
    {
        if(Order::where('id', $id)->exists()){
            $order = Order::find($id);

            return response()->json(['order' => $order], 200);
        }

        return response()-json(['message' => 'Order not found'], 404);
    }

    public function makeOrder(Request $request)
    {
        $order = new Order;
        $order->user()->associate(auth()->user()->id);
        //$order->credit_card()->associate($creditCard->id);
        $order->credit_card()->associate(1);
        $order->save();
        $order->products()->attach($request->productId);
        
        $cartId = auth()->user()->cart->id;
        $cart = Cart::find($cartId);
        $cart->products()->detach($request->productId);

        return response()->json(['message' => 'Products in shopping cart has bem purchase'], 201);
    }
}
