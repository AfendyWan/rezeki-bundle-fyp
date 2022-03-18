<?php

namespace App\Http\Controllers;

use App\Models\SaleItem;
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
        //
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
