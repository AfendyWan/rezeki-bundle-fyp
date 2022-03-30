@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Dashboard')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">{{ $saleItemCategory->name }}</h3>
</header><!-- sect-heading -->

  
<div class="row">
  @foreach ($allSaleItem as $c)
    @if ($c->itemActivationStatus != 0)
    <div class="col-md-3">
    <div href="{{ route('saleItems.show', $c->id) }}" class="card card-product-grid">
      <a href="{{ route('saleItems.show', $c->id) }}" class="img-wrap"> <img src="{{  url($c->url) }}"> </a>
      <figcaption class="info-wrap">
        <a href="{{ route('saleItems.show', $c->id) }}" class="title">{{ $c->itemName }}</a>
                 
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
        <!-- <span class="label-rating text-muted">{{ $c->itemStock }} items in this catalogue</span> -->
        <div class="">Price: RM{{ $c->itemPrice }} </div> <!-- price-wrap.// -->
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

