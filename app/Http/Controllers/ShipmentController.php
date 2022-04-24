<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\State;
use App\Models\City;
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
        
        $state = State::all();
     

        return view('dashboards.users.manageShipments.create', compact('getUserShippingAddress', 'state'));
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

    public function addNewShippingAddress(Request $request)
    {
        $request->validate([
            'postcode' => ['required', 'numeric','digits:5'],
            'shipping_address' => ['required', 'string', 'max:255'],
        ]);
        
        $getUserShippingAddress = UserShippingAddress::where([
            ['userID', '=', Auth::user()->id],          
        ])->get();
        
        foreach($getUserShippingAddress as $c){
            UserShippingAddress::where('id', $c->id)->update([
                'shipping_default_status' => 0,                
            ]);
        }

        $newUserShipping = new UserShippingAddress;
        $newUserShipping->shipping_default_status = 1;
        $newUserShipping->shipping_address = $request->shipping_address;
        $newUserShipping->state = $request->state;
        $newUserShipping->city = $request->city;
        $newUserShipping->postcode = $request->postcode;
        $newUserShipping->userID = Auth::user()->id;
        $newUserShipping->save();
        
  

        return Redirect::back()->with(['success' => 'New shipping address had been added']);
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
