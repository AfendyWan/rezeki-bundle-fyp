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

<form action="{{ route('manageShipments.updateShippingDefault') }}" method="POST">
@csrf
  <h5>Please select your default shipping address:</h5>
  @foreach ($getUserShippingAddress as $s)
    @if ($s->shipping_default_status==1)
      <input type="radio" name="shipping_default" value="{{$s->id}}" checked>
      <label for="">{{$s->shipping_address}}</label>
    @else
      <input type="radio" name="shipping_default" value="{{$s->id}}">
      <label for="">{{$s->shipping_address}}</label>
    @endif
  @endforeach
  <br><br>
  <button type="submit" class="btn btn-primary">Save</button>
</form>



</div> <!-- container .//  -->
</section>
@endsection

