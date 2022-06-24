@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'edit shipping address')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">Edit Shipping<Address></Address></h3>
</header><!-- sect-heading -->

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif



<form action="{{ route('manageShipments.updateShippingAddress') }}" method="post">
@csrf
<input type="hidden" name="id" value="{{ $getUserShippingAddress->id }}">
<div class="row1 row-space1">
    <div class="col-111">
      <div class="input-group1">
        <label class="label1">Full name</label>
          <input id="full_name" type="text" class="input--style-4 form-control @error('full_name') is-invalid @enderror" name="full_name" placeholder="Ali bin Abdul" required autocomplete="full_name" value="{{ $getUserShippingAddress->full_name }}" autofocus>
          @error('full_name')
          <span class="text-danger" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
    </div>
  </div>
  <br>
  <div class="row1 row-space1">
    <div class="col-111">
      <div class="input-group1">
        <label class="label1">Phone Number</label>
            <input id="phone_number" type="text" class="input--style-4 form-control @error('phone_number') is-invalid @enderror" name="phone_number" placeholder="0123456789" value="{{ $getUserShippingAddress->phone_number }}" required>
              @error('phone_number')
              <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror 
      </div>
    </div>
  </div>
  <br>

  <div class="row1 row-space1">
    <div class="col-111">
      <div class="input-group1">
        <label class="label1">Postcode</label>
          <input id="postcode" type="text" class="input--style-4 form-control @error('postcode') is-invalid @enderror" name="postcode" placeholder="90000" value="{{ $getUserShippingAddress->postcode }}" required autocomplete="postcode">
            @error('postcode')
              <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
               </span>
             @enderror  
      </div>
    </div>
  </div>
  <br>
  <div class="row1 row-space1">
    <div class="col-111">
      <div class="input-group1">
        <label class="label1">Shipping Address</label>
        <textarea id="shipping_address" class="input--style-4 form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" required autocomplete="shipping_address"rows="4" cols="50">{{ $getUserShippingAddress->shipping_address }}</textarea>
        
          @error('password')
          <span class="text-danger" style="color:red" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
    </div>
  </div> 
  <br>
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
    <br>
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
  <br>                    
  <button type="submit" class="btn btn-primary">Save</button>
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

