<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'url', 'feedback_id'
    ];

    public function feedback()
    {
        return $this->belongsTo('App\Feedback', 'feedback_id');
    }
}
