<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SaleItemImage;
use App\Models\SaleItemCategory;
use App\Models\UserProfilePhoto;
use App\Models\User;
use App\Models\State;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    function index(){
      
        //group by also can be synonym as distinct, however,
        //$sale = SaleItemImage::select('url','sale_item_category_id')->groupBy('sale_item_category_id')->get(); invalid query unless strict in db change to false
        //$sale = SaleItemImage::select('sale_item_category_id')->groupBy('sale_item_category_id')->get();
        //dd(count($sale));


        //distinct value refer to sale_item_images.sale_item_id
        // $a = DB::table('sale_item_categories')->select('sale_item_categories.*')
        // ->join('sale_item_images', 'sale_item_categories.id', '=', 'sale_item_images.sale_item_id')
        // ->distinct()
        // ->get();

 
        $saleItemCatalogue = DB::table('sale_item_categories')
        ->join('sale_item_images', 'sale_item_categories.id', '=', 'sale_item_images.sale_item_category_id')
        ->select('sale_item_categories.*', 'sale_item_images.*')
        ->groupby('sale_item_images.sale_item_category_id')
        ->get();

     
        return view('dashboards.users.index', compact('saleItemCatalogue'));
    }
    
    function profile(){
        $state = State::all();
        $user  = User::find(auth()->user()->id);        
        return view('dashboards.users.profile', compact('user', 'state'));

    }

    function updateProfile(Request $request){
        
        $user  = User::find(auth()->user()->id);  
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->route('user.profile')
       ->with('danger','New password is not the same as old password');
            
         } 

      
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', ],
            'gender' => 'required',          
            'postcode' => ['required', 'numeric','digits:5'],
            'phone_number' => 'required|numeric|regex:/(01)[0-9]/|digits_between:10,11',
            'shipping_address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'state' => ['required'],
            'city' => ['required'],
            'images' => 'required',
        ]);

        $checkHasImages = UserProfilePhoto::where('userID', $user->id)->first();
        
       
        if ($request->hasfile('images')) {
           
            if($checkHasImages){
                $checkHasImages->delete();
            }
            $images = $request->file('images');
           
                
                $name = time() .'-'.$images->getClientOriginalName();
               
                //save to upload folder within the public
                $path = $images->storeAs('user_profile', $name, 'public');
                
                //Save to public folder
                //$path = $image->storeAs('public/', $name);
               
                UserProfilePhoto::create([
                    'userID' => $user->id,                    
                    'url' => '/storage/'.$path
                ]);
                
            
       }

       User::where('id', $user->id)
       ->update([
              'first_name' => $request->first_name,
              'last_name' => $request->last_name,
              'email' => $request->email,
              'gender' => $request->gender,
              'phone_number' => $request->phone_number,
              'postcode' => $request->postcode,
              'shipping_address' => $request->shipping_address,
              'password' => Hash::make($request->password),
       ]);

       return redirect()->route('user.profile')
       ->with('success','Saved successfully.');

    }

    function settings(){
           return view('dashboards.users.settings');
    }
}
