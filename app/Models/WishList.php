<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WishList extends Model
{
    use HasFactory;

    protected $fillable = ['userID ', 'wishItemQuantity'];
    
    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }

    public function cartItem()
    {
        return $this->hasMany('App\WishListItem', 'wish_id');
    }
}
