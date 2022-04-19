@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowAllSaleItems')

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

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Order ID</th>
            <th>Item Name</th>
            <th>Item Unit Price</th>
            <th>Order Quantity</th>
            <th>Total Price</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($getOrderItems as $ot)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $ot->order_id}}</td>
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
            <a href="{{ route('manageSaleItems.show',$ot->sale_item_id) }}" class="btn btn-sm btn-info">Show Sale Item</a>
            </td>
        </tr>  
        @endforeach
    </table>


@endsection
