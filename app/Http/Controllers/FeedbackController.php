<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackImage;
use App\Models\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Redirect;
class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getAllUserFeedback = DB::table('feedback')
        ->join('sale_items', 'feedback.sale_item_id', '=', 'sale_items.id')
        ->join('users', 'feedback.userID', '=', 'users.id')
        ->select('feedback.*', 'sale_items.*', 'users.*', 'feedback.id as feedbackID')
        ->get();

        $allFeedbackImages = FeedbackImage::all();
        // $getAllUserFeedback = DB::table('feedback')
        // ->join('sale_items', 'feedback.sale_item_id', '=', 'sale_items.id')
        // ->join('users', 'feedback.userID', '=', 'users.id')
        // ->join('feedback_images', 'feedback.id', '=', 'feedback_images.feedback_id')
        // ->select('feedback.*', 'sale_items.*', 'users.*', 'feedback_images.*')
        // ->get();

        return view('dashboards.users.manageFeedback.index', compact('getAllUserFeedback', 'allFeedbackImages'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function adminIndex(){
        $getAllUserFeedback = DB::table('feedback')
        ->join('sale_items', 'feedback.sale_item_id', '=', 'sale_items.id')
        ->join('users', 'feedback.userID', '=', 'users.id')
        ->select('feedback.*', 'sale_items.*', 'users.*', 'feedback.id as feedbackID')
        ->get();

        $allFeedbackImages = FeedbackImage::all();
    
        // $getAllUserFeedback = DB::table('feedback')
        // ->join('sale_items', 'feedback.sale_item_id', '=', 'sale_items.id')
        // ->join('users', 'feedback.userID', '=', 'users.id')
        // ->join('feedback_images', 'feedback.id', '=', 'feedback_images.feedback_id')
        // ->select('feedback.*', 'sale_items.*', 'users.*', 'feedback_images.*')
        // ->get();

        return view('dashboards.admins.manageFeedback.index', compact('getAllUserFeedback', 'allFeedbackImages'))
        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!$request->filled('feedbackTitle')){
            if(!$request->filled('feedbackDescription')){
                return Redirect::back()->with(['error' => 'Feedback title and description is empty']);
            }
            return Redirect::back()->with(['error' => 'Feedback title is empty']);
        }else{
            if(!$request->filled('feedbackDescription')){
                return Redirect::back()->with(['error' => 'Feedback description is empty']);
            }
            $getPaymentID = Order::where([
                ['id', '=',$request->order_id],               
            ])->first();

            $feedback = new Feedback;
            $feedback->feedbackTitle = $request->feedbackTitle;
            $feedback->feedbackDescription = $request->feedbackDescription;
            $feedback->userID = auth()->user()->id; 
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
        }
        return Redirect::back()->with(['success' => 'Feedback had been submitted successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function show(Feedback $feedback)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feedback $feedback)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Feedback $feedback)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feedback  $feedback
     * @return \Illuminate\Http\Response
     */
    public function deleteFeedback($id)
    {
       
        $findFeedback = Feedback::find($id);
       
        
        $allFeedbackImage = FeedbackImage::where('feedback_id', $id)->get();
        
        //delete file within laravel and database
        foreach($allFeedbackImage as $i){
            $image = $i->url;
            unlink(public_path($image));
            $i->delete();
        }
        $findFeedback->delete();
        return redirect()->route('manageFeedback.adminIndex')
                        ->with('success','Feedback deleted successfully');
    }
}
