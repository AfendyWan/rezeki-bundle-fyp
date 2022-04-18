@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'checkout')

@section('content')
<section class="section-content">
<style>
      body {
        text-align: center;
        background: #EBF0F5;
      }
        .h1name {
          color: #88B04B;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-weight: 900;
          font-size: 40px;
          
        }
        .pname {
          color: #404F5E;
          font-family: "Nunito Sans", "Helvetica Neue", sans-serif;
          font-size:20px;
          margin: 0;
        }
      .iname {
        color: #9ABC66;
        font-size: 100px;
        line-height: 200px;
        margin-left:-15px;
      }

      .center {
        text-align: center;
        
      }
</style>

<div class="container">
  
<div class="content-wrapper">
  <div class="card">
      <div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
        <i class="checkmark iname">✓</i>
      </div>
        <h1 class="h1name">Payment Success</h1> 
        <p class="pname">We have received your purchase request;<br/>Thank you for shopping with us</p>
      <br>
      <div class="center">
        <a href="{{route('user.dashboard')}}"><button type="submit" class="btn btn-lg btn-flat" style="color:black; background-color: white; border: 1px solid black;">CONTINUE SHOPPING</button></a>
        &nbsp &nbsp &nbsp
        <a href=""><button type="submit" class="btn btn-lg btn-flat" style="color:red; background-color: #FFDBE9; border: 1px solid red">VIEW ORDER</button></a>
        
      </div>
        <br>
        <br>
  </div>
</div>


<section class="content">
  <div class="container-fluid">

  </div>
</section>


</div> <!-- container .//  -->
</section>
@endsection

