<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\UserShippingAddress;
use App\Models\SaleItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Shipment;
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
        
        return view('dashboards.users.managePayments.index', compact('adminDetails', 'userDetails','userShippingAddress', 'todayDate', 'getCart', 'getSaleItemInCart'));
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

    public function updatePaymentResult(){

        ////////////////////Get user cart
        $checkCart = Cart::where([
            ['userID', '=', auth()->user()->id],
            ['cartStatus', '=', 1],
        ])->first();

        ////////////////////Get today date
        $todayDate = date('Y-m-d H:i:s');

        ////////////////////Create new payment
        $newPayment = new Payment;
        $newPayment->totalPrice = 10; //this total price will be get from payment gateway
        $newPayment->paymentStatus = 1; //this payment status will be get from payment gateway
        $newPayment->cart_id = $checkCart->id; 
        $newPayment->userID = auth()->user()->id;
        $newPayment->paymentDate = $todayDate;
            
        $newPayment->save();

        ////////////////////Create new shipping
        $newShipment = new Shipment;
        $newShipment->shippingOption = ""; //kiv
        $newShipment->shippingStatus = "To ship"; 
        $newShipment->shippingCourier = ""; //this will be later updated by admin
        $newShipment->shippingTrackingNumber = ""; //this will be later updated by admin
        $newShipment->cart_id = $checkCart->id; 
        $newShipment->payment_id = $newPayment->id;
        $newShipment->userID = auth()->user()->id;

        $newShipment->save();

        ////////////////////Create new order
        $newOrder = new Order;
        $newOrder->orderDate = $todayDate;
        $newOrder->userID  = auth()->user()->id;
        $newOrder->paymentID  = $newPayment->id;
        $newOrder->shipmentID  = $newShipment->id;
        $newOrder->orderStatus = $checkCart->id; 
       
        $newOrder->save();

        ////////////////////Get user cart items
        $getCartItems = CartItem::where('cart_id', $checkCart->id)->get();

        ////////////////////Create new order item
        foreach($getCartItems as $c){
            $newOrderItem = new OrderItem;
            $newOrderItem->quantity = $c->quantity;
            $newOrderItem->order_id   = $newOrder->id;            
            $newOrderItem->sale_item_id   = $c->sale_item_id;          

            $newOrderItem->save();
        }  

        ////////////////////Get sale item
        $getSaleItem = SaleItem::all();

        ////////////////////Update sale item quantity
        foreach($getCartItems as $c){
            foreach($getSaleItem as $s){
                if($c->sale_item_id == $s->id){
                     $a = $s->itemStock;
                     $b = $c->quantity;
                    $newItemQuantity = $a- $b;
                    if($newItemQuantity == 0){
                        SaleItem::where('id', $s->id)
                        ->update([
                            'itemStock' => $newItemQuantity, 
                            'itemActivationStatus' => 0, 
                         ]);
                    }else{
                        SaleItem::where('id', $s->id)
                        ->update([
                            'itemStock' => $newItemQuantity, 
                         ]); 
                    }                  
                }
            }
        }

        ////////////////////Update all user cart item if sale item is no longer available
        $getAllCartItems = CartItem::all();
        foreach($getAllCartItems as $ci){
            foreach($getCartItems as $c){
                if($ci->sale_item_id==$c->cart_item_id){
                    if($ci->quantity!=0){
                        $getSaleItem1 = SaleItem::where('id', $ci->sale_item_id)->first();
                        if($getSaleItem1->itemStock!=0){
                            $newCartItemQuantity = $ci->quantity - $c-$quantity;
                            if($newCartItemQuantity < $getSaleItem1->itemStock){
                                CartItem::where('id', $ci->id)
                                ->update([
                                    'quantity' => $getSaleItem1->itemStock, 
                                ]);
                            }else{
                                CartItem::where('id', $ci->id)
                                ->update([
                                    'quantity' => $newCartItemQuantity, 
                                ]);
                            }                            
                        }else{
                            CartItem::where('id', $ci->id)
                                ->update([
                                    'quantity' => 0, 
                            ]);
                        }                        
                    }
                }
            }
        }
        Cart::where([
            ['userID', '=', auth()->user()->id],
            ['cartStatus', '=', 1],
        ])->update([
            'cartStatus' => 0, 
        ]);
       // dd($getCartItems);
        return view('dashboards.users.managePayments.result');
    }
}
