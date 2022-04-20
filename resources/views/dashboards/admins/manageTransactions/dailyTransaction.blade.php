@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowAllSaleItems')

@section('content')
<link href="register_assets/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Daily Customer Transaction</h2>
            </div>
            <br>
            @if ($isEmpty==1)
                <h5>There is no customer transaction exist on this date</h5><br>
            @endif

            <div class="pull-right">
            <form action="{{ route('searchDateTransaction') }}" method="get">
                @csrf
                    <div class="input-group w-100">
                    <label for="birthday">Select date: &nbsp</label>
                        <input class="js-datepicker" type="text" name="param1" required autocomplete="birthday">
                    <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit">
                        <i class="fa fa-search"></i>
                        </button>
                    </div>
                    </div>
            </form>

            </div>
        </div>
    </div>
   <br>  <br>
    
   @if ($isEmpty==0)
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
        @foreach ($getDailyTransaction as $dt)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $dt->order_number }}</td>
            <td>{{ $dt->first_name}} {{ $dt->last_name }}</td>
            <td>RM {{ $dt->totalPrice }}</td>
            <td>{{ $dt->orderDate }}</td>
            <td>{{ $dt->orderStatus }}</td>

            <td>
            <a href="{{ route('manageTransactions.viewOrderItems', $dt->orderID) }}" class="btn btn-sm btn-info">Order Items</a>
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
