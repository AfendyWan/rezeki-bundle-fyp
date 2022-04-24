
@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'cart')

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

	<h1>SHOPPING CART</h1>
	@if ($getSaleItemInCart == "")
	
	@endif
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
		@if ($getSaleItemInCart != "")
		<div class="card-body table-responsive p-0">
			<table class="table table-hover text-nowrap">
				<thead>
					<tr>
						<th >Image</th>
						<th>Product</th>
						<th>Quantity</th>
						<th>Unit Price</th>
						<th>Total Price</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach ($getSaleItemInCart as $c)
					<tr>
						<td style="height:20%; width:20%;" align="center"><img style="display:block;" width="100%" height="100%" src="{{  url($c->url) }}" alt="item1" ></td>
						<td style="height:20%; width:20%;">{{ $c->itemName }}</td>
						<td>	
							<div class="quantity1">
								<form action="action_page.php">
									<button type="button" class="btn btn-outline-primary" data-id="{{ $c->quantity }}" data-toggle="modal" data-target="#saleItemQuantityCart<?php echo $c->id;?>" id="submit">{{ $c->quantity }}</button>
										<input type="hidden" name="originalQuantity" id="originalQuantity"  min="1" max="10" value="{{ $c->quantity }}">
										<input type="hidden" name="marks" id="marks" min="1" max="10" value="{{ $c->quantity }}">
								</form>				
							</div>
						</td>
						<td>
							@if ($c->itemPromotionStatus==1)
								<strike>RM {{ $c->itemPrice }}</strike> <br>
								RM {{ $c->itemPromotionPrice }}
							@else
								RM {{ $c->itemPrice }}
							@endif 
						
						</td>
						<td>RM <script> 
							if ( <?php echo $c->itemPromotionPrice?>==1){
								var a = <?php echo $c->itemPromotionPrice * $c->quantity?> ; 
							}else{
								var a = <?php echo $c->itemPrice * $c->quantity?> ; 
							}
							
							var b = (Math.round(a * 100) / 100).toFixed(2);
							document.write(b); 
							</script> </td>
						<td>
							<form action="{{ route('manageCarts.deleteCartItem') }}" method="POST">
								@csrf
								<input type="hidden" name="cartID" value="{{ $c->cart_id }}">
								<input type="hidden" name="cartItemID" value="{{ $c->id }}">
								<input type="hidden" name="saleItemID" value="{{ $c->sale_item_id }}">
								<button type="submit" class="btn btn-danger">Delete</button>
							</form>	
						</td>
					</tr>

					<!-- Modal here -->
					<div class="modal fade" id="saleItemQuantityCart<?php echo $c->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Enter item quantity</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="{{ route('manageCarts.updateCartItemQuantity') }}" method="POST">
							@csrf
						<div class="modal-body">
							<div class="form-group">
							<label class="col-form-label">Quantity: <small></small></label>
								<input type="number" class="form-control" id="quantity" name="quantity" value="{{$c->quantity}}">
								<input type="hidden" name="previousQuantity" value="{{$c->quantity}}">
								<input type="hidden" name="userID" value="{{ auth()->user()->id }}">
								<input type="hidden" name="saleItemID" value="{{$c->sale_item_id}}">
								<input type="hidden" name="cartID" value="{{$c->cart_id}}">
							</div>
							</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Add</button>
						</div>
						</form>
						</div>
					</div>
					</div>
					@endforeach

					
				</tbody>
			</table>
		</div>
		
		@endif
		<hr>

		<!-- //Total-Price-Ends-Here -->

		<!-- Checkout-Starts-Here -->
	
		<!-- //Checkout-Ends-Here -->
		<div style="display: flex; justify-content: space-around">
			<div style="font-size: 23px; font-weight: bold; color: #47484A;">Total Price: 	
				&nbsp 
				@if ($getCart != "")
					RM {{ $getCart->totalPrice }}
				@else
					RM 0.00 
				@endif
			</div>
			<div style="font-size: 23px; font-weight: bold; color: #47484A;">
			
			</div>
			<div class="" style="font-weight: bold; color: #47484A;">
			@if ($getCart != "")
				@if ($getCart->cartItemQuantity!="0")
				<a href="{{ route('managePayment.index') }}"><button type="" class="btn btn-primary">Checkout</button></a>
				@endif
			@endif
		</div>
		</div>
		<br>
	</div>
	<br>



	<!-- Content-Ends-Here -->

<br>

</body>
<!-- Body-Ends-Here -->

</html>
@endsection