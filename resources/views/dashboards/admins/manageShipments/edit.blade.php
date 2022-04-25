@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'UpdateShipment')

@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Shipment</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('manageShipments.adminShipmentIndex') }}"> Back</a>
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
  
    <form action="{{ route('manageShipments.adminSaveShipment') }}" method="POST">
    @csrf
 
    <input type="hidden"  name="id" value="{{$shipment->id}}">
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Shipping Courier Delivery:</strong>
                <input list="list-couriers" name="couriers" class="form-control" value="{{$shipment->shippingCourier}}" placeholder="Delivery Courier"/>
                <datalist id="list-couriers">
                    <option value="Pos Laju">
                    <option value="GDex">
                    <option value="ABX Express">
                    <option value="J&T Express">
                    <option value="Skynet Express">
                    <option value="Citylink">
                    <option value="DHL Express">
                    <option value="FedEx">
                    <option value="Easy Parcel">                  
                </datalist>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Shipping Tracking Number:</strong>
                <input type="text" name="shippingTrackingNumber" class="form-control" value="{{$shipment->shippingTrackingNumber}}" placeholder="Tracking Number"/>
                
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Shipping Status:</strong>
                <input list="list-status" name="status" class="form-control" value="{{$shipment->shippingStatus}}" placeholder="Shipping Status"/>
                <datalist id="list-status">
                    <option value="Preparing to Ship">
                    <option value="Shipped">
                    <option value="Delivered">
                               
                </datalist>
            </div>
        </div>
       
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
   
</form>
@endsection