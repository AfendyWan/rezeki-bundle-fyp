<?php

namespace App\Http\Controllers\api\wishlist;

use App\Models\SaleItem;
use App\Models\WishListItem;
use App\Models\WishList;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class WishListController extends Controller{

    public function isWishList(Request $request)
    {     
        $getWishList = WishList::where('userID', $request->userID)->first();
        if(!$getWishList){
            $isWishList = false;
            return response()->json($isWishList, 200, ['Connection' => 'keep-alive']);
        }
  
        $getWishListItem = WishListItem::where([
            ['wish_id', '=', $getWishList->id],
            ['sale_item_id', '=', $request->saleItemID],
        ])->first();

        if(!$getWishListItem){
            $isWishList = false;
            return response()->json($isWishList, 200, ['Connection' => 'keep-alive']);
        }else{
            $isWishList = true;
            return response()->json($isWishList, 200, ['Connection' => 'keep-alive']);
        }

    }  

    public function toggleWishList(Request $request){

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
            $newWishListItem->sale_item_id = $request->saleItemID;
            $newWishListItem->save();
            $result = "Like";
            return response()->json($result, 200, ['Connection' => 'keep-alive']);
        }else{
            if($request->liked == "true"){
                WishList::where('id', $checkWishList->id)->update([
                    'wishItemQuantity' => $checkWishList->wishItemQuantity - 1,
                ]);

                $findWishListItem =  WishListItem::where([
                    ['wish_id', '=', $checkWishList->id],
                    ['sale_item_id', '=', $request->saleItemID],
                ])->first();

                $findWishListItem->delete();
                $result = "Dislike";
                return response()->json($result, 200, ['Connection' => 'keep-alive']);
            }else{
                WishList::where('id', $checkWishList->id)->update([
                    'wishItemQuantity' => $checkWishList->wishItemQuantity + 1,
                ]);

                $newWishListItem = new WishListItem;
                $newWishListItem->wish_id  = $checkWishList->id;
                $newWishListItem->sale_item_id = $request->saleItemID;
                $newWishListItem->save();
                $result = "Like";
                return response()->json($result, 200, ['Connection' => 'keep-alive']);
            }
        }

        
    }

    public function getUserWishList($id)
    {     
        $getWishList = WishList::where([
            ['userID', '=', $id],
        ])->first();

        if(!$getWishList){
            $getSaleItemInWishList = "";
        }else{
            $getSaleItemInWishList = DB::table('wish_list_items')
            ->join('sale_items', 'wish_list_items.sale_item_id', '=', 'sale_items.id')
            ->join('sale_item_images', 'wish_list_items.sale_item_id', '=', 'sale_item_images.sale_item_id')
            ->select('wish_list_items.*', 'sale_items.*', 'sale_item_images.*', 'sale_items.id as itemID')
            ->where('wish_id', '=', $getWishList->id)
            ->groupby('wish_list_items.sale_item_id')
            ->get();
        }
        
        return response()->json($getSaleItemInWishList, 200, ['Connection' => 'keep-alive']);

    }  
}
