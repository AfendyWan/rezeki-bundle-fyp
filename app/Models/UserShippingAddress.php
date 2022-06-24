<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = ['full_name', 'phone_number','userID', 'shipping_address', 'state', 'city', 'shipping_default_status', 'postcode'];

    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }

}
