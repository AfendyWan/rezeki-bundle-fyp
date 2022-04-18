@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowAllSaleItems')

@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Manage sale items</h2>
            </div>
            <br>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('manageSaleItems.create') }}"> Create New Sale Item</a>
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
            <th>Customer Name</th>
            <th>Total Price</th>
            <th>Order Date and Time</th>
            <th>Order Status</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($getDailyTransaction as $dt)
        <tr>
            <td>{{ ++$i }}</td>
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


@endsection
