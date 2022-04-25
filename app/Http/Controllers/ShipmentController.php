<?php

namespace App\Http\Controllers;

use App\Models\Shipment;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;;
use App\Models\State;
use App\Models\City;
use App\Models\UserShippingAddress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
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
       
    }

    public function adminShipmentIndex()
    {
        $getAllShipmentOrders = DB::table('orders')
        ->join('users', 'orders.userID', '=', 'users.id')
        ->join('payments', 'orders.paymentID', '=', 'payments.id')
        ->join('shipments', 'orders.shipmentID', '=', 'shipments.id')
        ->select('users.*', 'orders.*', 'payments.*', 'shipments.*','orders.id as orderID')
        ->get();
       

        $userShippingAddress = UserShippingAddress::where([
           
            ['shipping_default_status', '=', 1],           
         ])->get();
 
     
         $userShippingAddressState = State::all();

        return view('dashboards.admins.manageShipments.index', compact('getAllShipmentOrders', 'userShippingAddress', 'userShippingAddressState')) ->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function adminUpdateShipment($id){
        $shipment = Shipment::find($id);
       
        return view('dashboards.admins.manageShipments.edit', compact('shipment'));
    }

    public function adminSaveShipment(Request $request){
        $request->validate([
            'couriers' => 'required',
            'shippingTrackingNumber' => ['required'],
            'status' => 'required',
            
        ]);

        Shipment::where('id', $request->id)
        ->update([
               'shippingCourier' => $request->couriers,
               'shippingTrackingNumber' => $request->shippingTrackingNumber,
               'shippingStatus' => $request->status,              
        ]);
        
        return redirect()->route('manageShipments.adminShipmentIndex')->with('success','Shipment updated successfully.');
       
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
