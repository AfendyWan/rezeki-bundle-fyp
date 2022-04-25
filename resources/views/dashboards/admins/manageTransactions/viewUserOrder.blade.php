@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowUserOrder')

@section('content')
<link href="register_assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Order Number {{ $getUserTransaction->order_number }}</h2>
            </div>
            <br>
          

        </div>
    </div>

    
  
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Order Number</th>
            <th>Customer Name</th>
            <th>Total Price</th>
            <th>Order Date and Time</th>
            <th>Order Status</th>
            <th width="280px">Action</th>
        </tr>
       
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $getUserTransaction->order_number }}</td>
            <td>{{ $getUserTransaction->first_name}} {{ $getUserTransaction->last_name }}</td>
            <td>RM {{ $getUserTransaction->totalPrice }}</td>
            <td>{{ $getUserTransaction->orderDate }}</td>
            <td>{{ $getUserTransaction->orderStatus }}</td>

            <td>
            <a href="{{ route('manageTransactions.viewOrderItems', $getUserTransaction->orderID) }}" class="btn btn-sm btn-info">Order Items</a>
            </td>
        </tr>  
     
    </table>
   
    <script src="register_assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="register_assets/vendor/select2/select2.min.js"></script>
    <script src="register_assets/vendor/datepicker/moment.min.js"></script>
    <script src="register_assets/vendor/datepicker/daterangepicker.js"></script>
    <script src="register_assets/js/global.js"></script>

@endsection
