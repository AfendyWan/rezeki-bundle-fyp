@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'checkout')

@section('content')
<section class="section-content">
<div class="container">


<div class="content-wrapper">

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Checkout</h1>
      </div>

    </div>
  </div>
</section>



<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">


        <div class="invoice p-3 mb-3">
          <div class="row">
            <div class="col-12">
              <h4>
                <i class="fas fa-globe"></i> Rezeki Bundle
                <small class="float-right">Date: {{$todayDate}}</small>
              </h4>
            </div>
          </div>
        
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            From
            <address>
            <strong>Rezeki Bundle</strong><br>
            {{$adminDetails->shipping_address}}<br>
            Phone: {{$adminDetails->phone_number}}<br>
            Email: [{{$adminDetails->email}}]
            </address>
          </div>
          <div class="col-sm-2 invoice-col">
         
        
          </div>
          <div class="col-sm-4 invoice-col">
            To
            <address>
            <strong>{{$userDetails->first_name}} {{$userDetails->last_name}}</strong><br>
            {{$userShippingAddress->shipping_address}}<br>
  
            Phone: {{$userDetails->phone_number}}<br>
            Email: [{{$userDetails->email}}]
            </address>
          </div>

        </div>


        <div class="row">
          <div class="col-12 table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>Qty</th>
                  <th>Sale Item</th>
                  <th>Unit Price</th>
                  <th>Description</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($getSaleItemInCart as $c)
                <tr>
                  <td>{{$c->quantity}}</td>
                  <td>{{$c->itemName}}</td>
                    @if ($c->itemPromotionStatus==1)
                      <td><strike>RM {{ $c->itemPrice }}</strike> <br>
                    RM {{ $c->itemPromotionPrice }}</td>
                    @else
                      <td>RM {{ $c->itemPrice }}</td>
                    @endif 
                  <td>{{$c->itemDescription}}</td>
                  <td>RM 
                    <script> 
                      if ( <?php echo $c->itemPromotionPrice?>==1){
                        var a = <?php echo $c->itemPromotionPrice * $c->quantity?> ; 
                      }else{
                        var a = <?php echo $c->itemPrice * $c->quantity?> ; 
                      }							
							        var b = (Math.round(a * 100) / 100).toFixed(2);
							        document.write(b); 
							      </script>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
<br>
    <div class="row">
      <div class="col-6">
        <p class="lead">Supported Payment Methods:</p>
        <img src="../../dist/img/credit/visa.png" alt="Visa">
        <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
        <!-- <img src="../../dist/img/credit/american-express.png" alt="American Express">
        <img src="../../dist/img/credit/paypal2.png" alt="Paypal"> -->
        <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem
        plugg
        dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
        </p>
      </div>

      <div class="col-6">
        <p class="lead">Amount Due</p>
          <div class="table-responsive">
          <table class="table">
          <tr>
            <th style="width:50%">Subtotal:</th>
              <td>RM {{$getCart->totalPrice}}</td>
          </tr>
         
          <tr>
            <th>Flat Rate Shipping:</th>
              <td>RM 10.00</td>
          </tr>
          <tr>
            <th>Total:</th>
              <td>RM {{$getCart->totalPrice}}</td>
          </tr>
          </table>
          </div>
        </div>
      </div>


      <div class="row no-print">
        <div class="col-12">
         
          <a href="{{route('managePayments.updatePaymentResult')}}">
            <button type="button" class="btn btn-primary float-right">
            Proceed to Payment
            </button>
          </a>
          <a href="{{route('manageShipments.create')}}"><button type="button" class="btn btn-success float-right" style="margin-right: 5px;">
             Edit Shipping Address
          </button></a>
        </div>
      </div>
  </div>


</section>

</div>

</div> <!-- container .//  -->
</section>
@endsection

