<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['quantity ', 'cart_id ', 'sale_item_id '];
   
    public function saleItem()
    {
        return $this->belongsTo('App\SaleItem', 'sale_item_id');
    }

    public function Cart()
    {
        return $this->belongsTo('App\SaleItem', 'cart_id');
    }
}
