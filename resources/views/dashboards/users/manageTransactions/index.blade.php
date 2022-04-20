
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
	<div class="container1">

		<!-- Mainbar-Starts-Here -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<h3 class="card-title"></h3>
					<div class="card-tools">
			
			</div>
		</div>
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
                    <a href="{{ route('manageTransactions.userViewOrderItems', $dt->orderID) }}" class="btn btn-sm btn-info">View order Items</a>
                    </td>
                </tr>  
                @endforeach
				</tbody>
			</table>
		</div>
	</div>
	

	<!-- Content-Ends-Here -->

<br>

</body>
<!-- Body-Ends-Here -->

</html>
@endsection