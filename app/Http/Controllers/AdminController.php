<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Adminsetting;
use App\Models\User;

class AdminController extends Controller
{
    function index(){
        return view('dashboards.admins.index');
     }
     
     function profile(){

        $getAdmin = User::where([
            ['role', '=', '1'],                   
         ])->first();

        $localDelivery = Adminsetting::where([
            ['key', '=', 'local delivery'],                   
         ])->first();

         $SabahShippingFee = Adminsetting::where([
            ['key', '=', 'Sabah courier delivery shipping fee'],                   
         ])->first();

         $SarawakShippingFee = Adminsetting::where([
            ['key', '=', 'Sarawak courier delivery shipping fee'],                   
         ])->first();

         $PeninsularShippingFee = Adminsetting::where([
            ['key', '=', 'Peninsular courier delivery shipping fee'],                   
         ])->first();

         $paymentBankName = Adminsetting::where([
            ['key', '=', 'Payment bank name'],                   
         ])->first();

         $paymentAccountNumber = Adminsetting::where([
            ['key', '=', 'Payment account number'],                   
         ])->first();

         $paymentAccHolderName = Adminsetting::where([
            ['key', '=', 'Payment account holder name'],                   
         ])->first();

         return view('dashboards.admins.profile', compact('getAdmin','localDelivery', 'SabahShippingFee', 'SarawakShippingFee', 'PeninsularShippingFee', 'paymentBankName', 'paymentAccountNumber', 'paymentAccHolderName'));
     }

     function updateProfile(Request $request){

        $request->validate([
            
            'business_address' => ['required', 'string', 'max:255'],
            'contact_number' => ['required'],
            'postcode' =>  ['required', 'numeric','digits:5'],
            'local_delivery_fee' => 'regex:/^[0-9]*\.[0-9][0-9]$/',
            'sabah_courier_delivery_fee' =>  'regex:/^[0-9]*\.[0-9][0-9]$/',
            'sarawak_courier_delivery_fee' =>  'regex:/^[0-9]*\.[0-9][0-9]$/',
            'peninsular_courier_delivery_fee' =>  'regex:/^[0-9]*\.[0-9][0-9]$/',
            'bank_acc_num' => ['required', 'string', 'max:255'],
            'bank_name' => ['required', 'string', 'max:255'],
            'bank_acc_holder_name' => ['required', 'string', 'max:255'],     
        ]);

        User::where('role', '2')
        ->update([
          
            'postcode' => $request->postcode,
            'shipping_address' => $request->business_address,
            'phone_number' => $request->contact_number,                                 
        ]);

        Adminsetting::where('key', 'local delivery')
        ->update([
               'value' => $request->local_delivery_fee,                             
        ]);

        Adminsetting::where('key', 'Sabah courier delivery shipping fee')
        ->update([
               'value' => $request->sabah_courier_delivery_fee,                             
        ]);

        Adminsetting::where('key', 'Sarawak courier delivery shipping fee')
        ->update([
               'value' => $request->sarawak_courier_delivery_fee,                             
        ]);

        Adminsetting::where('key', 'Peninsular courier delivery shipping fee')
        ->update([
               'value' => $request->peninsular_courier_delivery_fee,                             
        ]);

        Adminsetting::where('key', 'Payment bank name')
        ->update([
               'value' => $request->bank_name,                             
        ]);
        
        Adminsetting::where('key', 'Payment account number')
        ->update([
               'value' => $request->bank_acc_num,                             
        ]);

        Adminsetting::where('key', 'Payment account holder name')
        ->update([
               'value' => $request->bank_acc_holder_name,                             
        ]);

        return redirect()->route('admin.profile')
        ->with('success','Business profile has been updated');
     }
 
     function settings(){
            return view('dashboards.admins.settings');
     }
}
