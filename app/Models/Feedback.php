<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;
    protected $fillable = ['feedbackTitle', 'feedbackDescription', 'userID', 'sale_item_id', 'order_id', 'payment_id'];

    public function feedbackImage()
    {
        return $this->hasMany('App\FeedbackImage', 'feedback_id');
    }
}
