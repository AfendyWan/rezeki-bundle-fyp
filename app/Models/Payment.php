<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = ['totalPrice', 'paymentStatus', 'cart_id', 'sale_item_id', 'userID', 'paymentDate'];

    public function saleItem()
    {
        return $this->belongsTo('App\SaleItem', 'sale_item_id');
    }

    public function Cart()
    {
        return $this->belongsTo('App\Cart', 'cart_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }
}
