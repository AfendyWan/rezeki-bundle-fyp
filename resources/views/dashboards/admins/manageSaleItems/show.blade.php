@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowSaleItem')

@section('content')
<div class="row mb-2">


</div>
</div>
</section>

<section class="content">
@if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

<div class="card-body">
<div class="row">
<div class="col-12 col-sm-6">
<h3 class="d-inline-block d-sm-none">LOWA Men’s Renegade GTX Mid Hiking Boots Review</h3>
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

<div class="card-body table-responsive p-0">
<table class="table table-hover text-nowrap">

    <tbody>
        <tr>
            <th>Item Category</th>
            <td>{{ $category->name  }}</td>
        </tr>

        <tr>
            <th>Item Brand</th>
            <td>{{ $saleitem->itemBrand  }}</td>
        </tr>

        <tr>
            <th>Item Size</th>
            <td>{{ $saleitem->itemSize  }}</td>
        </tr>

        <tr>
            <th>Item Color</th>
            <td>{{ $saleitem->itemColor  }}</td>
        </tr>
        <tr>
            <th>Item Stock</th>
            <td>{{ $saleitem->itemStock }}</td>
        </tr>

        <tr>
            <th>Item Promotion Status</th>
            @if ($saleitem->itemPromotionStatus==1)
            <td>On</td>
            @else
            <td>Off</td>
            @endif            
        </tr>

        <tr>
            <th>Item Promotion Price</th>
            <td>RM {{ $saleitem->itemPromotionPrice }}</td>
        </tr>

        <tr>
            <th>Item Activation Status</th>
            @if ($saleitem->itemActivationStatus==1)
            <td>On</td>
            @else
            <td>Off</td>
            @endif 
        </tr>
    </tbody>
</table>
</div>
<br>
<div class="col-12 col-sm-12">
    <a href="{{ route('manageSaleItems.editPromotion', $saleitem->id) }}" class="btn btn-sm btn-primary">Edit promotion</a>
    @if ($saleitem->itemActivationStatus==1)
        <a href="{{ route('manageSaleItems.toggleActivationStatus', $saleitem->id) }}" class="btn btn-sm btn-danger">Deactivate Sale Item</a>
    @else
        <a href="{{ route('manageSaleItems.toggleActivationStatus', $saleitem->id) }}" class="btn btn-sm btn-success">Activate Sale Item</a>                        
    @endif 
</div>
<div class="bg-gray py-2 px-3 mt-4">
    <h2 class="mb-0">
        Sale Price: RM {{ $saleitem->itemPrice }}
    </h2>
    <h4 class="mt-0">
        <small>Bale Price: RM 80.00 </small>
    </h4>
</div>

</div>
</div>

<script src="../../plugins/jquery/jquery.min.js"></script>


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
@endsection