
@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'wishlist')

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

<!-- Remove-Item-JavaScript -->
	<!-- <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script> -->
	<!-- <script>$(document).ready(function(c) {
		$('.alert-close1').on('click', function(c){
			$('.close1').fadeOut('slow', function(c){
		  		$('.close1').remove();
			});
		});	  
	});
	</script>
	<script>$(document).ready(function(c) {
		$('.alert-close2').on('click', function(c){
			$('.close2').fadeOut('slow', function(c){
		  		$('.close2').remove();
			});
		});	  
	});
	</script>
	<script>$(document).ready(function(c) {
		$('.alert-close3').on('click', function(c){
			$('.close3').fadeOut('slow', function(c){
		  		$('.close3').remove();
			});
		});	  
	});
	</script> -->
<!-- //Remove-Item-JavaScript -->

</head>

<!-- Body-Starts-Here -->
<body>

	<h1>WISH LIST</h1>
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
						<th>Image</th>
						<th>Product</th>
						<th>Unit Price</th>
					    <th>Action</th>
					</tr>
				</thead>
				<tbody>
				@foreach ($getSaleItemInWishList as $c)
					<tr>
						<td style="height:20%; width:20%;" align="center"><img style="display:block;" width="100%" height="100%" src="{{  url($c->url) }}" alt="item1" ></td>
						<td style="height:20%; width:20%;">{{ $c->itemName }}</td>
					
						<td>
							@if ($c->itemPromotionStatus==1)
								<strike>RM {{ $c->itemPrice }}</strike> <br>
								RM {{ $c->itemPromotionPrice }}
							@else
								RM {{ $c->itemPrice }}
							@endif 
						
						</td>
				
						<td>
							<form action="{{ route('manageWishList.delete') }}" method="POST">
								@csrf
								<input type="hidden" name="wish_id" value="{{ $c->wish_id }}">
								<input type="hidden" name="sale_item_id" value="{{ $c->sale_item_id }}">
								<button type="submit" class="btn btn-danger">Delete</button>
							</form>	
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