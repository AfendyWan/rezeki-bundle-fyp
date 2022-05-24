<?php

namespace App\Http\Controllers\api\cart;

use App\Models\SaleItem;
use App\Models\CartItem;
use App\Models\Cart;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class CartController extends Controller{
    

    public function getUserCart(Request $request)
    {     
        $getCart = Cart::where([
            ['userID', '=', $request->userID],
            ['cartStatus', '=', 1],
        ])->first();
 
      
        return response()->json($getCart, 200, ['Connection' => 'keep-alive']);
    }  

    
    public function deletCartItem(Request $request)
    {     
       
        $findCart = Cart::find($request->cartID);
        $saleItem = SaleItem::where('id', $request->saleItemID)->first();

        $findCartItem =  CartItem::where([
            ['cart_id', '=', $request->cartID],
            ['sale_item_id', '=', $request->saleItemID],
        ])->first();
      

        if($saleItem->itemPromotionStatus == 1){
            $saleItemTotalPrice = $saleItem->itemPromotionPrice * $findCartItem->quantity;
          
        }else{
            $saleItemTotalPrice = $saleItem->itemPrice * $findCartItem->quantity;
          
        }
        
        $newCartQuantity = $findCart->cartItemQuantity - $findCartItem->quantity;
        $newCartTotalPrice = $findCart->totalPrice - $saleItemTotalPrice;
        
        Cart::where([
            ['id', '=', $request->cartID],
        ])->update([
            'totalPrice' => $newCartTotalPrice,
            'cartItemQuantity' => $newCartQuantity
        ]);

        $findCartItem->delete();
        
        $deleteStatus = "success";
        return response()->json($deleteStatus, 200, ['Connection' => 'keep-alive']);
    }  

    public function getUserCartItem(Request $request)
    {     
        $getCart = Cart::where([
            ['userID', '=', $request->userID],
            ['cartStatus', '=', 1],
        ])->first();
        if(!$getCart){
            $getUserCartItem = "";
        }else{
            $getUserCartItem = DB::table('cart_items')
            ->join('sale_items', 'cart_items.sale_item_id', '=', 'sale_items.id')
            ->join('sale_item_images', 'cart_items.sale_item_id', '=', 'sale_item_images.sale_item_id')
            ->select('cart_items.*', 'sale_items.*', 'sale_item_images.*')
            ->where('cart_id', '=', $getCart->id)
            ->groupby('cart_items.sale_item_id')
            ->get();
        }
      
      
        
        return response()->json($getUserCartItem, 200, ['Connection' => 'keep-alive']);

    }  

   
}
