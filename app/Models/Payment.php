<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['totalPrice', 'subTotalPrice', 'shippingPrice', 'paymentStatus', 'cart_id', 'order_id', 'userID', 'paymentDate', 'remark'];

 

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

    public function order()
    {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }

}
