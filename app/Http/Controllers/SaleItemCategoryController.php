<?php

namespace App\Http\Controllers;

use App\Models\SaleItemCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaleItemCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $saleItemCategory = SaleItemCategory::orderBy('updated_at', 'DESC')->sortable()->paginate(10);
    // dd($saleItemCategory);
        return view('dashboards.admins.manageCategories.index',compact('saleItemCategory'))
            ->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboards.admins.manageCategories.create');
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
            'name' => 'required|string|max:255|unique:sale_item_categories,name',
            'description' => 'required',
        
        ]);
        SaleItemCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'quantity'=> 0,
        ]);
       //SaleItemCategory::create($request->all());
        return redirect()->route('manageCategories.index')
        ->with('success','New category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SaleItemCategory  $saleItemCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SaleItemCategory $saleItemCategory)
    {
        return redirect('admin/manageCategories');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SaleItemCategory  $saleItemCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $saleItemCategory  = SaleItemCategory::find($id);
        return view('dashboards.admins.manageCategories.edit')->withCategory($saleItemCategory);
        //withCategory($saleItemCategory); mean pass the $saleItemCategory as $category
        //return view('dashboards.admins.manageCategories.edit',compact('saleItemCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SaleItemCategory  $saleItemCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SaleItemCategory $saleItemCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:sale_item_categories,name',
            'description' => 'required',  
        ]);
        SaleItemCategory::where('id', $request->id)
       ->update([
           'name' => $request->name,
           'description' => $request->description,  
        ]);
     
        return redirect()->route('manageCategories.index')
        ->with('success','Categories updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SaleItemCategory  $saleItemCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $findCategory = SaleItemCategory::find($id);
        $findCategory->delete();
    
        return redirect()->route('manageCategories.index')
                        ->with('success','Categories deleted successfully');
    }
}
