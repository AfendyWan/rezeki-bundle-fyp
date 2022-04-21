@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'userTransactionItem')

@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>View Order Item</h2>
            </div>           
        </div>
    </div>
   <br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="alert alert-danger">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            
            <th>Item Name</th>
            <th>Item Unit Price</th>
            <th>Order Quantity</th>
            <th>Total Price</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($getOrderItems as $ot)
        <tr>
            <td>{{ ++$i }}</td>
            
            <td>{{ $ot->itemName }}</td>
            
            @if ($ot->itemPromotionStatus==1)
            <td><strike>RM {{ $ot->itemPrice }}</strike> <br>
            RM {{ $ot->itemPromotionPrice }}</td>
            @else
            <td>RM {{ $ot->itemPrice }}</td>
            @endif 
            <td>{{ $ot->quantity }}</td>
            <td>RM 
                <script> 
					if ( <?php echo $ot->itemPromotionPrice?>==1){
						var a = <?php echo $ot->itemPromotionPrice * $ot->quantity?> ; 
					}else{
						var a = <?php echo $ot->itemPrice * $ot->quantity?> ; 
					}
					var b = (Math.round(a * 100) / 100).toFixed(2);
					document.write(b); 
				</script> 
            </td>
            <td>
            <a href="{{ route('saleItems.show',$ot->sale_item_id) }}" class="btn btn-sm btn-info">Show Sale Item</a>
            <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#submitFeedback<?php echo $ot->id;?>">Submit Feedback</button>
            <div class="modal fade" id="submitFeedback<?php echo $ot->id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Feedback for {{$ot->itemName}}</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form action="{{ route('manageFeedback.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
						<div class="modal-body">
							<div class="form-group">
							<label class="col-form-label"><b>Feedback Title:</b> <small></small></label>
                            <input type="text" class="form-control" name="feedbackTitle" placeholder="Title">  
                            <label class="col-form-label"><b>Feedback Description:</b> <small></small></label>
                            <textarea class="form-control" style="height:150px" name="feedbackDescription" placeholder="Description"></textarea>
                            <label class="col-form-label"><b>Images</b> <small></small></label>
                            <input type="file" name="images[]" multiple class="form-control" accept="image/*">
            
                            <input type="hidden" name="sale_item_id" value="{{$ot->sale_item_id}}">
                            <input type="hidden" name="order_id" value="{{$ot->order_id}}">
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Submit</button>
						</div>
						</form>
						</div>
					</div>
					</div>
            </td>
        </tr>  
        @endforeach
    </table>

<br><br><br>
@endsection
