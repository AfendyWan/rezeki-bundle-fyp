@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'PromotionList')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">Search result</h3>
</header><!-- sect-heading -->

@if ($messageNoResult==1)
<h4 class="section-title">No results found</h4>
@endif
<div class="row">
  @foreach ($saleItemImage as $c)
   
    <div class="col-md-3">
    <div href="{{ route('saleItems.show', $c->sale_item_id) }}" class="card card-product-grid">
      <a href="{{ route('saleItems.show', $c->sale_item_id) }}" class="img-wrap"> <img src="{{  url($c->url) }}"> </a>
      <figcaption class="info-wrap">
       
        <h5 class="section-title" style="color: blue"> <a href="{{ route('saleItems.show', $c->sale_item_id) }}" class="title">{{ $c->itemName  }}</a></h5>
        <!-- <div class="rating-wrap">
          <ul class="rating-stars">
            <li style="width:80%" class="stars-active"> 
              <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>
            </li>
            <li>
              <i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i> 
            </li>
          </ul>
          <span class="label-rating text-muted"> 34 reviws</span>
        </div> -->
        <!-- <span class="label-rating text-muted">{{ $c->itemName }} items in this catalogue</span> -->
        @if ($c->itemPromotionStatus == 1)
    
        <h6 class="section-title" style="color: red">Promotion: RM {{ $c->itemPromotionPrice }}</h6>
      
        @else
        <h6 class="section-title">Normal: RM {{ $c->itemPrice }} </h6>
        @endif
     
      </figcaption>
    </div>
  </div> 
 
  @endforeach
<!-- col.// -->

</div> <!-- row.// -->

</div> <!-- container .//  -->
</section>
@endsection

