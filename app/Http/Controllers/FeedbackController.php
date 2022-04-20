<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function destroy(Feedback $feedback)
    {
        //
    }
}
