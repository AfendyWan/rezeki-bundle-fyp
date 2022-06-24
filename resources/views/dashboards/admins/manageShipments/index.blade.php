@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowAllUserShipment')

@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Manage shipment</h2>
            </div>
            <br>
            <!-- <div class="pull-right">
                <a class="btn btn-success" href="{{ route('manageSaleItems.create') }}"> Create New Sale Item</a>
            </div> -->
        </div>
    </div>
   <br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {!! $getAllShipmentOrders->appends(\Request::except('page'))->render() !!}
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Customer Name</th>
            <th width="280px">Shipping Full Address</th>           
            <th>Shipping Fee</th>
            <th>Shipping Option</th>
            <th>Delivery Date Time</th>
            <th>@sortablelink('Shipping Courier Delivery')</th>    
     
            <th>Shipping Tracking Number</th>
            <th>@sortablelink('Shipping Status')</th>            
            <th width="200px">Action</th>
        </tr>
        @foreach ($getAllShipmentOrders as $a)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $a->first_name }} {{ $a->last_name }}</td>
            <td>
            {{ $a->shippingAddress }}
              
          </td>
            <td>RM 1</td>
            <td>{{ $a->shippingOption }}</td>
            <td>
                @if($a->shippingLocalDateTime=="")
                    Not Available
                @else
                    {{$a->shippingLocalDateTime}}
                @endif
            </td>
            <td>
                @if($a->shippingCourier=="")
                    Not yet update
                @else
                    {{$a->shippingCourier}}
                @endif
            </td>
      
            <td>
                @if($a->shippingTrackingNumber=="")
                    Not yet update
                @else
                    {{$a->shippingTrackingNumber}}
                @endif
            </td>
            <td>{{ $a->shippingStatus }}</td>
            <td>
            <form action="" method="POST">               
                <a class="btn btn-primary" href="{{route('manageShipments.adminUpdateShipment',$a->id)}}">Update Shipping</a>
                <a class="btn btn-info" href="{{route('manageTransactions.viewUserOrder',$a->orderID)}}">View Order</a>
                @csrf
               
                </form>
            </td>
           
        </tr>
        @endforeach
    </table>


@endsection
