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
    
    
    public function addCartItem(Request $request)
    {   
         //check if cart exist or not
         $checkCart = Cart::where([
            ['userID', '=', $request->userID],
            ['cartStatus', '=', 1],
        ])->get();

        //get sale item
        $saleItem = SaleItem::where('id', $request->saleItemID)->first();

        //validate stock quantity added
        if($request->quantity > $saleItem->itemStock){
            return Redirect::back()->with(['error' => 'Item quantity added to cart exceed item stock']);
        }
       
        //check if user have cart or not
        if ($checkCart->isEmpty()) {
            $newCart = new Cart;
            $newCart->userID  = $request->userID;
            
            if($saleItem->itemPromotionStatus){
                $getCurrentCartPrice = $saleItem->itemPromotionPrice * $request->quantity;
                $newCart->totalPrice =  $getCurrentCartPrice;
            }else{
                $getCurrentCartPrice = $saleItem->itemPrice * $request->quantity;
                $newCart->totalPrice =  $getCurrentCartPrice;
            }
            $newCart->cartItemQuantity =  $request->quantity;
            $newCart->cartStatus = 1; 

            $newCart->save();   //user create new cart

            //create new cart item
            $newCartItem = new CartItem;
            $newCartItem->cart_id  = $newCart->id;
            $newCartItem->quantity  =  $request->quantity;
            $newCartItem->sale_item_id  = $saleItem->id;

            $newCartItem->save();
        } else {

            //if there is existing cart
            foreach($checkCart as $c){
                if ($c->cartStatus == 1) {

                    //get existing cart
                    $getExistingCart = Cart::where('id', $c->id)->first();
                   
                    //get current total price
                    if($saleItem->itemPromotionStatus == 1){ 
               
                        $getItemTotalPrice = $saleItem->itemPromotionPrice * $request->quantity;
                       
                        $currentTotalPrice = $getExistingCart->totalPrice + $getItemTotalPrice;
                     
                    }else{
                        $currentTotalPrice = $getExistingCart->totalPrice + ($saleItem->itemPrice * $request->quantity);
                    }
                    
                    
                    //get existing cart item quantity
                    $getCartItemQuantity = CartItem::where([
                        ['cart_id', '=', $c->id],
                        ['sale_item_id', '=', $saleItem->id],
                    ])->first();


                    if(!$getCartItemQuantity){
                        //if there is no exisiting cart item 
                        
                        $newCartItem = new CartItem;
                        $newCartItem->cart_id  = $c->id;
                        $newCartItem->quantity  =  $request->quantity;
                        $newCartItem->sale_item_id  = $saleItem->id;
            
                        $newCartItem->save();

                    }else{
                        //if there is existing cart item
                        
                        //if existing cart item quantity + added sale item is more than current sale item stock, request failed

                        $totalCartItemQuantity = $getCartItemQuantity->quantity+$request->quantity;
                       
                        if($totalCartItemQuantity > $saleItem->itemStock){
                            return Redirect::back()->with(['error' => 'Item quantity added to cart exceed existing item in the cart']);
                        }

                        CartItem::where('id', $getCartItemQuantity->id)->update([
                           'quantity' => $totalCartItemQuantity
                        ]);

                    }
                 
                    $currentCartQuantity = $getExistingCart->cartItemQuantity + $request->quantity;
                    Cart::where('id', $c->id)->update([
                           'totalPrice' => $currentTotalPrice,
                           'cartItemQuantity' => $currentCartQuantity
                    ]);

                }
            }
        }
 
        $status = "success";
        return response()->json($status, 200, ['Connection' => 'keep-alive']);
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
