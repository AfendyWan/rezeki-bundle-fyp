<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use App\Models\SaleItemCategory;
use App\Models\SaleItemImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleItem = SaleItem::all();
        //$saleItem = SaleItem::latest()->paginate(5);
        $saleItemCategory = SaleItemCategory::all();
        return view('dashboards.admins.manageSaleItems.index',compact('saleItem', 'saleItemCategory'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categoryName = SaleItemCategory::select('name')->get();
        return view('dashboards.admins.manageSaleItems.create', compact('categoryName'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sale_items,itemName',
            'description' => ['required', 'string', 'max:255'],
            'price' => 'regex:/^[0-9]*\.[0-9][0-9]$/',
            'stock' => ['required', 'numeric'],
            'category' => 'required',
            'images' => 'required|max:6',
          //  'images' => 'required|mimes:png,jpg,jpeg|max:5'
        ]);
        
        $category = SaleItemCategory::where('name', $request->category)->first();
        // date('Y-m-d-H:i:s')."-".$image->getClientOriginalName();
        
        $saleItem = new SaleItem;
        $saleItem->itemName = $request->name;
        $saleItem->itemDescription = $request->description;
        $saleItem->itemPrice = $request->price;
        $saleItem->itemStock = $request->price;
        $saleItem->itemCategory = $category->id;
        $saleItem->itemPromotionPrice =  0.00;
        $saleItem->itemActivationStatus = 1;
       
        $saleItem->save();
        //Save file within laravel
       if ($request->hasfile('images')) {
            $images = $request->file('images');
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
       }
       
  
        //  SaleItem::create([
        //     'itemName' => $request->name,
        //     'itemDescription' => $request->description,
        //     'itemPrice' => $request->price,
        //     'itemStock' => $request->stock,
        //     'itemCategory' => $category->id,
        //     'itemPromotionStatus' => 0,
        //     'itemPromotionPrice' => 0.00,
        //     'itemActivationStatus' => 1,
        // ]);

        ///////////////////////Update quantity in category
        $updateCategoryQuantity = $category->quantity + 1;
        SaleItemCategory::where('name', $request->category)
        ->update([
            'quantity' => $updateCategoryQuantity,  
         ]);
        /////////////////////////////////////////////////


        //SaleItemCategory::create($request->all());
        return redirect()->route('manageSaleItems.index')
        ->with('success','New sale item created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $saleItem  = SaleItem::find($id);
        $category = SaleItemCategory::where('id', $saleItem->itemCategory )->first();
        $firstSaleItemImage = SaleItemImage::where('sale_item_id', $id)->first();
        
        $allSaleItemImages = SaleItemImage::where('sale_item_id', $id)->get();
        return view('dashboards.admins.manageSaleItems.show', compact('category', 'firstSaleItemImage', 'allSaleItemImages'))->withSaleitem($saleItem);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleItemCategory = SaleItemCategory::all();
        $saleItem  = SaleItem::find($id);
        return view('dashboards.admins.manageSaleItems.edit', compact('saleItemCategory'))->withSaleitem($saleItem);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleItem $saleItem)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => ['required', 'string', 'max:255'],
            'price' => 'regex:/^[0-9]*\.[0-9][0-9]$/',
            'stock' => ['required', 'numeric'],
            'category' => 'required',
            'images' => 'required|max:6',
        ]);

        $category = SaleItemCategory::where('name', $request->category)->first();
        
        SaleItem::where('id', $request->id)
        ->update([
               'itemName' => $request->name,
               'itemDescription' => $request->description,
               'itemPrice' => $request->price,
               'itemStock' => $request->stock,
               'itemCategory' => $category->id,
               'itemPromotionStatus' => 0,
               'itemPromotionPrice' => 0.00,
               'itemActivationStatus' => 1,
        ]);

        $allSaleItemImages = SaleItemImage::where('sale_item_id', $request->id)->get();
        
        //delete file within laravel and database
        foreach($allSaleItemImages as $i){
            $image = $i->url;
            unlink(public_path($image));
            $i->delete();
        }

        //Save file within laravel
       if ($request->hasfile('images')) {
            $images = $request->file('images');
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
       }

       return redirect()->route('manageSaleItems.index')
       ->with('success','Sale item edited successfully.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function  destroy($id)
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

        return redirect()->route('manageSaleItems.index')
                        ->with('success','Sale item deleted successfully');
    }

    //Edit promotion settings
    public function editPromotion($id)
    {
        $saleItem  = SaleItem::find($id);
        return view('dashboards.admins.manageSaleItems.editPromotion')->withSaleitem($saleItem);
    }

    public function updatePromotion(Request $request, $id)
    {
        $request->validate([
           
            'promotionPrice' => 'regex:/^[0-9]*\.[0-9][0-9]$/',
         
        ]);
        
        //split the promotion duration into start and end
        $splitPromotionDuration = explode(" ",$request->promotionDuration);
        
        SaleItem::where('id', $id)
        ->update([
               'itemPromotionStatus' => $request->promotionStatus,
               'itemPromotionPrice' => $request->promotionPrice,
               'itemPromotionStartDate' => $splitPromotionDuration[0],
               'itemPromotionEndDate' => $splitPromotionDuration[2],
        ]);
       
        return redirect()->route('manageSaleItems.show', $id)->with('success','Sale item promotion updated successfully.');
    }

    //Toggle activation status
    public function toggleActivationStatus($id)
    {
        $saleItem = SaleItem::where('id', $id)->first();
 
        if ($saleItem->itemActivationStatus == 1) {
            SaleItem::where('id', $id)
            ->update([
               'itemActivationStatus' => 0,
            ]);
            return redirect()->back()->with('success','Sale item deactivated successfully');  
        } else {
            SaleItem::where('id', $id)
            ->update([
               'itemActivationStatus' => 1,
            ]);
            return redirect()->back()->with('success','Sale item activated successfully');  
        }
    }
}
