<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use App\Models\Favorite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class ApiController extends Controller
{

    public function index()
    {            
        $users = User::with('orders.products')->get();

        return response()->json(['users' => $users], 200);
    }

    public function show($id)
    {            
        if(User::where('id', $id)->exists()){
            $user = User::find($id);
            return response()->json($user, 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function store(Request $request)
    {            
        $input = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);
        $user = new User;
        $user->name = $input['name'];
        $user->email = $input['email'];
        $user->password = Hash::make($input['password']);
        $user->save();

        $cart = new Cart;
        $cart->user()->associate($user);
        $cart->save();

        $favorite = new Favorite;
        $favorite->user()->associate($user);
        $favorite->save();
        
        
        return response()->json(['message' => 'User created with success'], 201);
    }


    public function update(Request $request, $id)
    {      
             
        $user = User::find($id);
        $user->name = $request->name;
        $user->save();

        return response()->json(['message' => 'User has been updated'], 200);
    }

    public function destroy($id)
    {            
        $user = User::find($id);
        $user->delete();

        return response()->json(['message' => 'User has been deleted '], 200);
    }
    
    public function enter(Request $request) 
    {
        $credentials = $request->only('email', 'password');

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $token = $request->user()->createToken('teste')->plainTextToken;
            return response()->json(['message'=> 'user login', 'token' => $token]);
        }

        return response()->json(['message' => 'Credentials denied']);
    }   

    public function leave(Request $request)
    {
        if (Auth::check()){
            $request->user()->currentAccessToken()->delete();
            
            Auth::guard('web')->logout();
            $request->session()->invalidate();
        }
        
        
        return response()->json(['message' => 'Done'], 200);
    }
    
    public function logout(Request $request)
    {
        if(Auth::check()){
            $request->user()->tokens()->delete();
            Auth::guard('web')->logout();
            return response()->json(['message' => 'Done'], 200);
        }
        
        return response()->json(['message' => 'not logged'], 200);
    }
}
