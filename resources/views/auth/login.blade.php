
@extends('layouts.guest-dash-layout')

@section('title', 'Login')

@section('content')
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="login_assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="login_assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="login_assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="login_assets/css/style.css">

    <title>Login</title>
   
  </head>
  <body>
  

  <div class="d-lg-flex half">
  <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7">
            <h3>Login to <strong>Rezeki Bundle</strong></h3>
            <p class="mb-4">Come and join as the latest member of Rezeki Bundle</p>
            <form method="POST" action="{{ route('login') }}">
                @csrf
              <div class="form-group first">
                <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="joe@email.com" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

              </div>
              <div class="form-group last mb-3">
                <label for="password">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" name="password" required autocomplete="current-password">
                    @error('password')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    @if (session('error'))     
                        <span class="text-danger" role="alert">
                            <strong>{{ session('error') }}  </strong>
                        </span>
                    @endif
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption"> {{ __('Remember Me') }}</span>
                  <input type="checkbox" checked="checked"/>
                  <div class="control__indicator"></div>
                </label>
                @if (Route::has('password.request'))
                <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> 
                 @endif
              </div>

              <input type="submit" value="Log In" class="btn btn-block btn-primary">

            </form>
            <br>
            <p style="color:black">Don't have an account?  &nbsp<a href="{{ route('register') }}" style="color:blue">Sign up</a> here</p>
          </div>
        </div>
      </div>

    
  </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>



@endsection
