@extends('layouts.guest-dash-layout')

@section('title', 'Register')

@section('content')
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title Page-->
    <title>Register</title>

    <!-- Icons font CSS-->
    <link href="register_assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="register_assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="register_assets/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="register_assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="register_assets/css/main.css" rel="stylesheet" media="all">
</head>

<body>
<div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Sign up now to become our latest member!</h2>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="row1 row-space1">
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">first name</label>
                                    <input id="first_name" type="text" class="input--style-4 form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Ali" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                                    @error('first_name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">last name</label>
                                    <input id="last_name" type="text" class="input--style-4 form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Bin Abu" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus>
                                @error('last_name')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row1 row-space1">
                            <!-- <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Birthday</label>
                                    <div class="input-group-icon">
                                        <input id="birthday" class="input--style-4 js-datepicker" type="text" name="birthday" required autocomplete="birthday">
                                        <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Email</label>
                                    <input id="email" type="email" class="input--style-4 form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="joe@email.com" required autocomplete="email">
                                @error('email')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror    
                                </div>
                            </div>
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Gender</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio" checked="checked" name="gender" value = "male">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" name="gender" value = "female">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row1 row-space1">
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Phone Number</label>
                                    <input id="phone_number" type="text" class="input--style-4 form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="0123456789" value="{{ old('phone_number') }}" required>
                                @error('phone_number')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
                                </div>
                            </div>
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Postcode</label>
                                    <input id="postcode" type="text" class="input--style-4 form-control @error('postcode') is-invalid @enderror" name="postcode" placeholder="90000" value="{{ old('postcode') }}" required autocomplete="postcode">
                                @error('postcode')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror    
                                </div>
                            </div>
                        </div>
                        <div class="row1 row-space1">
                            <div class="col-111">
                                <div class="input-group1">
                                    <label class="label1">Shipping Address</label>
                                    <input id="shipping_address" type="text" class="input--style-4 form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" required autocomplete="shipping_address">
                                    @error('password')
                                        <span class="text-danger" style="color:red" role="alert">
                                            <strong>{{ $shipping_address }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row1 row-space1">
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Password</label>
                                    <input id="password" type="password" class="input--style-4 form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="text-danger" style="color:red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Confirm Password</label>
                                    <input id="password-confirm" type="password" class="input--style-4 form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Sign Up</button>
                        </div>
                    </form>
                    <br>
                    <p>Already have an account? <a href="{{ route('login') }}">Sign in</a> now!</p>
                </div>
            </div>
        </div>
        </div>

    <!-- Jquery JS-->
    <script src="register_assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="register_assets/vendor/select2/select2.min.js"></script>
    <script src="register_assets/vendor/datepicker/moment.min.js"></script>
    <script src="register_assets/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="register_assets/js/global.js"></script>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->


@endsection