@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'CreateSaleItems')
@section('content')

<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>{{ $saleitem->itemName  }}</h2>
            </div>
          
        </div>
    </div>
    <br>
    @if ($errors->any())
    <br>
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('manageSaleItems.updatePromotion',$saleitem->id) }}" method="POST">
        @csrf
        @method('POST')
       
            <input type="hidden"  name="id" value="{{ $saleitem->id }}">
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="form-group">
                    <label>Sale Item Price (RM):</label>
                    <input type="text" name="price" class="form-control" placeholder="Price" value="{{ $saleitem->itemPrice }}" disabled>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="form-group">
                    <label>Promotion Price (RM):</label>
                    <input type="text" name="promotionPrice" class="form-control" placeholder="Price" value = "{{ $saleitem->itemPromotionPrice }}">
                </div>
            </div>
    
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <label>Promotion Status</label>
                        <div class="p-t-10">
                            <label class="radio-container m-r-45">On
                                <input type="radio" checked="checked" name="promotionStatus" value = "1">
                                <span class="checkmark"></span>
                            </label> 
                            &nbsp                            
                            <label class="radio-container">Off
                                <input type="radio" name="promotionStatus" value = "0">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 ">
                <div class="form-group">
                <label>Promotion Duration:</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input readonly type="text" class="form-control float-right" name="promotionDuration" id="reservation">
                        </div>
                </div>
            </div>
            <br>
            <div class="col-12 col-sm-12 text-center">
            <button type="submit" class="btn btn-primary">Save</button>&nbsp&nbsp
            <a class="btn btn-danger" href="{{ route('manageSaleItems.show',$saleitem->id) }}">Back</a>
            </div>
      
    </form>
@endsection