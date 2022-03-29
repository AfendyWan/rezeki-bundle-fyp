@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'Dashboard')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">Catalogue</h3>
</header><!-- sect-heading -->

  
<div class="row">
  @foreach ($saleItemCatalogue as $c)
  <div class="col-md-3">
    <div href="#" class="card card-product-grid">
      <a href="#" class="img-wrap"> <img src="{{  url($c->url) }}"> </a>
      <figcaption class="info-wrap">
        <a href="#" class="title">{{ $c->name }}</a>
        
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
        <!-- <span class="label-rating text-muted">{{ $c->quantity }} items in this catalogue</span> -->
        <div class="text-muted mt-1">{{ $c->quantity }} items in this catalogue</div> <!-- price-wrap.// -->
      </figcaption>
    </div>
  </div> 
  @endforeach
<!-- col.// -->

</div> <!-- row.// -->

</div> <!-- container .//  -->
</section>
@endsection

