
<div class="row">
    <div class="col-md-12">
        <div class="salse-whitebox">
            <div class="c-block">
                <div class="card-title">Total Sale</div>
                <h3><span>₹</span>{{$totalSale}}</h3>
                <!-- <div class="year-sales">
                    <span class="budge">
                        <img src="{{asset('assets/images/white-arrow-up.png')}}"/>23.7%
                    </span> vs Last Year
                </div>   -->           
            </div>
            <div class="c-block">
                <div class="card-title">Average Kiosk Sale</div>
                <h3><span>₹</span>{{$averageKioskSale}}</h3>
                <!-- <div class="year-sales">
                    <span class="budge">
                        <img src="{{asset('assets/images/white-arrow-up.png')}}"/>13%
                    </span> vs Last Year
                </div>   -->           
            </div>
            <div class="c-block">
                <div class="card-title">Total Transaction Counts</div>
                <h3>{{$totalTrns}}</h3>
                <!-- <div class="year-sales">
                    <span class="budge">
                        <img src="{{asset('assets/images/white-arrow-up.png')}}"/>20%
                    </span> vs Last Year
                </div>   -->           
            </div>
            <div class="c-block">
                <div class="card-title">Pack Sold</div>
                <h3>{{$soldPacks}}</h3>
                <!-- <div class="year-sales">
                    <span class="budge">
                        <img src="{{asset('assets/images/white-arrow-up.png')}}"/>37%
                    </span> vs Last Year
                </div>  -->            
            </div>
        </div>
    </div>
</div>
<div class="salsechart mt-5">
    <div class="table-header"><h3>Sales Chart</h3></div>
    <div id="salsechart"></div>
</div>
<div class="wbgw-table-sec mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="table-header">
                <h3>Sales History</h3>
            </div>
            <div class="table-border-style">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Orders</th>
                                <th>Gross Sales</th>
                                <th>Discount</th>
                                <th>Tax</th>
                                <th class="text-right">Total Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($historyArr) && count($historyArr) > 0)
                                @foreach($historyArr as $key => $value)
                                <tr>
                                    <td>{{$value['period']}}</td>
                                    <td>{{$value['total_orders']}}</td>
                                    <td>{{$value['gross_sales']}}</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td class="text-right">{{$value['total_sales']}}</td>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="h30"></div>
        
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/apexcharts.min.js')}}"></script>
<script>
var options = {
  chart: {  height: 280, type: "area" },
  dataLabels: { enabled: false },
  series: [ { name: "Series 1", data: <?php echo $qtyData; ?> } ],
  fill: { type: "gradient", gradient: { shadeIntensity: 1, opacityFrom: 0.7, opacityTo: 0.9, stops: [0, 90, 100] }, colors: ['#4ADD48', '#D9F3D9', '#ffffff'], },
  xaxis: { categories: <?php echo $categories; ?> }
};
var chart = new ApexCharts(document.querySelector("#salsechart"), options);
chart.render();
</script>