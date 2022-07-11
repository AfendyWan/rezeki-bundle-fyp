<?php

namespace App\Http\Controllers\Api\feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Feedback;
use App\Models\FeedbackImage;

use DB;
class FeedbackController extends Controller
{
    public function getUsersFeedback()
    {     
        $getAllUserFeedback = Feedback::orderBy('updated_at', 'DESC')->with('feedbackImage')->get();

        return response()->json($getAllUserFeedback, 200, ['Connection' => 'keep-alive']);
    } 

    public function getFeedbackImages()
    {     
        $allFeebackImages = FeedbackImage::all();
 
        return response()->json($allFeebackImages, 200, ['Connection' => 'keep-alive']);
    } 

    public function addFeedback(Request $request)
    {
        $getPaymentID = Order::where([
            ['id', '=',$request->order_id],               
        ])->first();

        $feedback = new Feedback;
        $feedback->feedbackTitle = $request->feedbackTitle;
        $feedback->feedbackDescription = $request->feedbackDescription;
        $feedback->userID = $request->userId; 
        $feedback->sale_item_id = $request->sale_item_id;
        $feedback->order_id = $request->order_id;
        $feedback->payment_id = $getPaymentID->paymentID;
        $feedback->save();

        if ($request->hasfile('images')) {
            $images = $request->file('images');
            foreach($images as $image) {
                $name = time() .'-'.$image->getClientOriginalName();

                //save to upload folder within the public
                $path = $image->storeAs('feedback', $name, 'public');
                
                //Save to public folder
                //$path = $image->storeAs('public/', $name);
                FeedbackImage::create([
                    'feedback_id' => $feedback->id,
                    'url' => '/storage/'.$path
                ]);
            }
       }
       return response()->json("Success", 200, ['Connection' => 'keep-alive']);
    }
}
