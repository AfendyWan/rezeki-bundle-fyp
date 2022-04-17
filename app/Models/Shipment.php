<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shippingOption', 'shippingStatus', 'shippingCourier', 'shippingTrackingNumber', 'payment_id ', 'userID', 'cart_id',
    ];

    public function Cart()
    {
        return $this->belongsTo('App\Cart', 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment', 'payment_id');
    }

    
    public function order()
    {
        return $this->hasMany('App\Order', 'shipmentID');
    }

}
