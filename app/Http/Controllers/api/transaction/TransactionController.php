<?php

namespace App\Http\Controllers\Api\transaction;

use App\Models\State;
use App\Models\City;
use App\Models\Adminsetting;
use App\Models\UserShippingAddress;
use App\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
class TransactionController extends Controller{

    public function getUserOrderTransaction(Request $request)
    {
        $getUserOrderTransaction = Order::orderBy('updated_at', 'DESC')
                                ->with('payment')
                                ->where('orders.userID', '=', $request->userID)   
                                ->get();

        return response()->json($getUserOrderTransaction, 200, ['Connection' => 'keep-alive']);   
    }

    public function viewUserOrderItems(Request $request){
                     
        $getOrderItems = DB::table('order_items')
        ->join('sale_items', 'order_items.sale_item_id', '=', 'sale_items.id')
        ->join('sale_item_images', 'order_items.sale_item_id', '=', 'sale_item_images.sale_item_id')
        ->where('order_id', '=', $request->orderID)
        ->groupBy('order_items.sale_item_id')        
        ->get();

        // $getOrderItems = DB::table('order_items')
        // ->where('order_id', '=', $request->orderID)        
        // ->get();

        // $saleItemList = array();
        // foreach($getOrderItems as $c){
        //     $saleItemList[] = $c->sale_item_id; 
        // };
     
        // $getSaleItems = DB::table('sale_items')
        // ->whereIn('id', $saleItemList)
        // ->get();
     
        return response()->json($getOrderItems, 200, ['Connection' => 'keep-alive']);
      
    }
   
}
