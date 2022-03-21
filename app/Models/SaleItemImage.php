<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItemImage extends Model
{
    use HasFactory;

    protected $fillable = [
     'url', 'sale_item_id'
    ];
    
    public function saleItem()
    {
        return $this->belongsTo('App\SaleItem', 'sale_item_id');
    }
}
