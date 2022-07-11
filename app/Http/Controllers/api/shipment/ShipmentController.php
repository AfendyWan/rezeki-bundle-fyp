<?php

namespace App\Http\Controllers\Api\shipment;

use App\Models\State;
use App\Models\City;
use App\Models\Adminsetting;
use App\Models\UserShippingAddress;
use App\Models\Shipment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class ShipmentController extends Controller{

    public function getDefaultShippingAddress(Request $request)
    {
        $getUserShippingAddress = UserShippingAddress::where([
            ['userID', '=', $request->userID],
            ['shipping_default_status', '=', 1],
        ])->first();

        return response()->json($getUserShippingAddress);      
    }

    public function getALlUserShippingAddress(Request $request)
    {
        $getALlUserShippingAddress = UserShippingAddress::where([
            ['userID', '=', $request->userID],
         
        ])->get();

        return response()->json($getALlUserShippingAddress);      
    }

    //questionable shipping status
    public function updateUserShipping(Request $request)
    {

        //get current shipping status
        $getCurrentShippingaddress = UserShippingAddress::where([
            ['userID', '=', $request->userID],
            ['shipping_default_status', '=', 1],
        ])->first();
              
        $tempShippingStatus = $getCurrentShippingaddress['shipping_default_status'];

        //change all shipping status to 0
        $getALlUserShippingAddress = UserShippingAddress::where([
            ['userID', '=', $request->userID],         
        ])->get();

        foreach($getALlUserShippingAddress as $c){
            UserShippingAddress::where('id', $c->id)->update([
                'shipping_default_status' => 0,                
            ]);
        }

        //update shipping status
        UserShippingAddress::where('id', $request->id)->update([
            'full_name' => $request->fullName, 
            'phone_number' => $request->phoneNumber, 
            'shipping_address' => $request->shipping_address, 
            'state' => $request->state, 
            'city' => $request->city, 
            'postcode' => $request->postcode, 
            'shipping_default_status' => $request->shipping_default_status, 
                 
        ]);

        //if shipping status is previoously default and now change to 0
        if($tempShippingStatus == 1 && $request->shipping_default_status == 0){

            $getUserFirstShippingAddress = UserShippingAddress::where([
                ['userID', '=', $request->userID],
             
            ])->first();


            UserShippingAddress::where('id', $getUserFirstShippingAddress->id)->update([
              
                'shipping_default_status' => 1, 
                     
            ]);

        }

        return response()->json(['success' => __('User shipment updated successfully')], 200);
    }

    public function getUserShipment(Request $request)
    {
        $getUserShipment = DB::table('orders')
        ->orderBy('updated_at', 'DESC')
        ->join('users', 'orders.userID', '=', 'users.id')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->join('shipments', 'orders.shipmentID', '=', 'shipments.id')
        ->select( 'shipments.*','orders.id as orderID')
        ->where('users.id', '=', $request->userID)
        ->get();   
       
        return response()->json($getUserShipment, 200, ['Connection' => 'keep-alive']);
    }


    public function addUserShippingAddress(Request $request)
    {
        if($request->shipping_default_status == 1){

            $getALlUserShippingAddress = UserShippingAddress::where([
                ['userID', '=', $request->userID],
             
            ])->get();
    
    
            foreach($getALlUserShippingAddress as $c){
                UserShippingAddress::where('id', $c->id)->update([
                    'shipping_default_status' => 0,                
                ]);
            }
    

        }
      

        $newUserShipping = new UserShippingAddress;
        $newUserShipping->shipping_default_status = $request->fullName;
        $newUserShipping->shipping_default_status = $request->phoneNumber;
        $newUserShipping->shipping_default_status = $request->shipping_default_status;
        $newUserShipping->shipping_address = $request->shipping_address;
        $newUserShipping->state = $request->state;
        $newUserShipping->city = $request->city;
        $newUserShipping->postcode = $request->postcode;
        $newUserShipping->userID = $request->userID;
        $newUserShipping->save();


        return response()->json(['success' => __('User shipment added successfully')], 200);
    }

    public function deleteUserShippingAddress(Request $request)
    {

        $findUserShippingAddress = UserShippingAddress::find($request->shipmentID);
        $findUserShippingAddress->delete();    
        
    
        if($request->shipping_default_status == 1){
            
            $getUserFirstShippingAddress = UserShippingAddress::where([
                ['userID', '=', $request->userID],
             
            ])->first();
           
           
           
            UserShippingAddress::where('id', $getUserFirstShippingAddress->id)->update([
              
                'shipping_default_status' => 1, 
                     
            ]);
    

        }   

        return response()->json(['success' => __('User shipment deleted successfully')], 200);
    }

   
}
