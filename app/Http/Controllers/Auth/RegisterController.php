<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\UserShippingAddress;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'user/dashboard';
    

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => 'required',
            //'birthday' => 'required',
            'postcode' => ['required', 'numeric','digits:5'],
            'phone_number' => 'required|numeric|regex:/(01)[0-9]/|digits_between:10,11',
            'shipping_address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'state' => ['required'],
            'city' => ['required'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $newUser = new User;
        $newUser->first_name = $data['first_name'];
        $newUser->last_name = $data['last_name'];
        $newUser->email = $data['email'];
        $newUser->role = 2;
        $newUser->gender = $data['gender'];
        $newUser->postcode = $data['postcode'];
        $newUser->phone_number = $data['phone_number'];
        $newUser->shipping_address = $data['shipping_address'];
        $newUser->password = Hash::make($data['password']);
        $newUser->save();

        $userID = $newUser->id;
        
        $fullName = $data['first_name'] . " " . $data['last_name'];
        UserShippingAddress::create([
            'full_name' => $fullName,
            'phone_number' => $data['phone_number'],
            'userID' => $userID,
            'shipping_default_status' => 1,
            'shipping_address' => $data['shipping_address'],
            'state' => $data['state'],
            'city' => $data['city'],
            'postcode' => $data['postcode'],
        ]);
        return $newUser;
    }
}
