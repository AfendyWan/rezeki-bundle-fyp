<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'role',
        'gender',
        //'birthday',
        'postcode',
        'phone_number',
        'shipping_address',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->hasMany('App\Cart', 'userID');
    }

    public function userProfilePhoto()
    {
        return $this->hasMany('App\UserProfilePhoto', 'userID');
    }

    public function payment()
    {
        return $this->hasMany('App\Payment', 'userID');
    }

    public function userShippingAddress()
    {
        return $this->hasMany('App\UserShippingAddress', 'userID');
    }

    public function shipment()
    {
        return $this->hasMany('App\Shipment', 'userID');
    }

    public function order()
    {
        return $this->hasMany('App\Order', 'userID');
    }
}
