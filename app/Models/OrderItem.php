<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['quantity', 'order_id', 'sale_item_id', 'orderPrice'];

    public function saleItem()
    {
        return $this->belongsTo('App\SaleItem', 'sale_item_id');
    }

    public function Order()
    {
        return $this->belongsTo('App\Order', 'order_id');
    }
}
