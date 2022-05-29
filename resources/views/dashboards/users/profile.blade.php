@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'My Profile')

@section('content')
<section class="section-content">
<head>
  



    <!-- Main CSS-->
    <link href="register_assets/css/main.css" rel="stylesheet" media="all">
</head>
<div class="container">

<header class="section-heading">
  <h3 class="section-title">My Profile</h3>
</header><!-- sect-heading -->

@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($message = Session::get('danger'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($errors->any())
    <br>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
                    <form method="POST" action="{{ route('user.updateProfile') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row1 row-space1">
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">first name</label>
                                    <input id="first_name" type="text" class="input--style-4 form-control @error('first_name') is-invalid @enderror" name="first_name" placeholder="Ali" value="{{ $user->first_name }}" required autocomplete="first_name" autofocus>
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
                                    <input id="last_name" type="text" class="input--style-4 form-control @error('last_name') is-invalid @enderror" name="last_name" placeholder="Bin Abu" value="{{ $user->last_name }}" required autocomplete="last_name" autofocus>
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
                                    <input id="email" type="email" class="input--style-4 form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" placeholder="joe@email.com" required autocomplete="email">
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
                                    <input id="phone_number" type="text" class="input--style-4 form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="0123456789" value="{{ $user->phone_number }}" required>
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
                                    <input id="postcode" type="text" class="input--style-4 form-control @error('postcode') is-invalid @enderror" name="postcode" placeholder="90000" value="{{ $user->postcode }}" required autocomplete="postcode">
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
                                    <textarea id="shipping_address" class="input--style-4 form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" required autocomplete="shipping_address"rows="4" cols="50">{{ $user->shipping_address }}</textarea>
                                    @error('shipping_address')
                                        <span class="text-danger" style="color:red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                      
                        <div class="row1 row-space1">
                            <div class="col-222">
                                <div class="input-group1">
                                <label for="state" class="form-label">State</label>
                                    <select class="form-control" name="state" id="state">
                                        <option hidden>Choose States</option>
                                        @foreach ($state as $item)
                                        <option value="{{ $item->id }}">{{ $item->states_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('state')
                                        <span class="text-danger" style="color:red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-222">
                                <div class="input-group1">
                                <label for="city" class="form-label">City</label>
                                <select class="form-control" name="city" id="city"></select>
                                @error('city')
                                    <span class="text-danger" style="color:red" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row1 row-space1">
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Choose Profile Image</label>
                                    <input type="file" name="images"  class="form-control" accept="image/*">
                                    @error('images')
                                        <span class="text-danger" style="color:red" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">Old Password</label>
                                    <input id="password-confirm" type="password" class="input--style-4 form-control" name="old_password" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        <div class="row1 row-space1">
                            <div class="col-222">
                                <div class="input-group1">
                                    <label class="label1">New Password</label>
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
                                    <label class="label1">Confirm New Password</label>
                                    <input id="password-confirm" type="password" class="input--style-4 form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>
                        
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit">Save</button>
                        </div>
                    </form>



</div> <!-- container .//  -->
<script>
            $(document).ready(function() {
            $('#state').on('change', function() {
               var stateID = $(this).val();
               if(stateID) {
                   $.ajax({
                       url: '/getCities/'+stateID,
                       type: "GET",
                       data : {"_token":"{{ csrf_token() }}"},
                       dataType: "json",
                       success:function(data)
                       {
                         if(data){
                            $('#city').empty();
                            $('#city').append('<option hidden>Choose City</option>'); 
                            $.each(data, function(key, city){
                                $('select[name="city"]').append('<option value="'+ city.cities_name +'">' + city.cities_name+ '</option>');
                            });
                        }else{
                            $('#city').empty();
                        }
                     }
                   });
               }else{
                 $('#course').empty();
               }
            });
            });
        </script>
</section>
@endsection



