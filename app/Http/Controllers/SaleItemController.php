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
        $saleItem = SaleItem::latest()->paginate(5);
    
        return view('dashboards.admins.manageSaleItems.index',compact('saleItem'))
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
        ]);
        
        $category = SaleItemCategory::where('name', $request->category)->first();

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
                $name = $image->getClientOriginalName();

                //save to upload folder within the public
                $path = $image->storeAs('uploads', $name, 'public');
                
                //Save to public folder
                //$path = $image->storeAs('public/', $name);
                SaleItemImage::create([
                    'sale_item_id' => $saleItem->id,
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
    public function show(SaleItem $saleItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function edit(SaleItem $saleItem)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleItem  $saleItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaleItem $saleItem)
    {
        //
    }
}
