
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

	<h1>Order History</h1>
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
                <th>Order ID</th>                
                <th>Order Date and Time</th>
                <th>Order Status</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($getAllTransaction as $dt)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $dt->order_number }}</td>
            <td>{{ $dt->orderDate }}</td>
            <td>{{ $dt->orderStatus }}</td>
            <td>RM {{ $dt->totalPrice }}</td>
            <td>
            <a href="{{ route('manageTransactions.userViewOrderItems', $dt->orderID) }}" class="btn btn-sm btn-info">View Order Items</a>
            <a href="{{ route('manageTransactions.userViewOrderItems', $dt->orderID) }}" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#paymentInfo<?php echo $i;?>">View Payment </a>

            </td>
        </tr>  

<!-- Payment view information modal here -->
<div class="modal fade" id="paymentInfo<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id=""><strong style="font-weight: 900; color: black; font-size: 20px" >Payment info for order {{ $dt->order_number }}</strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <div class="modal-body">

           
            Payment Status: <b style="font-weight: 900; color: black">{{$dt->paymentStatus}}</b><br><hr>
            Shipping Price: <b style="font-weight: 900; color: black">RM {{$dt->shippingPrice}}</b><br><hr>
            Subtotal Price: <b style="font-weight: 900; color: black">RM {{$dt->subTotalPrice}}</b><br><hr>
            Total Price: <b style="font-weight: 900; color: black">RM {{$dt->totalPrice}}</b><br><hr>
            Payment Time: <b style="font-weight: 900; color: black">{{$dt->paymentDate}}</b><br><hr>
            Remark: <b style="font-weight: 900; color: black">{{$dt->remark}}</b><br>



        
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <a id="myLink" href="{{$dt->url}}" target="_blank"><button type="button" class="btn btn-primary" >View Payment Receipt</button></a>
            <!-- <button type="button" class="btn btn-primary" onclick="window.open(this.href,'popUpWindow','height=400,width=600,left=10,top=10,,scrollbars=yes,menubar=no'); ">View Payment Receipt</button> -->
        </div>
        </div>
    </div>
</div>
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