<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserShippingAddress;
use App\Models\UserProfilePhoto;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => "Invalid format for user credential"], 403);
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('RezekiBundleCustomerAuth')->accessToken;
            

            return response()->json(['token' => $token,  'id'=>auth()->user()->id, 'first_name'=>auth()->user()->first_name, 'last_name'=>auth()->user()->last_name, 'email'=>auth()->user()->email, 'role'=>auth()->user()->role, 'gender'=>auth()->user()->gender, 'phone_number'=>auth()->user()->phone_number, 'postcode'=>auth()->user()->postcode], 200);
        } else {
      
            return response()->json([
                'errors' => "User credential is incorrect"
            ], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => 'required',
            //'birthday' => 'required',
            'postcode' => ['required', 'numeric','digits:5'],
            'phone_number' => 'required|numeric|regex:/(01)[0-9]/|digits_between:10,11',
            'shipping_address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'state' => ['required'],
            'city' => ['required'],
        ], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
        ]);
      
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        }
       
        $newUser = new User;
        $newUser->first_name = $request['first_name'];
        $newUser->last_name = $request['last_name'];
        $newUser->email = $request['email'];
        $newUser->role = 2;
        $newUser->gender = $request['gender'];
        $newUser->postcode = $request['postcode'];
        $newUser->phone_number = $request['phone_number'];
        $newUser->shipping_address = $request['shipping_address'];
        $newUser->password = Hash::make($request['password']);
        $newUser->save();

        $userID = $newUser->id;

        UserShippingAddress::create([
            'userID' => $userID,
            'shipping_default_status' => 1,
            'shipping_address' => $request['shipping_address'],
            'state' => $request['state'],
            'city' => $request['city'],
            'postcode' => $request['postcode'],
        ]);
   

        $token = $newUser->createToken('RezekiBundleCustomerAuth')->accessToken;


        return response()->json(['token' => $token, 'name'=>$newUser->first_name ], 200);
    }

    public function changeProfilePhoto(Request $request){

        $user  = User::find($request->userID);  
        $checkHasImages = UserProfilePhoto::where('userID', $user->id)->first();

      
        if ($request->hasFile('profileImage')) {

            $previousProfilePhoto = UserProfilePhoto::where('userID', $user->id)->get();
       
            //delete file within laravel and database
            foreach($previousProfilePhoto as $i){
                $image = $i->url;
                unlink(public_path($image));
                $i->delete();
            }
        
            $images = $request->file('profileImage');
           
            $name = time() .'-'.$images->getClientOriginalName();
              
            //save to upload folder within the public
            $path = $images->storeAs('user_profile', $name, 'public');
            
            //Save to public folder
            //$path = $image->storeAs('public/', $name);
           
            UserProfilePhoto::create([
                'userID' => $user->id,                    
                'url' => '/storage/'.$path
            ]);
            // }
        }else{
            return response()->json(['fail' => __('Profile photo failed to changes')]);
        }
        return response()->json(['success' => __('Profile photo changes successfully')]);
    }

    
    public function getProfilePhoto(Request $request){
      
        $profilePhoto = UserProfilePhoto::where('userID', $request->userID)->first();
        if($profilePhoto){
            return response()->json($profilePhoto->url, 200, ['Connection' => 'keep-alive']);
        }else{
            return response()->json("failed", 200, ['Connection' => 'keep-alive']);
        }       
    }

    public function updateUserData(Request $request){

        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', ],
            'gender' => 'required',
            //'birthday' => 'required',
            'postcode' => ['required', 'numeric','digits:5'],
            'phone_number' => 'required|numeric|regex:/(01)[0-9]/|digits_between:10,11',
          
        
        ], [
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        }
       
        User::where('id', $request->userID)
        ->update([
               'first_name' => $request->first_name,
               'last_name' => $request->last_name, 
               'email' => $request->email, 
               'gender' =>  $request->gender, 
               'phone_number' => $request->phone_number, 
               'postcode' =>$request->postcode, 
                   
        ]);
        
        // UserShippingAddress::where([
        //     ['userID', '=', $user->id],    
        //     ['shipping_default_status', '=', 1],                 
        // ])->update([
        //     'shipping_address' => $request['shipping_address'],
        //     'state' => $request['state'],
        //     'city' => $request['city'],
        // ]);

        return response()->json(['success' => __('User profile saved successfully')]);
    }

    public function changeUserPassword(Request $request){
        $user  = User::find($request->userID);  
        if (!Hash::check($request->oldPassword, $user->password)) {
            return response()->json(['Errors' => __('Password not match')], 402);

            
         } 
  
       

        
        User::where('id', $request->userID)
        ->update([
            
               'password' => Hash::make($request->newPassword)
        ]);

        return response()->json(['success' => __('User password saved successfully')]);
    }
}
