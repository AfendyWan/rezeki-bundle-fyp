<?php

namespace App\Http\Controllers\Api\payment;

use App\Models\State;
use App\Models\City;
use App\Models\Adminsetting;
use App\Models\UserShippingAddress;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\CartItem;
use App\Models\OrderItem;
use App\Models\SaleItem;
use App\Models\PaymentReceipt;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use DB;
class PaymentController extends Controller{

    public function submitPayment(Request $request){
      
        // if ($request->hasfile('paymentReceipt')) {
        //     return response()->json(['aaa' => __('Payment Receipt Updated Successfully')], 200);
        // }else{
        //     return response()->json(['zzz' => __('Payment Receipt Updated Successfully')], 200);
        // }
        
        // $validator = Validator::make($request->all(), [
        //     'paymentReceipt' => ['required', 'mimes:png,jpg,jpeg,pdf'],
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 403);
        // }

      
        ////////////////////Get user cart
        $checkCart = Cart::where([
            ['userID', '=', $request->userID],
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
        $newPayment->userID = $request->userID;
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
            ['userID', '=', $request->userID],           
         ])->first();

         $userShippingAddressState = State::where([           
            ['id', '=', $userShippingAddress->state],                  
         ])->first();

        
         $userFullShippingAddress = $userShippingAddress->shipping_address. ", " . $userShippingAddress->city. ", " . $userShippingAddressState->states_name. ", " . $userShippingAddress->postcode;
        
        ////////////////////Create new shipping
        $newShipment = new Shipment;
        if(str_contains($request->deliveryOptionName, 'local delivery')){
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
        $newShipment->userID = $request->userID;
        $newShipment->shippingCourier = $request->couriers; 
        if($request->deliveryDateTime != "") {
           
            $newShipment->shippingLocalDateTime = $request->deliveryDateTime;           
        }

        $newShipment->save();

        ////////////////////Create new order
        $newOrder = new Order;
        $newOrder->orderDate = $todayDate;
        $newOrder->userID  = $request->userID;
        $newOrder->paymentID  = $newPayment->id;
        $newOrder->shipmentID  = $newShipment->id;
        $newOrder->orderStatus = "Order Processing";
        
        $newOrder->save();
        $orderID = $newOrder->id;
        $newOrder->order_number = "OD00" . $orderID;
        $newOrder->save();
        ////////////////////Get user cart items
        $getCartItems = CartItem::where('cart_id', $checkCart->id)->get();
        Payment::where('id', $newPayment->id)
        ->update([
            'order_id' => $newOrder->id, 
           
         ]);

         
        ////////////////////Get sale item
        $getSaleItem = SaleItem::all();

        
        ////////////////////Create new order item
        foreach($getCartItems as $c){
            $newOrderItem = new OrderItem;
            $newOrderItem->quantity = $c->quantity;
            $newOrderItem->order_id   = $newOrder->id;            
            $newOrderItem->sale_item_id   = $c->sale_item_id;          
            foreach($getSaleItem as $s){
                if($s->id == $c->sale_item_id){
                    if($s->itemPromotionStatus == 1){
                        $newOrderItem->orderPrice = $s->itemPromotionPrice;
                    }else{
                        $newOrderItem->orderPrice = $s->itemPrice;
                    }
                    
                }
            }
            $newOrderItem->save();
        }  

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
            ['userID', '=',$request->userID],
            ['cartStatus', '=', 1],
        ])->update([
            'cartStatus' => 0, 
        ]);
       // dd($getCartItems);
       return response()->json(['success' => __('Payment Receipt Updated Successfully')], 200);
    }

   
    public function getPaymentReceipt($id)
    {
        $paymentReceiptImage = DB::table('payment_receipts')       
        ->select('payment_receipts.*',)
        ->where('payment_receipts.payment_id', '=', $id)
        ->first();
  
        return response()->json($paymentReceiptImage->url, 200, ['Connection' => 'keep-alive']);
    }
}
