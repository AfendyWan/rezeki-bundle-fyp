<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    public function viewUserDailyTransaction()
    {
        $todayDate = date('Y-m-d');
        $getDailyTransaction = DB::table('orders')
        ->join('users', 'orders.userID', '=', 'users.id')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->select('users.*', 'orders.*', 'payments.*', 'orders.id as orderID')
        ->where('payments.paymentDate', '>=', $todayDate)        
        ->get();
       

        return view('dashboards.admins.manageTransactions.dailyTransaction', compact('getDailyTransaction')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function viewOrderItems(Request $request, $id)
    {
    
       dd("A");
        // return redirect()->route('manageSaleItems.show', $id)->with('success','Sale item promotion updated successfully.');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
