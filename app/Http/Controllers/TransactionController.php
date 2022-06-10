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
        $getAllTransaction = DB::table('orders')
        ->join('users', 'orders.userID', '=', 'users.id')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->select('users.*', 'orders.*', 'payments.*', 'orders.id as orderID')
        ->get();

        return view('dashboards.admins.manageTransactions.allHistoryTransaction', compact('getAllTransaction')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function userIndex()
    {
        $getAllTransaction = DB::table('orders')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->select('orders.*', 'payments.*', 'orders.id as orderID')
        ->where('orders.userID', '=', auth()->user()->id)      
        ->get();

        return view('dashboards.users.manageTransactions.index', compact('getAllTransaction')) ->with('i', (request()->input('page', 1) - 1) * 5);;
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
       
        $isEmpty = 0;
        if($getDailyTransaction->isEmpty()){
            $isEmpty = 1;
        }

        return view('dashboards.admins.manageTransactions.dailyTransaction', compact('getDailyTransaction', 'isEmpty')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function viewOrderItems(Request $request, $id)
    {
        $getOrderItems = DB::table('order_items')
        ->join('sale_items', 'order_items.sale_item_id', '=', 'sale_items.id')
        ->where('order_id', '=', $id)        
        ->get();

       
        return view('dashboards.admins.manageTransactions.showOrderItems', compact('getOrderItems')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }
    public function userViewOrderItems(Request $request, $id)
    {
        $getOrderItems = DB::table('order_items')
        ->join('sale_items', 'order_items.sale_item_id', '=', 'sale_items.id')
        ->where('order_id', '=', $id)        
        ->get();

       
        return view('dashboards.users.manageTransactions.userViewOrderItems', compact('getOrderItems')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }
    
    public function searchWithDate(Request $request){
       
        $todayDate = date('Y-m-d');
        $reformatDate = \Carbon\Carbon::parse($request->param1)->format('y-m-d');
        if($request->param1 == null){
            $request->param1=$todayDate;
        }
        $request->param1 = $reformatDate;
        return \Redirect::route('adminSearchDateTransaction', ['param1' => $request->param1]);
    }

    public function adminSearchDateTransaction(Request $request){
              
        $limitDate = Carbon::createFromFormat('y-m-d', $request->param1);
        $daysToAdd = 1;
        $limitDate = $limitDate->addDays($daysToAdd)->startOfDay();
       
        $getDailyTransaction = DB::table('orders')
        ->join('users', 'orders.userID', '=', 'users.id')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->select('users.*', 'orders.*', 'payments.*', 'orders.id as orderID')
        ->where('payments.paymentDate', '>=', $request->param1) 
        ->where('payments.paymentDate', '<', $limitDate)   
        ->get();
        
        $isEmpty = 0;
        if($getDailyTransaction->isEmpty()){
            $isEmpty = 1;
        }
        
        return view('dashboards.admins.manageTransactions.dailyTransaction', compact('getDailyTransaction', 'isEmpty')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function viewUserOrder(Request $request, $id){
                     
        $getUserTransaction = DB::table('orders')
        ->join('users', 'orders.userID', '=', 'users.id')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->select('users.*', 'orders.*', 'payments.*', 'orders.id as orderID')
        ->where('orders.id', '=', $id)       
        ->first();
        
        return view('dashboards.admins.manageTransactions.viewUserOrder', compact('getUserTransaction')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function verifyUserTransaction(Request $request){
       
        $getUnverifyTransaction = DB::table('orders')
        ->join('users', 'orders.userID', '=', 'users.id')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->join('payment_receipts', 'orders.paymentID', '=', 'payment_receipts.payment_id')
        ->select('users.*', 'orders.*', 'payments.*', 'orders.id as orderID', 'payment_receipts.*')
        ->where('payments.paymentStatus', '=', "Processing")        
        ->get();
     
        $isEmpty = 0;
        if($getUnverifyTransaction->isEmpty()){
            $isEmpty = 1;
        }
        
        return view('dashboards.admins.manageTransactions.verifyTransaction', compact('getUnverifyTransaction', 'isEmpty')) ->with('i', (request()->input('page', 1) - 1) * 5);;
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
