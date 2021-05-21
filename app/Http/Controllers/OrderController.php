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
        //check if credit card exist
        //and change payment table
        //order table too
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

   /*public function orderProducts(Request $request, $id)
    {
        /**
         * Fluxo de compra
         *
         * todos os produtos do carrinho, ou apenas os selecionados
         * sao retirados do mesmo e é captado seu id
         * o pedido entao é associado com os id dos produtos selecionados
         * se houver cartao registrado, ele é utilizado, se não
         * será criado um,
         
        
        
        //VERIFICAR A NECESSIDADE

        //validacao
        //algo do genero
        
        //$purchase = Order::find($id);
        //verificar o nome da relação compra x carrinho
        //$purchase->shopping_carts()->associate($request->id);
        //$purchase->save();

        //$input = $request->validate(['id' => 'required']);

        //Criar o cartao de credito caso não exista, fazer essa verificação

        $productsId = $request->productId;
        $order = new Order;
        //$order->qty = 3;
        $order->user()->associate(1);
        $order->credit_card()->associate(1);
        $order->save();
        //request vai receber um array de valores
        //tirar todo produto do carrinho que foi 'comprado'
        $order->products()->attach($productsId);


        return response()->json(['message' => 'Products in shopping cart has bem purchase'], 201);
    }*/
}
