<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CartItem;
class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['userID ', 'totalPrice', 'cartItemQuantity', 'cartStatus'];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }

    public function cartItem()
    {
        return $this->hasMany('App\Models\CartItem', 'cart_id');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment', 'cart_id');
    }

    public function shipment()
    {
        return $this->hasMany('App\Shipment', 'cart_id');
    }
}
