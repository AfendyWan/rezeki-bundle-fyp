<?php

namespace App\Http\Controllers\Api\feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feedback;
use DB;
class FeedbackController extends Controller
{
    public function getUsersFeedback()
    {     
        $getAllUserFeedback = Feedback::with('feedbackImage')->get();

        return response()->json($getAllUserFeedback, 200, ['Connection' => 'keep-alive']);
    } 
}
