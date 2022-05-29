<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <base href="{{\URL::to('/')}}">
        <link rel="icon" href="assets/images/items/1.jpg" type="image/x-icon"/>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
       <!-- Custom styles for this template -->
        <link href="assets/css/bootstrap.css" rel="stylesheet">
        <link href="assets/css/ui.css" rel="stylesheet">
        <link href="assets/css/responsive.css" rel="stylesheet">
        
        <link href="assets/css/all.min.css" rel="stylesheet">
        <script src="assets/js/jquery.min.js" type="text/javascript"></script>
        <script src="assets/js/bootstrap.bundle.min.js" type="text/javascript"></script>
  
    </head>
    <body>
       
<header class="section-header">

<nav class="navbar navbar-dark navbar-expand p-0 bg-primary">
<div class="container">
    <ul class="navbar-nav d-none d-md-flex mr-auto">
    <li class="nav-item"><a class="nav-link" href="{{route('user.dashboard')}}">Home</a></li>
    <li class="nav-item"><a class="nav-link" href="{{ route('manageShipments.userShipmentIndex') }}">Shipping</a></li>
   
    </ul>
    <ul class="navbar-nav">
    <li  class="nav-item"><a href="#" class="nav-link"> Call: +089-210100 </a></li>
 
  </ul> <!-- list-inline //  -->
  
</div> <!-- container //  -->
</nav> <!-- header-top-light.// -->
<section class="header-main border-bottom">
  <div class="container">
<div class="row align-items-center">
  <div class="col-lg-2 col-6">
    <a href="{{route('user.dashboard')}}" class="brand-wrap">
     Rezeki Bundle
    </a> <!-- brand-wrap.// -->
  </div>
  <div class="col-lg-6 col-12 col-sm-12">
    <form action="{{ route('search') }}" method="get">
      @csrf
        <div class="input-group w-100">
          <input type="text" name="param1" class="form-control" placeholder="Search">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </div>
    </form>
  </div> <!-- col.// -->
 
  <div class="col-lg-4 col-sm-6 col-12">
    <div class="widgets-wrap float-md-right">
      <div class="widget-header mr-3">
      <a href="{{ route('manageCarts.index') }}">  <i class="fa fa-shopping-cart icon-sm"></i>
    
       @if (!$cartQuantity || $cartQuantity->cartItemQuantity==0)
       <span class="badge badge-pill badge-danger notify">0</span>
            @else
            <span class="badge badge-pill badge-danger notify">{{$cartQuantity->cartItemQuantity}}</span>
            @endif     
      </a>
      </div>
      <div class="widget-header icontext">
      <a> <i class="fa fa-user icon-sm"></i>  </a>
        <div class="text">
          <div> 
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                  {{Auth::user()->first_name}}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </div>
         
          <div> 
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
          </div>
        </div>
      </div>
    </div> <!-- widgets-wrap.// -->
  </div> <!-- col.// -->
</div> <!-- row.// -->
  </div> <!-- container.// -->
</section> <!-- header-main .// -->
<nav class="navbar navbar-main navbar-expand-lg navbar-light border-bottom">
  <div class="container">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main_nav" aria-controls="main_nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="main_nav">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link pl-0" data-toggle="dropdown" href="#"><strong> <i class="fa fa-bars"></i>    All category</strong></a>
          <div class="dropdown-menu">
           
            @foreach ($brandList as $bl)
            <a class="dropdown-item" href="{{ route('saleItems.index', $bl->id) }}">{{$bl->name}}</a>            
            @endforeach
            <!-- <div class="dropdown-divider"></div> -->
            <!-- <a class="dropdown-item" href="#">Category 1</a>
            <a class="dropdown-item" href="#">Category 2</a>
            <a class="dropdown-item" href="#">Category 3</a> -->
          </div>
        </li>
    
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.profile') }}">My Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('manageFeedback.index') }}">Feedback</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('manageTransactions.userIndex') }}">Order History</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('manageShipments.userShipmentIndex') }}">View Shipping Status</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('manageWishList.index') }}">Wish List</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('saleItems.showPromotionList') }}" style="color: red">Promotions</a>
        </li>
      </ul>
    </div> <!-- collapse .// -->
  </div> <!-- container .// -->
</nav>
</header> <!-- section-header.// -->

<section class="section-intro padding-y-sm">
<div class="container">
@yield('content')
</div> <!-- container //  -->
</section>
<!-- ========================= SECTION  END// ======================= -->
<!-- ========================= FOOTER ========================= -->
<footer class="section-footer border-top bg">
  <div class="container">
    <section class="footer-top  padding-y">
      <div class="row">
        <aside class="col-md col-6">
          <h6 class="title">Category</h6>
          <ul class="list-unstyled">
            @foreach ($brandListFooter as $bl)
              <li> <a href="{{ route('saleItems.index', $bl->id) }}">{{$bl->name}}</a></li>
                 
            @endforeach
            
          </ul>
        </aside>
        <aside class="col-md col-6">
          <h6 class="title">Company</h6>
          <ul class="list-unstyled">
            <li> <a href="#">About us</a></li>
            <li> <a href="#">Career</a></li>
            <!-- <li> <a href="#">Find a store</a></li> -->
            <li> <a href="#">Rules and terms</a></li>
            <li> <a href="#">Sitemap</a></li>
          </ul>
        </aside>
        <aside class="col-md col-6">
          <h6 class="title">Help</h6>
          <ul class="list-unstyled">
            <!-- <li> <a href="#">Contact us</a></li>
            <li> <a href="#">Money refund</a></li> -->
            <li> <a href="{{ route('manageTransactions.userIndex') }}">Order status</a></li>
            <li> <a href="{{ route('manageShipments.userShipmentIndex') }}">Shipping info</a></li>
            <!-- <li> <a href="#">Open dispute</a></li> -->
          </ul>
        </aside>
        <aside class="col-md col-6">
          <h6 class="title">Account</h6>
          <ul class="list-unstyled">
            <li> <a href="#"> My Profile </a></li>
            <li> <a href="{{ route('manageTransactions.userIndex') }}"> My Orders </a></li>
          </ul>
        </aside>
        <aside class="col-md">
          <h6 class="title">Social</h6>
          <ul class="list-unstyled">
            <li><a href="#"> <i class="fab fa-facebook"></i> Facebook </a></li>
            <li><a href="#"> <i class="fab fa-twitter"></i> Twitter </a></li>
            <li><a href="#"> <i class="fab fa-instagram"></i> Instagram </a></li>
            <li><a href="#"> <i class="fab fa-youtube"></i> Youtube </a></li>
          </ul>
        </aside>
      </div> <!-- row.// -->
    </section>  <!-- footer-top.// -->
    <section class="footer-bottom row">
      <div class="col-md-2">
        <p class="text-muted">    Rezeki Bundle </p>
      </div>
      <div class="col-md-8 text-md-center">
        <span  class="px-2">rb@gmail.com</span>
        <span  class="px-2">+089-210100</span>
      </div>
      <div class="col-md-2 text-md-right text-muted">
        <i class="fab fa-lg fa-cc-visa"></i> 
        <i class="fab fa-lg fa-cc-paypal"></i> 
        <i class="fab fa-lg fa-cc-mastercard"></i>
      </div>
    </section>
  </div><!-- //container -->
</footer>
<!-- ========================= FOOTER END // ========================= -->
        
    </body>
</html>