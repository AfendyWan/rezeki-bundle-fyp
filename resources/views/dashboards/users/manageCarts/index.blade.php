
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
		<div class="main-bar">
			<div class="product">
				<h3>Product</h3>
			</div>
			<div class="quantity">
				<h3>Quantity</h3>
			</div>
			<div class="price">
				<h3>Price</h3>
			</div>
			<div class="clear"></div>
		</div>
		<!-- //Mainbar-Ends-Here -->

		<!-- Items-Starts-Here -->
		<div class="items">

			<!-- Item1-Starts-Here -->
			@foreach ($getSaleItemInCart as $c)
			<div class="item1">
				<div class="close1">
					<!-- Remove-Item --><!-- //Remove-Item -->
					<div class="image1">
						<img src="{{  url($c->url) }}" alt="item1">
					</div>
					<div class="title1">
						<p style="font-size:20px">{{ $c->itemName }}</p>
					</div>
					<div class="quantity1">
						<form action="action_page.php">
						<button type="button" class="btn btn-outline-primary" data-id="{{ $c->quantity }}" data-toggle="modal" data-target="#saleItemQuantityCart<?php echo $c->id;?>" id="submit">{{ $c->quantity }}</button>
							<input type="hidden" name="originalQuantity" id="originalQuantity"  min="1" max="10" value="{{ $c->quantity }}">
							<input type="hidden" name="marks" id="marks" min="1" max="10" value="{{ $c->quantity }}">
							
						</form>
				
					</div>
					<div class="price1">
						<p style="font-size:24px" float="top">RM {{ $c->itemPrice }}</p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div id="message<?php echo $c->id;?>" class="modal fade" role="dialog">
				<div class="modal-dialog">

					<!-- Modal content-->
					<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Modal Header</h4>
					</div>
					<div class="modal-body">
						<p>Some text in the modal.</p>
						<?php echo $c->id;?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					</div>

				</div>
				</div>

			<!-- modal -->
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
			<!-- //Item1-Ends-Here -->
		</div>
		<!-- //Items-Ends-Here -->

		<!-- Total-Price-Starts-Here -->
		<div class="total">
			<div class="total1">Total Price</div>
			<div class="total2">RM {{ $getCart->totalPrice }}</div>
			<div class="clear"></div>
		</div>
		<!-- //Total-Price-Ends-Here -->

		<!-- Checkout-Starts-Here -->
		<div class="checkout">
			<div class="discount">
				<span>Apply Discount Code</span> <input type="text">
			</div>
			<div class="add">
				<a href="#">Add to Cart</a>
			</div>
			<div class="checkout-btn">
				<a href="#">Checkout</a>
			</div>
			<div class="clear"></div>
		</div>
		<!-- //Checkout-Ends-Here -->

	</div>
	
	<!-- Modal -->



	<!-- Content-Ends-Here -->

<br>

</body>
<!-- Body-Ends-Here -->

</html>
@endsection