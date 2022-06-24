@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'ShowAllCategories')

@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Manage categories</h2>
            </div>
            <br>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('manageCategories.create') }}"> Create New Category</a>
            </div>
        </div>
    </div>
   <br>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    {!! $saleItemCategory->appends(\Request::except('page'))->render() !!}
    <table class="table table-bordered">
        <tr>
            <th>@sortablelink('No')</th>
            <th>@sortablelink('Name')</th>
            <th>@sortablelink('Description')</th>
            <th>@sortablelink('Total Quantity')</th>
            <th width="280px">@sortablelink('Action')</th>
        </tr>
        @foreach ($saleItemCategory as $saleItemCategory)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $saleItemCategory->name }}</td>
            <td>{{ $saleItemCategory->description }}</td>
            <td>{{ $saleItemCategory->quantity }}</td>
            <td>
                <form action="{{ route('manageCategories.destroy',$saleItemCategory->id) }}" method="POST">
   
                    <!-- <a class="btn btn-info" href="{{ route('manageCategories.show',$saleItemCategory->id) }}">Show</a> -->
    
                    <a class="btn btn-primary" href="{{ route('manageCategories.edit',$saleItemCategory->id) }}">Edit</a>
   
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
