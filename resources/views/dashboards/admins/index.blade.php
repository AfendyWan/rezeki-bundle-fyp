@extends('dashboards.admins.layouts.admin-dash-layout')
@section('title', 'Dashboard')

@section('content')
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.center {
    display: block;
  margin-left: auto;
  margin-right: auto;
}
</style>

<!-- Script for navigation -->

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function(){
    $("#myTab a").click(function(e){
        e.preventDefault();
        $(this).tab("show");
    });
});
</script>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawChart1);
      function drawChart() {    

        // For wish list pie chart
        var wishListItems = <?php echo json_encode($wishListData) ?>; 
        var wishListDrawData = google.visualization.arrayToDataTable(wishListItems);

        var wishListOptions = {
          title: 'Number of Sale Item in Wish List'
        };

        var wishListChart = new google.visualization.PieChart(document.getElementById('wishListPieChart'));

        wishListChart.draw(wishListDrawData, wishListOptions);

      }
      function drawChart1() {        

        //For sale item sold pie chart
        var soldSaleItems = <?php echo json_encode($soldSaleItemData) ?>; 
        var soldSaleItemDrawData = google.visualization.arrayToDataTable(soldSaleItems);

        var soldSaleItemOptions = {
          title: 'Number of Sale Item Sold in This Month'
        };

        var soldSaleItemChart = new google.visualization.PieChart(document.getElementById('soldSaleItemPieChart'));

        soldSaleItemChart.draw(soldSaleItemDrawData, soldSaleItemOptions);

        var soldSaleItemChart = new google.visualization.PieChart(document.getElementById('soldSaleItemPieChart'));

        soldSaleItemChart.draw(soldSaleItemDrawData, soldSaleItemOptions);
        }

        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {

        var reportItems = <?php echo json_encode($reportData) ?>; 
        var data = new google.visualization.arrayToDataTable(reportItems);

        var options = {
          width: 800,
          chart: {
            title: 'Monthly Sales Report',
            // subtitle: 'distance on the left, brightness on the right'
          },
          bars: 'horizontal', // Required for Material Bar Charts.
          series: {
            0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
            1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
          },
          axes: {
            x: {
              distance: {label: 'Total Price'}, // Bottom x-axis.
              brightness: {side: 'top', label: 'apparent magnitude'} // Top x-axis.
            }
          }
        };

      var chart = new google.charts.Bar(document.getElementById('dual_x_div'));
      chart.draw(data, options);
    };
    </script>
</head>
<body>



<div class="m-4">
    <ul class="nav nav-pills" id="myTab">
        <li class="nav-item">
            <a href="#wishListTab" class="nav-link active">Wish List</a>
        </li>
        <li class="nav-item">
            <a href="#saleItemSoldTab" class="nav-link">Item Sold in this Month</a>
        </li>
        <li class="nav-item">
            <a href="#salesReportTab" class="nav-link">Monthly Sales Report</a>
        </li>
        <!-- <li class="nav-item">
            <a href="#messages" class="nav-link">Messages</a>
        </li> -->
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="wishListTab">
            <!-- <h4 class="mt-2">Wish List Pie Chart Analysis</h4>             -->
            <br><div id="wishListPieChart" class="center" style="width: 900px; height: 500px;"></div> 
        </div>
        <div class="tab-pane fade active" id="saleItemSoldTab">
            <br>
            <div id="soldSaleItemPieChart" class="center" style="width: 900px; height: 500px;"></div>
        </div>
        <div class="tab-pane fade active" id="salesReportTab">
        <br><div id="dual_x_div" class="center" style="width: 900px; height: 500px;"></div>
        </div>

        <!-- <div class="tab-pane fade active" id="messages">
            <h4 class="mt-2">Messages tab content</h4>
            <div id="dual_x_div" class="center style="width: 900px; height: 500px;"></div>
        </div> -->
    </div>
</div>
</body>
</html>

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
