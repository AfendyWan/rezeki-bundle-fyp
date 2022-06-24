@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowAllSaleItems')

@section('content')
<link href="register_assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
<style>


#myImg {
  border-radius: 5px;
  cursor: pointer;
  transition: 0.3s;
}

#myImg:hover {opacity: 0.7;}

/* The Modal (background) */
.modal1 {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  padding-top: 100px; /* Location of the box */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (image) */
.modal-content1 {
  margin: auto;
  display: block;
  width: 120%;
  max-width: 1200px;
}

/* Caption of Modal Image */
#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

/* Add Animation */
.modal-content1, #caption {  
  -webkit-animation-name: zoom;
  -webkit-animation-duration: 0.6s;
  animation-name: zoom;
  animation-duration: 0.6s;
}

@-webkit-keyframes zoom {
  from {-webkit-transform:scale(0)} 
  to {-webkit-transform:scale(1)}
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

/* The Close Button */
.close1 {
  position: absolute;
  top: 60px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close1:hover,
.close1:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
  .modal-content1 {
    width: 100%;
  }
}
</style>
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Verify Customer Transaction</h2>
            </div>
            <br>
            @if ($isEmpty==1)
                <h5>There is no customer transaction exist on this date</h5><br>
            @endif

        
        </div>
    </div>

    {!! $getUnverifyTransaction->appends(\Request::except('page'))->render() !!}
   @if ($isEmpty==0)
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>@sortablelink('Order Number')</th> 
         
            <th>Customer Name</th>
           
            <th>@sortablelink('Subtotal Price')</th> 
            <th>Shipping Fee</th>
            <th>@sortablelink('Total Price')</th> 
            <th>@sortablelink('Order Status')</th> 
            <th>@sortablelink('Payment Status')</th> 
          
            <th>Payment Remarks</th>
            <th>Order Date and Time</th>
            <th>Payment Receipt</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($getUnverifyTransaction as $dt)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $dt->order_number }}</td>
            <td>{{ $dt->first_name}} {{ $dt->last_name }}</td>
            <td>RM {{ $dt->subTotalPrice }}</td>
            <td>RM {{ $dt->shippingPrice }}</td>
            <td>RM {{ $dt->totalPrice }}</td>
            <td>{{ $dt->orderStatus }}</td>
            <td>{{ $dt->paymentStatus }}</td>
            @if ($dt->remark == null)
            <td>None</td>
            @else
            <td>{{ $dt->remark }}</td>
            @endif
            <td>{{ $dt->orderDate }}</td>
            <td>
                @if (str_ends_with($dt->url, 'pdf'))
                <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalPdf<?php echo $i;?>">Open Payment Receipt</button>
               
                @else
                
                <img id="myImg<?php echo $i;?>" src="{{  url($dt->url) }}" alt="Payment Receipt Image" style="width:100%;max-width:300px">
                @endif
            
            </td>

      <!-- Modal for pdf-->
      <div id="myModalPdf<?php echo $i;?>" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Payment Receipt</h4>
                    </div>
                    <div class="modal-body">

                        <embed src="{{  url($dt->url) }}"
                               frameborder="0" width="100%" height="1000px">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Modal -->
 
      <!-- The modal for image -->
      <div id="myModal<?php echo $i;?>" class="modal1">
      <span class="close1" id="close1<?php echo $i;?>" onclick="document.getElementById('myModal<?php echo $i;?>').style.display='none'">&times;</span>

           
            <img class="modal-content1" id="img01<?php echo $i;?>">
            <div id="caption<?php echo $i;?>"></div>
            </div>
            
            <script>

            // Get the modal
            var modal = document.getElementById("myModal<?php echo $i;?>");

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById("myImg<?php echo $i;?>");
            var modalImg = document.getElementById("img01<?php echo $i;?>");
            var captionText = document.getElementById("caption<?php echo $i;?>");
            img.onclick = function(){
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
            }


            </script>
               
    </div>
            <td>
            <a href="{{ route('manageTransactions.viewOrderItems', $dt->orderID) }}" class="btn btn-sm btn-info">View order Items</a>
            <a href="{{ route('manageTransactions.viewOrderItems', $dt->orderID) }}" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#verifyPaymentForm<?php echo $i;?>">Verify Payment</a>

            <!-- Modal for verify payment -->
             <div class="modal fade" id="verifyPaymentForm<?php echo $i;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Payment Verification</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="{{route('managePayments.updatePaymentVerificationStatus')}}" method="POST"  enctype="multipart/form-data">
							@csrf
						<div class="modal-body">
							<div class="form-group">
							<label class="col-form-label">Verify Payment: <small></small></label>
                            <select class="form-control" name="paymentVerificationStatus" id="paymentVerificationStatus">
                                <option value="Verified" selected>Verified</option>
                                <option value="Failed">Failed</option>                
                            </select>
              <label class="col-form-label">Remarks <small></small></label>
              <input type="text" class="form-control" name="paymentRemarks" placeholder="Remarks" value="None">  
			

				<input type="hidden" name="paymentID" id="paymentID" value="{{ $dt->payment_id }}">
           
             
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
                    <!-- End of modal for verify payment -->
            </td>
        </tr>  
        @endforeach
    </table>
    @endif
    <script src="register_assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="register_assets/vendor/select2/select2.min.js"></script>
    <script src="register_assets/vendor/datepicker/moment.min.js"></script>
    <script src="register_assets/vendor/datepicker/daterangepicker.js"></script>
    <script src="register_assets/js/global.js"></script>

@endsection
