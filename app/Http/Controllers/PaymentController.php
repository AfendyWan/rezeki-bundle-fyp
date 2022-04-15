<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\UserShippingAddress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $adminDetails = User::where('role', 1)->select('email', 'shipping_address', 'phone_number')->first();
        $userShippingAddress = UserShippingAddress::where([
           ['userID', '=', Auth::user()->id],
        ])->first();
         
        $userDetails = User::where('id', Auth::user()->id)->select('first_name', 'last_name','email', 'phone_number')->first();
        $getCart = Cart::where([
            ['userID', '=', Auth::user()->id],
            ['cartStatus', '=', 1],
        ])->first();
        $getSaleItemInCart = DB::table('cart_items')
        ->join('sale_items', 'cart_items.sale_item_id', '=', 'sale_items.id')
        ->join('sale_item_images', 'cart_items.sale_item_id', '=', 'sale_item_images.sale_item_id')
        ->select('cart_items.*', 'sale_items.*', 'sale_item_images.*')
        ->where('cart_id', '=', $getCart->id)
        ->groupby('cart_items.sale_item_id')
        ->get();
        $todayDate = date('Y-m-d');
        
        return view('dashboards.users.managePayment.index', compact('adminDetails', 'userDetails','userShippingAddress', 'todayDate', 'getCart', 'getSaleItemInCart'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
