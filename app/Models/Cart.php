<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['userID ', 'totalPrice', 'cartStatus'];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }

    public function cartItem()
    {
        return $this->hasMany('App\CartItem', 'cart_id');
    }
}
