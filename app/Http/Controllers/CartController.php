<?php

namespace App\Http\Controllers;

use App\Models\Cart; 
use App\Models\SaleItem;
use App\Models\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboards.users.manageCarts.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if cart exist or not
        $checkCart = Cart::where([
            ['userID', '=', $request->userID],
            ['cartStatus', '=', 1],
        ])->get();

        $saleItem = SaleItem::where('id', $request->saleItemID)->first();

        if($request->quantity > $saleItem->itemStock){
            return Redirect::back()->with(['error' => 'Item quantity added to cart exceed item stock']);
        }
        
        if ($checkCart->isEmpty()) {
            $newCart = new Cart;
            $newCart->userID  = $request->userID;
            $newCart->totalPrice =  $saleItem->itemPrice;
            $newCart->cartItemQuantity =  1;
            $newCart->cartStatus = 1; 

            $newCart->save();

            $newCartItem = new CartItem;
            $newCartItem->cart_id  = $newCart->id;
            $newCartItem->quantity  =  $request->quantity;
            $newCartItem->sale_item_id  = $saleItem->id;

            $newCartItem->save();
        } else {
            foreach($checkCart as $c){
                if ($c->cartStatus == 1) {

                    //get existing cart
                    $getExistingCart = Cart::where('id', $c->id)->first();

                    //get current total price
                    $currentTotalPrice = $getExistingCart->totalPrice + $saleItem->itemPrice;
                    
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

        return Redirect::back()->with(['success' => 'Item had been added to cart successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
