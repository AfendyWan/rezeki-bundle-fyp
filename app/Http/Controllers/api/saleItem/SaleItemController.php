<?php

namespace App\Http\Controllers\api\saleItem;

use App\Models\SaleItem;
use App\Models\SaleItemCategory;
use App\Models\SaleItemImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleItemController extends Controller{
    public function showAllSaleItem()
    {
        $allSaleItem = SaleItem::all();
        return response()->json($allSaleItem);
    }

    public function store(Request $request){

        $saleItem = new SaleItem;
        $saleItem->itemName = $request->saleItemName;
        $saleItem->itemDescription = "Demo";
        $saleItem->itemPrice = 12.00;
        $saleItem->itemStock = 1;
        $saleItem->itemCategory = 17;
        $saleItem->itemPromotionPrice =  0.00;
        $saleItem->itemActivationStatus = 1;
        $saleItem->save();
        $category = SaleItemCategory::where('id', 17)->first();
     
        if ($request->hasFile('saleItemImage')) {
            $images = $request->file('saleItemImage');
            foreach($images as $image) {
                $name = time() .'-'.$image->getClientOriginalName();

                //save to upload folder within the public
                $path = $image->storeAs('sale_item', $name, 'public');
                
                //Save to public folder
                //$path = $image->storeAs('public/', $name);
                SaleItemImage::create([
                    'sale_item_id' => $saleItem->id,
                    'sale_item_category_id' => $category->id,
                    'url' => '/storage/'.$path
                ]);
            }
            // }
        }
        $updateCategoryQuantity = $category->quantity + 1;
        SaleItemCategory::where('name', $request->category)
        ->update([
            'quantity' => $updateCategoryQuantity,  
         ]);

        return response()->json(['success' => __('Sale Item Added Successfully')]);
   }

   public function updateSaleItem(Request $request)
   {
        $category = SaleItemCategory::where('id', 17)->first();

            $category = SaleItemCategory::where('name', $request->category)->first();
    
            SaleItem::where('id', $request->id)
            ->update([
                'itemName' => $request->saleItemName,
                'itemActivationStatus' => 1,
            ]);

            $allSaleItemImages = SaleItemImage::where('sale_item_id', $request->id)->get();
            
            //delete file within laravel and database
            foreach($allSaleItemImages as $i){
                $image = $i->url;
                unlink(public_path($image));
                $i->delete();
            }
            if ($request->hasFile('saleItemImage')) {
                $images = $request->file('saleItemImage');
                foreach($images as $image) {
                    $name = time() .'-'.$image->getClientOriginalName();
    
                    //save to upload folder within the public
                    $path = $image->storeAs('sale_item', $name, 'public');
                    
                    //Save to public folder
                    //$path = $image->storeAs('public/', $name);
                    SaleItemImage::create([
                        'sale_item_id' => $request->id,
                        'sale_item_category_id' => $category->id,
                        'url' => '/storage/'.$path
                    ]);
                }
                // }
            }
        return response()->json(['success' => __('Sale Item Deleted Successfully')]);
   }

   public function destroy($id)
   {
       $findSaleItem = SaleItem::find($id);
       $findSaleItem->delete();
       
       $allSaleItemImages = SaleItemImage::where('sale_item_id', $id)->get();
       
       //delete file within laravel and database
       foreach($allSaleItemImages as $i){
           $image = $i->url;
           unlink(public_path($image));
           $i->delete();
       }

      return response()->json(['success' => __('Sale Item Deleted Successfully')]);
   }
}
