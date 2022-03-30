@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Dashboard')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">{{ $category->name  }}</h3>
</header><!-- sect-heading -->



</div> <!-- container .//  -->
<section class="content">

<div class="card card-solid">
<div class="card-body">
<div class="row">
<div class="col-12 col-sm-6">
<h3 class="d-inline-block d-sm-none">{{ $saleitem->itemName  }}</h3>
<div class="col-12">
<img src="{{ url($firstSaleItemImage->url) }}" class="product-image" alt="Product Image">
</div>
<div class="col-12 product-image-thumbs">
    @foreach ($allSaleItemImages as $image)
        <div class="product-image-thumb"><img src="{{ url($image->url) }}" alt="Product Image"></div>
    @endforeach
<!-- <div class="product-image-thumb active"><img src="../../dist/img/prod-1.jpg" alt="Product Image"></div> -->

</div>
</div>
<div class="col-12 col-sm-6">
<h3 class="my-3">{{ $saleitem->itemName }}</h3>
<p>{{ $saleitem->itemDescription }}</p>
<hr>
<h4>Available Colors</h4>
<div class="btn-group btn-group-toggle" data-toggle="buttons">
<label class="btn btn-default text-center active">
<input type="radio" name="color_option" id="color_option_a1" autocomplete="off" checked>
Green
<br>
<i class="fas fa-circle fa-2x text-green"></i>
</label>
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_a2" autocomplete="off">
Blue
<br>
<i class="fas fa-circle fa-2x text-blue"></i>
</label>
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_a3" autocomplete="off">
Purple
<br>
<i class="fas fa-circle fa-2x text-purple"></i>
</label>
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_a4" autocomplete="off">
Red
<br>
<i class="fas fa-circle fa-2x text-red"></i>
</label>
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_a5" autocomplete="off">
Orange
<br>
<i class="fas fa-circle fa-2x text-orange"></i>
</label>
</div>
<h4 class="mt-3">Size <small>Please select one</small></h4>
<div class="btn-group btn-group-toggle" data-toggle="buttons">
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
<span class="text-xl">S</span>
<br>
Small
</label>
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_b2" autocomplete="off">
<span class="text-xl">M</span>
<br>
Medium
</label>
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_b3" autocomplete="off">
<span class="text-xl">L</span>
<br>
Large
</label>
<label class="btn btn-default text-center">
<input type="radio" name="color_option" id="color_option_b4" autocomplete="off">
<span class="text-xl">XL</span>
<br>
Xtra-Large
</label>
</div>
<div class="bg-gray py-2 px-3 mt-4">
<h2 class="mb-0">
@if ($saleitem->itemPromotionStatus==0)
<span style='color:white'> RM {{ $saleitem->itemPrice  }}<span> 
@else
    <strike style='color:red'>   
        <span style='color:white'> RM {{ $saleitem->itemPrice  }}<span> 
    </strike> 
@endif  
</h2>


<h4 class="mt-0">
@if ($saleitem->itemPromotionStatus==1)
<h2><small>Promotion Price: </small>RM {{ $saleitem->itemPromotionPrice  }} </h2>
@endif  
</h4>

<h4 class="mt-0">
@if ($saleitem->itemPromotionStatus==1)
<h4><small>Promotion Duration: {{ $saleitem->itemPromotionStartDate  }} till {{ $saleitem->itemPromotionEndDate  }}</small></h4>
@endif  
</h4>
</div>
<div class="mt-4">
 <div class="btn btn-primary btn-lg btn-flat">
<i class="fas fa-cart-plus fa-lg mr-2"></i>
Add to Cart
</div>
<div class="btn btn-default btn-lg btn-flat">
<i class="fas fa-heart fa-lg mr-2"></i>
Add to Wishlist
</div>
</div>
<div class="mt-4 product-share">
<a href="#" class="text-gray">
<i class="fab fa-facebook-square fa-2x"></i>
</a>
<a href="#" class="text-gray">
<i class="fab fa-twitter-square fa-2x"></i>
</a>
<a href="#" class="text-gray">
<i class="fas fa-envelope-square fa-2x"></i>
</a>
<a href="#" class="text-gray">
<i class="fas fa-rss-square fa-2x"></i>
</a>
</div>
</div>
</div>
<div class="row mt-4">
<nav class="w-100">
<div class="nav nav-tabs" id="product-tab" role="tablist">
<a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
<a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
<a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
</div>
</nav>
<div class="tab-content p-3" id="nav-tabContent">
<div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab"> Description here</div>
<div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"> Comment here</div>
<div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"> Rating here </div>
</div>
</div>
</div>

</div>

</section>

<script>
  $(document).ready(function() {
    $('.product-image-thumb').on('click', function () {
      var $image_element = $(this).find('img')
      $('.product-image').prop('src', $image_element.attr('src'))
      $('.product-image-thumb.active').removeClass('active')
      $(this).addClass('active')
    })
  })
</script>
</section>
@endsection

<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">

<link rel="stylesheet" href="../../dist/css/adminlte.min.css?v=3.2.0">

