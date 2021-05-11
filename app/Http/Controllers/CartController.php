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

        //$cart = Cart::where('user_id', auth()->user()->id)->get(); 
        // nao faz muito sentido esse metodo para o carrinho
        // ao criar conta um carrinho é criado e vinculado a ela?
    }

    public function getProductsInCart($id)
    {
        // old name cartProducts
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
        // $request->idp provavelmente
        //para deletetar um produto é necessario do id do produto
        //e do carrinho q ele esta presente
        //se o usaurio com id 1 quiser deletar algum produto em seu carrinho

        
        //abaixo um metodo quer facilita a busca de dados presente entre tabelas
        $cart = Cart::find($id);
        $cart->products()->detach($request->id);
        
        return response()->json(['message' => 'Product deleted from cart'], 200);
    }
}
