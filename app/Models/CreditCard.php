<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'credit_cards';

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'credit_card_id');
    }
}
