<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['totalPrice', 'paymentStatus', 'cart_id', 'userID', 'paymentDate'];

 

    public function Cart()
    {
        return $this->belongsTo('App\Cart', 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }

    public function shipment()
    {
        return $this->hasMany('App\Shipment', 'payment_id');
    }
}
