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
            {{$userShippingAddress->shipping_address}},  {{$userShippingAddress->city}}, {{$userShippingAddressState->states_name}},  {{$userShippingAddress->postcode}}<br>
  
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
      <form method="POST" action="{{ route('managePayments.updatePaymentResult') }}" class="col-6">
      @csrf
      <p class="lead">Amount Due</p>
                <div class="table-responsive">
                <table class="table">
                <tr>
                  <th style="width:50%">Subtotal:</th>
                    <td>RM {{$getCart->totalPrice}}</td>
                </tr>
              
                <tr>
                  <th>Flat Rate Shipping:</th>
                  <td>
                    @if ($userShippingAddressState->states_name == "Johor")
                      @if ($userShippingAddress->city == "Bandar Maharani")
                      <select class="form-control" name="deliveryOption" id="deliveryOption">
                        <option value="{{$localDelivery->value}}" selected>Local Delivery RM{{$localDelivery->value}}</option>
                        <option value="{{$SabahShippingFee->value}}">Courier Delivery RM{{$SabahShippingFee->value}}</option>                
                      </select>
                      @else
                      <select class="form-control" name="deliveryOption" id="deliveryOption">
                        <option value="{{$SabahShippingFee->value}}">RM {{$SabahShippingFee->value}}</option>                        
                      </select>
                      
                      @endif
                    @elseif ($userShippingAddressState->states_name == "Sarawak")
                    <select class="form-control" name="deliveryOption" id="deliveryOption">
                        <option value="{{$SarawakShippingFee->value}}">RM {{$SarawakShippingFee->value}}</option>                        
                    </select>                   
                    @else
                    <select class="form-control" name="deliveryOption" id="deliveryOption">
                        <option value="{{$PeninsularShippingFee->value}}">RM {{$PeninsularShippingFee->value}}</option>                        
                    </select>  
                 
                    @endif
                   
                    
                  </td>         
                    <!-- <td>RM 10.00</td> -->
                </tr>
                <tr id="chooseDate">
                <th>Delivery date and time:</th>
                  <td id="">
                    <input type="datetime-local" id="deliveryDateTime" name="deliveryDateTime">                   
                  </td> 
                </tr>
                <tr>
                  <th>Total:</th>
                    <td id="detailInfo"> 
                    <script type="text/javascript">

                      $(document).ready(function () {
                          var shippingFee = $('#deliveryOption').val();
                          var totalPrice = parseInt(shippingFee) + <?php echo $getCart->totalPrice; ?>;
                          var decimalTotalPrice = (Math.round(totalPrice * 100) / 100).toFixed(2);
                          var selectedName = $('#deliveryOption :selected').text();
                          $('input[name="totalPrice"]').val(decimalTotalPrice);
                          $('input[name="subTotalPrice"]').val(<?php echo $getCart->totalPrice; ?>);
                          $('input[name="shippingPrice"]').val(shippingFee);
                          console.log(selectedName.includes('Local')); 
                          if (selectedName.includes("Local")){
                            $("#chooseDate").show();
                          }else{
                            $("#chooseDate").hide();
                          }
                          $('input[name="deliveryOptionName"]').val(selectedName);
                       
							            $('#detailInfo').html('RM ' + decimalTotalPrice);
                          $('#deliveryOption').on("change", function () {
                              var shippingFee = $('#deliveryOption').val();

                              var totalPrice = parseInt(shippingFee) + <?php echo $getCart->totalPrice; ?>;
                              var decimalTotalPrice = (Math.round(totalPrice * 100) / 100).toFixed(2);
                              var selectedName = $('#deliveryOption :selected').text();

                            
                              if (selectedName.includes("Local")){
                                $("#chooseDate").show();
                              }else{
                                $("#chooseDate").hide();
                              }
                              $('input[name="deliveryOptionName"]').val(selectedName);
                              $('#detailInfo').html('RM ' + decimalTotalPrice);
                          });
                      });

                      </script>
                    
                      </td>
                </tr>
                </table>
                </div>
              </div>
         <div class="row no-print">
        <div class="col-12">
         
          <!-- <a href="{{route('managePayments.updatePaymentResult')}}"> -->
        
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#openPaymentForm">
            Proceed to Payment
            </button>
         
          <a href="{{route('manageShipments.create')}}"><button type="button" class="btn btn-success float-right" style="margin-right: 5px;">
             Edit Shipping Address
          </button></a>
        </div>
      </div>
      </form>
     
    @if ($errors->any())
    <br>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with the payment receipt uploaded.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
      <div class="modal fade" id="openPaymentForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Payment Form</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="{{route('managePayments.updatePaymentResult')}}" method="POST"  enctype="multipart/form-data">
							@csrf
						<div class="modal-body">
            
							<div class="form-group">
							<label class="col-form-label">Upload Payment Receipt: <small></small></label>
              <input type="file" name="paymentReceipt"  class="form-control" accept="image/*,.pdf">
              
              <label class="col-form-label">Select Shipping Courier: <small></small></label>
				      <input list="list-couriers" name="couriers" class="form-control" value="" placeholder="Delivery Courier"/>
                <datalist id="list-couriers">
                    <option value="Pos Laju">
                    <option value="GDex">
                    <option value="ABX Express">
                    <option value="J&T Express">
                    <option value="Skynet Express">
                    <option value="Citylink">
                    <option value="DHL Express">
                    <option value="FedEx">
                    <option value="Easy Parcel">                  
                </datalist>

								<input type="hidden" name="totalPrice" id="totalPrice" value="">
                <input type="hidden" name="subTotalPrice" id="subTotalPrice">
                <input type="hidden" name="shippingPrice" id="shippingPrice">
								<input type="hidden" name="userID" value="{{ auth()->user()->id }}">
                <input type="hidden" id="deliveryOptionName" name="deliveryOptionName" value="">
							</div>
              <p>Please transfer money payment to this account:<br>
              Bank name: <b>{{$getPaymentBankName->value}}</b><br>
              Account number: <b>{{$getPaymentAccountNumber->value}}</b><br>
              Account holder name: <b>{{$getPaymentAccountHolderName->value}}</b><br>
              </p>
              
							</div>
              
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Add</button>
						</div>
						</form>
						</div>
					</div>
					</div>

      
  </div>


</section>

</div>

</div> <!-- container .//  -->
</section>
@endsection

