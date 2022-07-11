@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'BusinessProfile')

@section('content')
<div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Business Profile</h2>
            </div>
            <!-- <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('manageCategories.index') }}"> Back</a>
            </div> -->
        </div>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif
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
    <br> 
    <form action="{{  route('admin.updateProfile') }}" method="POST">
        @csrf
        @method('POST')
   
         <div class="row">
            <input type="hidden"  name="id" value="">

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Business Address:</strong>
                    <input type="text" name="business_address" value="{{ $getAdmin->shipping_address }}" class="form-control" placeholder="Business Address">
                @error('business_address')
                    <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                     </span>
               @enderror 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Postcode:</strong>
                    <input type="text" name="postcode" value="{{ $getAdmin->postcode  }}" class="form-control" placeholder="Postcode">
                    @error('postcode')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror   
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Contact Number:</strong>
                    <input type="text" name="contact_number" value="{{ $getAdmin->phone_number }}" class="form-control" placeholder="Contact Number">
                    @error('contact_number')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>        
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Local Courier Delivery Shipping Fee (RM):</strong>
                    <input type="text" name="local_delivery_fee" value="{{ $localDelivery->value }}" class="form-control" placeholder="Local Delivery Fee">
                    @error('local_delivery_fee')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Sabah Courier Delivery Shipping Fee (RM):</strong>
                    <input type="text" name="sabah_courier_delivery_fee" value="{{ $SabahShippingFee->value }}" class="form-control" placeholder="Sabah Courier Delivery Shipping Fee">
                    @error('sabah_courier_delivery_fee')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Sarawak Courier Delivery Shipping Fee (RM):</strong>
                    <input type="text" name="sarawak_courier_delivery_fee" value="{{ $SarawakShippingFee->value }}" class="form-control" placeholder="Sarawak Courier Delivery Shipping Fee">
                    @error('sarawak_courier_delivery_fee')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Peninsular Courier Delivery Shipping Fee (RM):</strong>
                    <input type="text" name="peninsular_courier_delivery_fee" value="{{ $PeninsularShippingFee->value }}" class="form-control" placeholder="Peninsular Courier Delivery Shipping Fee">
                    @error('peninsular_courier_delivery_fee')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Payment Bank Account Number:</strong>
                    <input type="text" name="bank_acc_num" value="{{ $paymentAccountNumber->value }}" class="form-control" placeholder="Payment Bank Account Number">
                    @error('bank_acc_num')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Payment Bank Name:</strong>
                    <input type="text" name="bank_name" value="{{ $paymentBankName->value }}" class="form-control" placeholder="Payment Bank Name">
                    @error('bank_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Payment Bank Account Holder Name:</strong>
                    <input type="text" name="bank_acc_holder_name" value="{{ $paymentAccHolderName->value }}" class="form-control" placeholder="Payment Bank Account Holder Name">
                    @error('bank_acc_holder_name')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror 
                </div>
            </div>

            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
   
    </form>
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
