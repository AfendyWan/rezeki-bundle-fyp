<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = ['userID', 'shipping_address', 'shipping_default_status'];

    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }

}
