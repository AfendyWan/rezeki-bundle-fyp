
@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'userTransaction')

@section('content')
<!DOCTYPE html>
<html>
<head>


<!-- For-Mobile-Apps -->
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="E Shop Cart Widget Responsive, Login Form Web Template, Flat Pricing Tables, Flat Drop-Downs, Sign-Up Web Templates, Flat Web Templates, Login Sign-up Responsive Web Template, Smartphone Compatible Web Template, Android Compatible Web Template, Free Web Designs for Nokia, Samsung, LG, Sony Ericsson, Motorola Web Design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!-- //For-Mobile-Apps -->

<!-- Custom-Theme-Files -->
<base href="{{\URL::to('/')}}">
	<link rel="stylesheet" href="cart_assets/css/style.css" type="text/css" media="all" />
<!-- //Custom-Theme-Files -->

</head>

<!-- Body-Starts-Here -->
<body>

	<h1>Shipment</h1>
	@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
	@endif
	@if ($message = Session::get('error'))
    <div class="alert alert-danger">
        {{ $message }}
    </div>
	@endif
	<!-- Content-Starts-Here -->
	<div class="card-body table-responsive p-0">
    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>No.</th>        
                <th width="280px">Full Address</th>   
                         
                <th>Shipping Fee</th>
                <th>Shipping Option</th>
                <th>Delivery Date Time</th>
                <th>Shipping Courier Delivery</th>
                <th>Shipping Tracking Number</th>
                <th>Shipping Status</th>
                <th>Payment Date Time</th> 
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($getUserShipment as $dt)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $dt->shippingAddress }}</td>
            
            <td>RM 1</td>
            <td>{{ $dt->shippingOption }}</td>
            <td>
                @if($dt->shippingLocalDateTime=="")
                    Not Available
                @else
                    {{$dt->shippingLocalDateTime}}
                @endif
            </td>
            <td>
                @if($dt->shippingCourier=="")
                    Not yet update
                @else
                    {{$dt->shippingCourier}}
                @endif
            </td>
            <td>
                @if($dt->shippingTrackingNumber=="")
                    Not yet update
                @else
                    {{$dt->shippingTrackingNumber}}
                @endif
            </td>
            <td>{{ $dt->shippingStatus }}</td>
            <td>{{ $dt->paymentDate }}</td>
            <td>
            <a href="{{ route('manageTransactions.userViewOrderItems', $dt->orderID) }}" class="btn btn-sm btn-info">View order Items</a>
            </td>
        </tr>  
        @endforeach
        </tbody>
    </table>
</div>
	

	<!-- Content-Ends-Here -->

<br>

</body>
<!-- Body-Ends-Here -->

</html>
@endsection