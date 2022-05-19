<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\UserShippingAddress;
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
}
