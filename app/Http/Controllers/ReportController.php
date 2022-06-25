<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SaleItem;
use App\Models\WishListItem;
use Carbon\Carbon;
use DB;
class ReportController extends Controller
{
    public function index(){

       
        $allSaleItem = SaleItem::all();


         ///////////////////////////////////////////Create wish list pie chart
        $allWishListItem = WishListItem::all();

        $wishListData = array();
        $countWishItem = 0;
        $wishListData[] = array(
            '0' => "Wish List Item", // we access the firstname at the current index
            '1' => "Numbers",
        );
        $isWishListItem = false;
        foreach($allSaleItem as $saleTag)
        {
            foreach($allWishListItem as $wishTag)
            {   
                if($wishTag->sale_item_id  == $saleTag->id){
                   
                    $countWishItem = $countWishItem + 1; 
                    $isWishListItem = true;                   
                }   
                    // if($wishTag->sale_item_id  == $saleTag->id){
                    //     $wishListData[$saleTag->itemName]  = $countWishItem;
                    //     $countWishItem = $countWishItem + 1;                      
                    // }                  
            }
            if($isWishListItem == true){
                $wishListData[] = array(
                    '0' => $saleTag->itemName, // we access the firstname at the current index
                    '1' => $countWishItem,
                );
            }
            $isWishListItem = false;
            $countWishItem = 0;
        }

        ///////////////////////////////////////////create sale item sold pie chart

        $today = Carbon::now();

        $allOrderItems = DB::table('order_items')
        ->join('sale_items', 'order_items.sale_item_id', '=', 'sale_items.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.orderStatus', '=', "Order Placed") 
        ->whereMonth('orders.orderDate', date('m'))    
        ->whereYear('orders.orderDate', date('Y'))          
        ->get();

        $soldSaleItemData = array();
        $countSoldItem = 0;
        
        $soldSaleItemData[] = array(
            '0' => "Sold Sales Item", // we access the firstname at the current index
            '1' => "Numbers",
        );
        $isSoldItem = false;
       
        foreach($allSaleItem as $saleTag)
        {
            foreach($allOrderItems as $orderTag)
            {   
              
                if($orderTag->sale_item_id  == $saleTag->id){
                   
                   
                    $countSoldItem = $countSoldItem + 1; 
                    $isSoldItem = true;                   
                }   
                    // if($wishTag->sale_item_id  == $saleTag->id){
                    //     $data[$saleTag->itemName]  = $countWishItem;
                    //     $countWishItem = $countWishItem + 1;                      
                    // }                  
            }
            
            if($isSoldItem == true){
               
                $soldSaleItemData[] = array(
                    '0' => $saleTag->itemName, // we access the firstname at the current index
                    '1' => $countSoldItem,
                );
            }
            $isSoldItem = false;
            $countSoldItem = 0;
        }

        ///////////////////////////////////////////create sale reports
      

        $today = Carbon::now();

        $allReportItem = DB::table('order_items')
        ->join('sale_items', 'order_items.sale_item_id', '=', 'sale_items.id')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->where('orders.orderStatus', '=', "Order Placed")    
        ->whereYear('orders.orderDate', date('Y'))          
        ->get();

        $reportData = array();
        $countReport = 0;
        
        $reportData[] = array(
            '0' => "Months", // we access the firstname at the current index
            '1' => "Total Prices (RM)",
        );
        $isReport = false;
        $monthName;
        for($mi = 1; $mi<13; $mi++){
            foreach($allReportItem as $reportTag)
            {
                if(\Carbon\Carbon::parse($reportTag->orderDate)->format('n') == $mi){                      
                       
                    $countReport = $countReport + $reportTag->orderPrice; 
                    $isReport = true;                   
                    $monthName = \Carbon\Carbon::parse($reportTag->orderDate)->format('F');
                }       
            }
            if($isReport == true){
                   
                $reportData[] = array(
                    '0' => $monthName, // we access the firstname at the current index
                    '1' => "RM " . number_format((float)$countReport, 2, '.', ''),
                );
            }
            $isReport = false;
            $countSoldItem = 0;
    
        }
        // dd(json_encode($data));
        return view('dashboards.admins.index', compact('wishListData', 'soldSaleItemData', 'reportData'));
    }
}
