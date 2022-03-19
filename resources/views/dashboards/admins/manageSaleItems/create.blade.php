@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'CreateSaleItems')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Add New Sale Item</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('manageSaleItems.index') }}"> Back</a>
        </div>
    </div>
</div>
<br>
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
   
<form action="{{ route('manageSaleItems.store') }}" method="POST">
    @csrf
  
     <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <strong>Name:</strong>
                <input type="text" name="name" class="form-control" placeholder="Name">
            </div>
        </div>
        <div class="col-md-6">
        <div class="form-group">
        <strong>Category:</strong>
        <select class="form-control select2" style="width: 100%;" name="category">
        @foreach($categoryName as $categoryName)
        <option>{{ $categoryName->name }}</option>
     
        @endforeach
        <!-- <option disabled="disabled">California (disabled)</option> -->
        </select>
        </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Price(RM):</strong>
                <input type="text" name="price" class="form-control" placeholder="Price">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <strong>Stock:</strong>
                <input type="text" name="stock" class="form-control" placeholder="Stock">
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <textarea class="form-control" style="height:150px" name="description" placeholder="Description"></textarea>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection