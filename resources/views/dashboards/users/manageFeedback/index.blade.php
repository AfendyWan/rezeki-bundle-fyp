@extends('dashboards.users.layouts.user-dash-layout')
@section('title', 'checkout')

@section('content')
<style>
* {
  box-sizing: border-box;
}

.column {
  float: left;
  width: 33.33%;
  padding: 5px;
}

/* Clearfix (clear floats) */
.row::after {
  content: "";
  clear: both;
  display: table;
}
</style>
<section class="section-content">
<div class="container">


<div class="content-wrapper">

<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>What our customers say</h1>
      </div>

    </div>
  </div>
</section>



<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                @foreach($getAllUserFeedback as $f)
                <div class="card">
                    <div class="card-header">
                        {{ $f->first_name}} {{ $f->last_name}} wrote:
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $f->feedbackTitle}}</h5>
                        <p class="card-text">{{ $f->feedbackDescription}}</p>
                        <div class="row">
                          @foreach ($allFeedbackImages as $image)
                            @if($image->feedback_id ==$f->feedbackID)
                            <img src="{{ url($image->url) }}" alt="Product Image"style="width:15%">
                            &nbsp  &nbsp  &nbsp  &nbsp  &nbsp
                            @endif
                          @endforeach
                        </div>
                        <!-- <a href="#" class="btn btn-primary">Go somewhere</a> -->
                    </div>
                </div>
                <br>
                @endforeach
            </div>
        </div>
     </div>
</section>

</div>

</div> <!-- container .//  -->
</section>
@endsection

