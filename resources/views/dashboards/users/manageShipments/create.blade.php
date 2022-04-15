@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'showItemList')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">Shipping <Address></Address></h3>
</header><!-- sect-heading -->

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif
<hr>
<form action="{{ route('manageShipments.updateShippingDefault') }}" method="POST">
@csrf
  <h5>Please select your default shipping address:</h5>
  @foreach ($getUserShippingAddress as $s)
    @if ($s->shipping_default_status==1)
      <input type="radio" name="shipping_default" value="{{$s->id}}" checked>
      <label for="">{{$s->shipping_address}}</label><br>
    @else
      <input type="radio" name="shipping_default" value="{{$s->id}}">
      <label for="">{{$s->shipping_address}}</label><br>
    @endif
  @endforeach
  <br>
  <button type="submit" class="btn btn-primary">Save</button>
</form>
<br>
<hr>
<h5>Add new shipping address:</h5>

<form action="{{ route('manageShipments.addNewShippingAddress') }}" method="post">
@csrf
  <div class="row1 row-space1">
    <div class="col-111">
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
  <br>
  <div class="row1 row-space1">
    <div class="col-111">
      <div class="input-group1">
        <label class="label1">Shipping Address</label>
        <input id="shipping_address" type="text" class="input--style-4 form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" required autocomplete="shipping_address">
          @error('password')
          <span class="text-danger" style="color:red" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
    </div>
  </div> 
  <br>                    
  <button type="submit" class="btn btn-primary">Add</button>
</form>
</div> <!-- container .//  -->
</section>
@endsection

