<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            

            return response()->json(['token' => $token, 'name'=>auth()->user()->first_name], 200);
        } else {
      
            return response()->json([
                'errors' => "User credential is incorrect"
            ], 401);
        }
    }
}
