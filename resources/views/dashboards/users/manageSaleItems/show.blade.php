@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'showItem')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">{{ $category->name  }}</h3>
</header><!-- sect-heading -->

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

  <hr>
  <h4>Brand:</h4>
  <p style="font-size: 20">{{ $saleitem->itemBrand }}</p>
  <hr>
  <h4>Description: </h4>
  <p style="font-size: 20">{{ $saleitem->itemDescription }}</p>
  <hr>
  <h4>Color:</h4>
  <p style="font-size: 20"> {{ $saleitem->itemColor }}</p>
  <hr>
  <h4>Sizes: </h4>
  <p style="font-size: 20">{{ $saleitem->itemSize }}</p>
  <hr>
  <h4>Stock: </h4>
  <p style="font-size: 20">{{ $saleitem->itemStock }}</p>
  <hr>
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
<div class="row">
&nbsp &nbsp
<form action="{{ route('manageCarts.store') }}" method="POST">
    @csrf
    <button type="button" class="btn btn-primary btn-lg btn-flat" data-toggle="modal" data-target="#saleItemQuantityCart">
    <i class="fas fa-cart-plus fa-lg mr-2"></i> Add to Cart
    </button>
</form>
&nbsp&nbsp&nbsp
<form action="{{ route('manageCarts.store') }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-default btn-lg btn-flat"><i class="fas fa-heart fa-lg mr-2"></i> Add to Wishlist </button>
</form></div>


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

<!-- Modal -->
<div class="modal fade" id="saleItemQuantityCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter item quantity</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('manageCarts.store') }}" method="POST">
        @csrf
      <div class="modal-body">
          <div class="form-group">
           <label class="col-form-label">Quantity: <small>(Max quantity: {{ $saleitem->itemStock }})</small></label>
            <input type="number" class="form-control" name="quantity">
            <input type="hidden" name="userID" value="{{ auth()->user()->id }}">
            <input type="hidden" name="saleItemID" value="{{ $saleitem->id }}">
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

