<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function checkLogin() {
        return auth()->user() ? auth()->user()->cart : false; 
    }

    public function checkFavorites() {
        return auth()->user() ? auth()->user()->favorite : false; 
    }

    public function checkRole()
    {
        return auth()->user() ? auth()->user()->roles : false;
    }
    public function checkPermission()
    {
        if(auth()->user()){
            if(auth()->user()->roles->first()->role == 'admin') return true;
        }else {
            return false;
        }
    }
}
