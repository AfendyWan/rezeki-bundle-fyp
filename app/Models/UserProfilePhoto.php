<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfilePhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'url', 'userID',
       ];

    public function user()
    {
        return $this->belongsTo('App\User', 'userID');
    }
}
