<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'credit_card_id'
    // ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function credit_card()
    {
        return $this->belongsTo('App\Models\CreditCard', 'credit_card_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'order_product');
    }

    
}
