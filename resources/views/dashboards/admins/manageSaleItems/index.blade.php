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
    {!! $saleItem->appends(\Request::except('page'))->render() !!}
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Price</th>
            <th>Category</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($saleItem as $saleItem)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $saleItem->itemName }}</td>
            <td>{{ $saleItem->itemDescription }}</td>

            @foreach($saleItemCategory as $category)
                @if($saleItem->itemCategory == $category->id)
                    <td>{{ $category->name }}</td>
                @endif
            @endforeach

            <td>
                <form action="{{ route('manageSaleItems.destroy',$saleItem->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('manageSaleItems.show',$saleItem->id) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('manageSaleItems.edit',$saleItem->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>


@endsection
<!-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <h4>Hi Admin: {{Auth::user()->name}}</h4>
                <hr>
                DASHBOARD
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection -->