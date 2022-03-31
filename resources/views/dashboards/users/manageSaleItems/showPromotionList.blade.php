@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'PromotionList')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">Promotion List of Items</h3>
</header><!-- sect-heading -->

  
<div class="row">
  @foreach ($saleItemImage as $c)
    @if ($c->itemPromotionStatus == 1)
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
        <h5 class="section-title" style="color: red">Promotion: RM {{ $c->itemPromotionPrice }}</h5>
        <h6 class="section-title">Normal: RM <s>{{ $c->itemPrice }}</s></h6>
       
        <div class="text-muted mt-1">{{ $c->itemPromotionStartDate }} - {{ $c->itemPromotionEndDate }}</div> 
     
      </figcaption>
    </div>
  </div> 
  @endif
  @endforeach
<!-- col.// -->

</div> <!-- row.// -->

</div> <!-- container .//  -->
</section>
@endsection

