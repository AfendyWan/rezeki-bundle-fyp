<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;
    protected $fillable = ['itemName', 'itemCategory','itemStock',
                        'itemPrice', 'itemPromotionStatus','itemPromotionPrice',
                        'itemActivationStatus', 'itemDescription'];
                        
    public function saleItemImage()
    {
        return $this->hasMany('App\SaleItemImage', 'sale_item_id');
    }
}
