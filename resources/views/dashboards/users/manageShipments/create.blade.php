@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'showItemList')

@section('content')
<section class="section-content">
<div class="container">

<header class="section-heading">
  <h3 class="section-title">Shipping <Address></Address></h3>
</header><!-- sect-heading -->

@if ($message = Session::get('success'))
    <div class="alert alert-success">
        {{ $message }}
    </div>
@endif
<hr>
<form action="{{ route('manageShipments.updateShippingDefault') }}" method="POST">
@csrf
  <h5>Please select your default shipping address:</h5>
  @foreach ($getUserShippingAddress as $s)
    @if ($s->shipping_default_status==1)
      <input type="radio" name="shipping_default" value="{{$s->id}}" checked>
      <label for="">{{$s->shipping_address}}, {{$s->city}}, 
      @foreach ($state as $st)
        @if ($s->state==$st->id)
          {{$st->states_name}}, 
        @endif
      @endforeach
      Postcode {{$s->postcode}}
      
      </label><br>
    @else
      <input type="radio" name="shipping_default" value="{{$s->id}}">
      <label for="">{{$s->shipping_address}}, {{$s->city}}, 
      @foreach ($state as $st)
        @if ($s->state==$st->id)
          {{$st->states_name}}, 
        @endif
      @endforeach
      Postcode {{$s->postcode}}
    </label><br>
    @endif
  @endforeach
  <br>
  <button type="submit" class="btn btn-primary">Save</button>
</form>
<br>
<hr>
<h5>Add new shipping address:</h5>

<form action="{{ route('manageShipments.addNewShippingAddress') }}" method="post">
@csrf
  <div class="row1 row-space1">
    <div class="col-111">
      <div class="input-group1">
        <label class="label1">Postcode</label>
          <input id="postcode" type="text" class="input--style-4 form-control @error('postcode') is-invalid @enderror" name="postcode" placeholder="90000" value="{{ old('postcode') }}" required autocomplete="postcode">
            @error('postcode')
              <span class="text-danger" role="alert">
                <strong>{{ $message }}</strong>
               </span>
             @enderror  
      </div>
    </div>
  </div>
  <br>
  <div class="row1 row-space1">
    <div class="col-111">
      <div class="input-group1">
        <label class="label1">Shipping Address</label>
        <input id="shipping_address" type="text" class="input--style-4 form-control @error('shipping_address') is-invalid @enderror" name="shipping_address" required autocomplete="shipping_address">
          @error('password')
          <span class="text-danger" style="color:red" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
    </div>
  </div> 
  <br>
  <div class="row1 row-space1">
    <div class="col-222">
      <div class="input-group1">
        <label for="state" class="form-label">State</label>
          <select class="form-control" name="state" id="state">
            <option hidden>Choose States</option>
            @foreach ($state as $item)
            <option value="{{ $item->id }}">{{ $item->states_name }}</option>
            @endforeach
          </select>
          @error('state')
          <span class="text-danger" style="color:red" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
      </div>
    </div>
    <br>
    <div class="col-222">
      <div class="input-group1">
        <label for="city" class="form-label">City</label>
        <select class="form-control" name="city" id="city"></select>
          @error('city')
          <span class="text-danger" style="color:red" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
    </div>
  <br>                    
  <button type="submit" class="btn btn-primary">Add</button>
</form>
</div> <!-- container .//  -->
<script>
            $(document).ready(function() {
            $('#state').on('change', function() {
               var stateID = $(this).val();
               if(stateID) {
                   $.ajax({
                       url: '/getCities/'+stateID,
                       type: "GET",
                       data : {"_token":"{{ csrf_token() }}"},
                       dataType: "json",
                       success:function(data)
                       {
                         if(data){
                            $('#city').empty();
                            $('#city').append('<option hidden>Choose City</option>'); 
                            $.each(data, function(key, city){
                                $('select[name="city"]').append('<option value="'+ city.cities_name +'">' + city.cities_name+ '</option>');
                            });
                        }else{
                            $('#city').empty();
                        }
                     }
                   });
               }else{
                 $('#course').empty();
               }
            });
            });
        </script>
</section>
@endsection

