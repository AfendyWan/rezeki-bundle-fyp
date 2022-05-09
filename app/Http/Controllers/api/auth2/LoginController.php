<?php

namespace App\Http\Controllers;

use App\Models\Cart; 
use App\Models\SaleItem;
use App\Models\CartItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Redirect;
use Auth;
use DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function login(Request $request)
    {
       
        $email = $request->email;
        $password = $request->password;

        if( auth()->attempt(array('email'=>$email, 'password'=>$password)) ){
            $db = User::join('employees', 'users.id', '=', 'employees.id')
            ->where('username', '=', $username)
            ->select('users.*', 'employees.first_name', 'employees.last_name')
            ->first();
            $token = auth('api')->login($db);
            return $this->respondWithToken($token);
         
    
        }else{
            return response()->json(['error' => 'Password Incorrect'], 401);
        }
        $db = User::join('employees', 'users.id', '=', 'employees.id')
            ->where('username', '=', $username)
            ->select('users.*', 'employees.first_name', 'employees.last_name')
            ->first();
        if ($password == Crypt::decryptString($db->password)) {
            $token = auth('api')->login($db);
            return $this->respondWithToken($token);
        } else {
            return response()->json(['error' => 'Password Incorrect'], 401);
        }

        // $password = Crypt::decryptString(request('password'));

        // collect(User::select('password', 'id')->where('username', '=', $username)->get()->all())->map(function ($pw) use ($dbpw, $uid) {
        //     $dbpw = $pw->password;
        //     $uid = $pw->id;
        // });

        // if($password != Crypt::decryptString($dbpw)){
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // } else {
        //     $token = auth()->tokenById($pw->id);
        //     return $this->respondWithToken($token);
        // }




        // if($password == Crypt::decryptString($dbpw)){
        //     $token = auth()->attempt($username, $password);
        //     return $this->respondWithToken($token);
        // } else {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // $credentials = [
        //     'username' => request('username'),
        //     'password' => Crypt::encryptString(request('password'))
        // ];

        // dd($credentials);

        // if (! $token = auth()->attempt($username, $password)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->respondWithToken($token);
    }
}
