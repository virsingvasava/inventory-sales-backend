@extends('layouts.app_admin')

@section('title')
    {{ 'Dashboard' }}
@endsection

@section('content')
    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <a href="{{ route('salesman.dashboard.index') }}">
                    <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
                </a>
                <h1 class="mr20 back_title_text">Sales</h1>
            </div>
            <div class="top-droupdown-sec">
                <div class="row text-right">
                    <div class="col-md-12">
                        <div class="d-badge-sec">
                            <a href="javascript:void(0)" class="badge">1D</a>
                            <a href="javascript:void(0)" class="badge">1W</a>
                            <a href="javascript:void(0)" class="badge">1M</a>
                            <a href="javascript:void(0)" class="badge active">1Y</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="salse-whitebox">
                        <div class="c-block">
                            <div class="card-title">Total Sale</div>
                            <h3><span>₹</span>{{$total_sale}}</h3>
                            <div class="year-sales"><span class="budge"><img
                                        src="{{ asset('theme/images/white-arrow-up.png') }}" />{{$total_sale_percentage}}%</span> vs Last Year
                            </div>
                        </div>
                        <div class="c-block">
                            <div class="card-title">Average Kiosk Sale</div>
                            <h3><span>₹</span>{{$average_kiosk_sale}}</h3>
                            <div class="year-sales"><span class="budge"><img
                                        src="{{ asset('theme/images/white-arrow-up.png') }}" />{{$average_kiosk_sale_percentage}}%</span> vs Last Year</div>
                        </div>
                        <div class="c-block">
                            <div class="card-title">Total Transaction Counts</div>
                            <h3><span>₹</span>{{$total_transaction_counts}}</h3>
                            <div class="year-sales"><span class="budge"><img
                                        src="{{ asset('theme/images/white-arrow-up.png') }}" />{{$total_transaction_counts_percentage}}%</span> vs Last Year</div>
                        </div>
                        <div class="c-block">
                            <div class="card-title">Pack Sold</div>
                            <h3><span>₹</span>{{$pack_sold}}</h3>
                            <div class="year-sales"><span class="budge"><img
                                        src="{{ asset('theme/images/white-arrow-up.png') }}" />{{$pack_sold_percentage}}%</span> vs Last Year</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="salsechart mt-5" style="display:none">
                <div class="table-header">
                    <h3>Sales Chart</h3>
                </div>
                <div id="salsechart"></div>
            </div>
            <div class="dashboard-chart">
                <div class="row">
                    <div  class="col-sm-12">
                        <h3>Sales Chart</h3>
                        <div id="bar-chart" ></div>
                        <div class="d-block w-100 text-center">
                        <div class="brand-label-sec">
                            <div class="last-year"><span class="ly-bg"></span>Last Year</div>
                            <div class="last-year"><span class="cy-bg"></span>Current Year</div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wbgw-table-sec mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-header">
                            <h3 class="back_title_text">Sales History</h3>
                        </div>
                        <div class="table-border-style">
                           @include('salesman.sales_history')
                        </div>
                    </div>
                </div>
            </div>
            <div class="h30"></div>
        </div>
    </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('theme/js/raphael.min.js') }}"></script>
<script src="{{ asset('theme/js/morris.js') }}"></script>
<script type="text/javascript">
    Morris.Bar({
        element: 'bar-chart',
        data: <?php echo $barChart; ?>,
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Last Year', 'Current Year'],
        resize: true,
        barColors: ['#AB96F1', '#24DEAE'],
    });
</script>
@endsection
