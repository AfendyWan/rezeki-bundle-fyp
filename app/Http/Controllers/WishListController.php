<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use App\Models\WishListItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use DB;
use Auth;
class WishListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getWishList = WishList::where([
            ['userID', '=', Auth::user()->id],
        ])->first();


        $getSaleItemInWishList = DB::table('wish_list_items')
        ->join('sale_items', 'wish_list_items.sale_item_id', '=', 'sale_items.id')
        ->join('sale_item_images', 'wish_list_items.sale_item_id', '=', 'sale_item_images.sale_item_id')
        ->select('wish_list_items.*', 'sale_items.*', 'sale_item_images.*')
        ->groupby('wish_list_items.sale_item_id')
        ->get();
        return view('dashboards.users.manageWishList.index', compact('getWishList','getSaleItemInWishList'));

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
        $checkWishList = WishList::where([
            ['userID', '=', $request->userID],
        ])->first();


        if(!$checkWishList){
            $newWishList = new WishList;
            $newWishList->userID  = $request->userID;
            $newWishList->wishItemQuantity =  1;

            $newWishList->save();
            
            $newWishListItem = new WishListItem;
            $newWishListItem->wish_id  = $newWishList->id;
            $newWishListItem->sale_item_id = $request->sale_item_id;
            $newWishListItem->save();
            
        }else{
            if($request->liked == 0){
                WishList::where('id', $checkWishList->id)->update([
                    'wishItemQuantity' => $checkWishList->wishItemQuantity - 1,
                ]);

                $findWishListItem =  WishListItem::where([
                    ['wish_id', '=', $checkWishList->id],
                    ['sale_item_id', '=', $request->sale_item_id],
                ])->first();

                $findWishListItem->delete();
            }else{
                WishList::where('id', $checkWishList->id)->update([
                    'wishItemQuantity' => $checkWishList->wishItemQuantity + 1,
                ]);

                $newWishListItem = new WishListItem;
                $newWishListItem->wish_id  = $checkWishList->id;
                $newWishListItem->sale_item_id = $request->sale_item_id;
                $newWishListItem->save();
            }
        }
        return Redirect::back()->with(['danger' => 'Item had been deleted from the cart successfully']);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function show(WishList $wishList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function edit(WishList $wishList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WishList $wishList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WishList  $wishList
     * @return \Illuminate\Http\Response
     */
    public function destroy(WishList $wishList)
    {
       
    }

    public function delete(Request $request)
    {
      
        $findWishListItem =  WishListItem::where([
            ['wish_id', '=', $request->wish_id],
            ['sale_item_id', '=', $request->sale_item_id],
        ])->first();

        $findWishListItem->delete();

        return Redirect::back()->with(['danger' => 'Item had been deleted from the cart successfully']);
    }
}
