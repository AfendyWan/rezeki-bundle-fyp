<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
use App\Models\SaleItemCategory;
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
       
         SaleItem::create([
            'itemName' => $request->name,
            'itemDescription' => $request->description,
            'itemPrice' => $request->price,
            'itemStock' => $request->stock,
            'itemCategory' => $category->id,
            'itemPromotionStatus' => 0,
            'itemPromotionPrice' => 0.00,
            'itemActivationStatus' => 1,
        ]);

        $updateCategoryQuantity = $category->quantity + 1;
        SaleItemCategory::where('name', $request->category)
        ->update([
            'quantity' => $updateCategoryQuantity,  
         ]);
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
