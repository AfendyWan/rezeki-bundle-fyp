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
use App\Models\Adminsetting;
use App\Models\PaymentReceipt;
use App\Models\State;
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
           ['shipping_default_status', '=', 1],           
        ])->first();

        $userShippingAddressState = State::where([
            ['id', '=', $userShippingAddress->state],                   
         ])->first();

         $localDelivery = Adminsetting::where([
            ['key', '=', 'local delivery'],                   
         ])->first();

         $SabahShippingFee = Adminsetting::where([
            ['key', '=', 'Sabah courier delivery shipping fee'],                   
         ])->first();

         $SarawakShippingFee = Adminsetting::where([
            ['key', '=', 'Sarawak courier delivery shipping fee'],                   
         ])->first();

         $PeninsularShippingFee = Adminsetting::where([
            ['key', '=', 'Peninsular courier delivery shipping fee'],                   
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
        
        $getPaymentBankName = Adminsetting::where([
            ['key', '=', 'Payment bank name'],                   
         ])->first();
       
         $getPaymentAccountNumber = Adminsetting::where([
            ['key', '=', 'Payment account number'],                   
         ])->first();

         $getPaymentAccountHolderName = Adminsetting::where([
            ['key', '=', 'Payment account holder name'],                   
         ])->first();

        return view('dashboards.users.managePayments.index', compact('adminDetails', 'userDetails','userShippingAddress', 
        'todayDate', 'getCart', 'getSaleItemInCart', 'userShippingAddressState', 
        'localDelivery', 'SabahShippingFee', 'SarawakShippingFee', 'PeninsularShippingFee', 
        'getPaymentBankName', 'getPaymentAccountNumber', 'getPaymentAccountHolderName'));
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

    public function updatePaymentResult(Request $request){
  

        $request->validate([
            'paymentReceipt' => 'required|mimes:png,jpg,jpeg,pdf|',
          //  'images' => 'required|mimes:png,jpg,jpeg|max:5'
        ]);
      
        ////////////////////Get user cart
        $checkCart = Cart::where([
            ['userID', '=', auth()->user()->id],
            ['cartStatus', '=', 1],
        ])->first();

        ////////////////////Get today date
        $todayDate = date('Y-m-d H:i:s');

        ////////////////////Create new payment
        $newPayment = new Payment;
        $newPayment->totalPrice = $request->totalPrice; //this total price will be get from payment gateway
        $newPayment->subTotalPrice = $request->subTotalPrice;
        $newPayment->shippingPrice = $request->shippingPrice;
        $newPayment->paymentStatus = "Processing"; //this payment status will be get from payment gateway
        $newPayment->cart_id = $checkCart->id; 
        $newPayment->userID = auth()->user()->id;
        $newPayment->paymentDate = $todayDate;
            
        $newPayment->save();
        
        if ($request->hasfile('paymentReceipt')) {
           
      
            $images = $request->file('paymentReceipt');
           
                
                $name = time() .'-'.$images->getClientOriginalName();
               
                //save to upload folder within the public
                $path = $images->storeAs('payment_receipt', $name, 'public');
                
                //Save to public folder
                //$path = $image->storeAs('public/', $name);
               
                PaymentReceipt::create([
                    'payment_id' => $newPayment->id, 
                    'paymentReceiptStatus' => $newPayment->id,                      
                    'url' => '/storage/'.$path
                ]);
                
            
       }
        ////////////////////get user default shipping address
        $userShippingAddress = UserShippingAddress::where([           
            ['shipping_default_status', '=', 1], 
            ['userID', '=', auth()->user()->id],           
         ])->first();

         $userShippingAddressState = State::where([           
            ['id', '=', $userShippingAddress->state],                  
         ])->first();

        
         $userFullShippingAddress = $userShippingAddress->shipping_address. ", " . $userShippingAddress->city. ", " . $userShippingAddressState->states_name. ", " . $userShippingAddress->postcode;
        
        ////////////////////Create new shipping
        $newShipment = new Shipment;
        if(str_contains($request->deliveryOptionName, 'Local Delivery')){
            $newShipment->shippingOption = "local delivery"; //kiv
        }else{
            $newShipment->shippingOption = "courier delivery"; //kiv
        }

        $newShipment->shippingAddress = $userFullShippingAddress; 
        $newShipment->shippingStatus = "Processing"; 
        $newShipment->shippingCourier = ""; //this will be later updated by admin
        $newShipment->shippingTrackingNumber = ""; //this will be later updated by admin
        $newShipment->cart_id = $checkCart->id; 
        $newShipment->payment_id = $newPayment->id;
        $newShipment->userID = auth()->user()->id;
        $newShipment->shippingCourier = $request->couriers; 
        if($request->filled('deliveryDateTime')) {
            $splitDateTime = explode('T', $request->deliveryDateTime, 2); 
            $dateLocalDelivery = $splitDateTime[0];
            $timeLocalDelivery = $splitDateTime[1];
            $timeDateLocalDelivery = $dateLocalDelivery. " " . $timeLocalDelivery;
            $newShipment->shippingLocalDateTime = $timeDateLocalDelivery;           
        }

        $newShipment->save();

        ////////////////////Create new order
        $newOrder = new Order;
        $newOrder->orderDate = $todayDate;
        $newOrder->userID  = auth()->user()->id;
        $newOrder->paymentID  = $newPayment->id;
        $newOrder->shipmentID  = $newShipment->id;
        $newOrder->orderStatus = "Order Processing";
        
        $newOrder->save();
        $orderID = $newOrder->id;
        $newOrder->order_number = "OD00" . $orderID;
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

        ////////////////////Update cart status
        Cart::where([
            ['userID', '=', auth()->user()->id],
            ['cartStatus', '=', 1],
        ])->update([
            'cartStatus' => 0, 
        ]);
       // dd($getCartItems);
        return view('dashboards.users.managePayments.result');
    }

    public function updatePaymentVerificationStatus(Request $request){

       
        $getPayment = Payment::where([          
            ['id', '=', $request->paymentID],
        ])->update([
            'paymentStatus' => $request->paymentVerificationStatus, 
            'remark' => $request->paymentRemarks, 
        ]);

        $getPaymentReceipt = PaymentReceipt::where([          
            ['payment_id', '=', $request->paymentID],
        ])->update([
            'paymentReceiptStatus' => $request->paymentVerificationStatus,            
        ]);

        if($request->paymentVerificationStatus == "Verified"){
            $getOrder = Order::where([          
                ['paymentID', '=', $request->paymentID],
            ])->update([
                'orderStatus' => "Order placed", 
                
            ]);
        }else{
            $getOrder = Order::where([          
                ['paymentID', '=', $request->paymentID],
            ])->update([
                'orderStatus' => "Order unsuccessful", 
                
            ]);
        }

   

        return redirect()->route('manageTransactions.verifyUserTransaction')
        ->with('success','Payment status updated successfully.');
    }
}
