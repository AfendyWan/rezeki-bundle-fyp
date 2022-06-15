<?php

namespace App\Http\Controllers\Api\shipment;

use App\Models\State;
use App\Models\City;
use App\Models\Adminsetting;
use App\Models\UserShippingAddress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
   
}
