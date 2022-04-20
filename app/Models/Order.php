<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['orderDate', 'userID', 'paymentID', 'shipmentID', 'orderStatus', 'order_number'];

    public function orderItem()
    {
        return $this->hasMany('App\OrderItem', 'order_id');
    }

    public function shipment()
    {
        return $this->belongsTo('App\Shipment', 'shipmentID');
    }

    public function payment()
    {
        return $this->belongsTo('App\Payment', 'paymentID');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }
}
