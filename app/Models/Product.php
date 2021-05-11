<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'description', 
        'price'
    ];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function carts()
    {
        return $this->belongsToMany('App\Models\Cart', 'cart_item');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

    public function favorites()
    {
        return $this->belongsToMany('App\Models\Favorite', 'favorite_item');
    }
    
}
