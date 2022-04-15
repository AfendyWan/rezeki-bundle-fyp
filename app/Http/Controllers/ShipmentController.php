<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\UserShippingAddress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Redirect;
class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $getUserShippingAddress = UserShippingAddress::where([
            ['userID', '=', Auth::user()->id],          
        ])->get();
        
        return view('dashboards.users.manageShipments.create', compact('getUserShippingAddress'));
    }

    public function updateShippingDefault(Request $request)
    {
        $getUserShippingAddress = UserShippingAddress::where([
            ['userID', '=', Auth::user()->id],          
        ])->get();
        
        foreach($getUserShippingAddress as $c){
            UserShippingAddress::where('id', $c->id)->update([
                'shipping_default_status' => 0,                
            ]);
        }
        UserShippingAddress::where('id', $request->shipping_default)->update([
            'shipping_default_status' => 1,                
        ]);

        return Redirect::back()->with(['success' => 'Default shipping address had been updated']);
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
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function show(Shipment $shipment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipment $shipment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shipment  $shipment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        //
    }
}
