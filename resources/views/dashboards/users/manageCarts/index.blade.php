
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
	<script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
	<script>$(document).ready(function(c) {
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
	</script>
<!-- //Remove-Item-JavaScript -->

</head>

<!-- Body-Starts-Here -->
<body>

	<h1>SHOPPING CART</h1>

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
			<div class="item1">
				<div class="close1">
					<!-- Remove-Item --><div class="alert-close1"> </div><!-- //Remove-Item -->
					<div class="image1">
						<img src="cart_assets/images/item1.png" alt="item1">
					</div>
					<div class="title1">
						<p>Gucci Gg1078/S 4Uavk Grey Wayfarer</p>
					</div>
					<div class="quantity1">
						<form action="action_page.php">
							<input type="number" name="quantity" min="1" max="10" value="1">
						</form>
					</div>
					<div class="price1">
						<p>$ 210</p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- //Item1-Ends-Here -->

			<!-- Item2-Starts-Here -->
			<div class="item2">
				<div class="close2">
					<!-- Remove-Item --><div class="alert-close2"> </div><!-- //Remove-Item -->
					<div class="image2">
						<img src="cart_assets/images/item2.png" alt="item2">
					</div>
					<div class="title2">
						<p>Gucci Men's YA131202 Coupe Dual</p>
					</div>
					<div class="quantity2">
						<form action="action_page.php">
							<input type="number" name="quantity" min="1" max="10" value="1">
						</form>
					</div>
					<div class="price2">
						<p>$ 545</p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- //Item2-Ends-Here -->

			<!-- Item3-Starts-Here -->
			<div class="item3">
				<div class="close3">
					<!-- Remove-Item --><div class="alert-close3"> </div><!-- //Remove-Item -->
					<div class="image3">
						<img src="cart_assets/images/item3.png" alt="item3">
					</div>
					<div class="title3">
						<p>Gucci Cufflinks with Interlocking G Motif</p>
					</div>
					<div class="quantity3">
						<form action="action_page.php">
							<input type="number" name="quantity" min="1" max="10" value="1">
						</form>
					</div>
					<div class="price3">
						<p>$ 169</p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<!-- //Item3-Ends-Here -->

		</div>
		<!-- //Items-Ends-Here -->

		<!-- Total-Price-Starts-Here -->
		<div class="total">
			<div class="total1">Total Price</div>
			<div class="total2">$ 924</div>
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
	<!-- Content-Ends-Here -->

<br>

</body>
<!-- Body-Ends-Here -->

</html>
@endsection