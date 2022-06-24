@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowAllSaleItems')

@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>View Order Items</h2>
            </div>           
        </div>
    </div>
   <br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
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
            
            <td>RM
                <script> 
				var a = <?php echo $ot->orderPrice / $ot->quantity?> ; 
					var b = (Math.round(a * 100) / 100).toFixed(2);
					document.write(b); 
				</script> 
            </td>
            <td>{{ $ot->quantity }}</td>
            <td>RM 
                <script> 
					if ( <?php echo $ot->itemPromotionStatus?>==1){
						var a = <?php echo $ot->orderPrice * $ot->quantity?> ; 
					}else{
						var a = <?php echo $ot->orderPrice * $ot->quantity?> ; 
					}
					var b = (Math.round(a * 100) / 100).toFixed(2);
					document.write(b); 
				</script> 
            </td>
            <td>
            <a href="{{ route('manageSaleItems.show',$ot->sale_item_id) }}" class="btn btn-sm btn-info">Show Sale Item</a>
            </td>
        </tr>  
        @endforeach
    </table>


@endsection
