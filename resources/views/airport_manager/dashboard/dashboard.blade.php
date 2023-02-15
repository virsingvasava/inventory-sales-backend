@extends('layouts.app_admin')
@section('title','Dashboard')
@section('content')

<div class="main-content-part">
    <div class="main-content-padd">
        <div class="dashboard-title">
            <h1><span> {{$greeting_message }} , </span> {{$user_detail->name}} !</h1>
            <div class="search-box">
                <img class="search-user" src="{{asset('theme/images/search-icon.png')}}">
                <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
            </div>
        </div>
        <div class="dashboard-top-sec">
            <div class="row text-right">
                <div class="col-md-12">
                    <div class="d-badge-sec">
                        <div id="boxreportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row boxreportrange"></div>
        <div class="dashboard-chart">
            <div class="row">
                <div class="col-sm-12 sales_by_brand_city_display"></div>
            </div>
        </div>
        <div class="brand-box-sec">
            <div class="row">
                <div class="col-md-12 text-right mb-3">
                    <div class="d-badge-sec">
                        <div id="sold_brand_display" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span class="sold_brand_time"></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                    <input type="hidden" class="sold_brand_start_date">
                    <input type="hidden" class="sold_brand_end_date">
                </div>
                <div class="sold_brand_display"></div> 
            </div>
        </div>
        <div class="dashboard-table-sec">
            <div class="row">
                <div class="col-md-12 text-right mb-3">
                    <div class="d-badge-sec">
                        <div id="purchase_behaviour_display" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span class="purchase_behaviour_date"></span> <i class="fa fa-caret-down"></i>
                        </div> 
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="card">
                    <div class="card-header">
                        <h3>Sales by Quarter</h3>
                        <div class="card-header-right">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false"> <img src="{{asset('theme/images/dot-img.png')}}" alt=""></button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuClickableInside">
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-block sbquarter">
                        <div class="card-title">Total Sale</div>
                        <h3><span class="icon-rupee">₹</span>{{$quarterArr['totalYearPrice']}}<span class="year-text">({{date('Y')}})</span></h3>
                        <ul>
                            <li class="qa">Q1</li>
                            <li class="qb">Q2</li>
                            <li class="qc">Q3</li>
                            <li class="qd">Q4</li>
                        </ul>
                        <div class="quarter-box">
                            <dl class="qt-bg">
                                <span class="qa"></span>
                            </dl>
                            <dl class="qt-text">Q1</dl>
                            <dl class="qt-money">₹ {{$quarterArr['first']}}</dl>
                            <dl class="qt-updown">
                                <span class="budge">
                                    @if($quarterArr['first'] == 0)
                                    -
                                    @else
                                    <img src="{{asset('theme/images/green-arrow-up-big.png')}}"/>
                                    {{rand(0,10)}}%
                                    @endif
                                </span> 
                            </dl>
                        </div>
                        <div class="quarter-box">
                            <dl class="qt-bg">
                                <span class="qb"></span>
                            </dl>
                            <dl class="qt-text">Q2</dl>
                            <dl class="qt-money">₹ {{$quarterArr['second']}}</dl>
                            <dl class="qt-updown">
                                <span class="budge">
                                    @if($quarterArr['second'] == 0)
                                    -
                                    @else
                                    <img src="{{asset('theme/images/green-arrow-up-big.png')}}"/>
                                    {{rand(0,10)}}%
                                    @endif
                                </span> 
                            </dl>
                        </div>
                        <div class="quarter-box">
                            <dl class="qt-bg">
                                <span class="qc"></span>
                            </dl>
                            <dl class="qt-text">Q3</dl>
                            <dl class="qt-money">₹ {{$quarterArr['third']}}</dl>
                            <dl class="qt-updown">
                                <span class="budge">
                                    @if($quarterArr['third'] == 0)
                                    -
                                    @else
                                    <img src="{{asset('theme/images/green-arrow-up-big.png')}}"/>
                                    {{rand(0,10)}}%
                                    @endif
                                </span> 
                            </dl>
                        </div>
                        <div class="quarter-box">
                            <dl class="qt-bg">
                                <span class="qd"></span>
                            </dl>
                            <dl class="qt-text">Q4</dl>
                            <dl class="qt-money">₹ {{$quarterArr['fourth']}}</dl>
                            <dl class="qt-updown">
                                <span class="budge">
                                    @if($quarterArr['fourth'] == 0)
                                    -
                                    @else
                                    <img src="{{asset('theme/images/green-arrow-up-big.png')}}"/>
                                    {{rand(0,10)}}%
                                    @endif
                                </span> 
                            </dl>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                    <div class="card-header">
                        <h3>Purchase Behaviour</h3>
                        <div class="card-header-right">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false"> <img src="{{asset('theme/images/dot-img.png')}}" alt=""></button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuClickableInside">
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style">
                        <div class="table-responsive purchase_behaviour_display"></div>
                    </div>
                    </div>
                    <div class="d-badge-sec">
                        <div id="sales_by_outlet_location_display" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span class="sales_by_outlet_location_time"></span> <i class="fa fa-caret-down"></i>
                        </div> 
                    </div>
                    <input type="hidden" name="start_date" class="start_date">
                    <input type="hidden" name="end_date" class="end_date">
                    <div class="card">

                    <div class="card-header">
                        <h3>Sales by Outlet Location</h3>
                        <div class="card-header-right">
                            <div class="btn-group">
                                <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown"
                                data-bs-auto-close="outside" aria-expanded="false"> <img src="{{asset('theme/images/dot-img.png')}}" alt=""></button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuClickableInside">
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                <li><a class="dropdown-item" href="">Menu item</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-block table-border-style sales_by_outlet_location_display"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker.css')}}" />
<script type="text/javascript">
$(function() {

    var start = moment().subtract(29, 'days');
    var end = moment();

    function boxreportrange(start, end) {

        $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var start_date = start.format('MMMM D, YYYY H:m:s');
        var end_date = end.format('MMMM D, YYYY H:m:s');

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.boxreportrange').html('<div style="display:flex;justify-content: center;"><img src="'+img+'" height="100" width="100"></div>');

        var token = '{{csrf_token()}}';
        var url = "{{route('airport_manager.dashboard.ajax')}}";
        $.ajax({
            url: url,
            type: 'POST',
            data: { _token:token, start_date:start_date, end_date:end_date },
            success : function(response)
            {
                $('.boxreportrange').html(response);
            }
        });

        $('#boxreportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#boxreportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, boxreportrange);
    boxreportrange(start, end);

    function purchase_behaviour_range(start, end) {

        $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var start_date = start.format('MMMM D, YYYY H:m:s');
        var end_date = end.format('MMMM D, YYYY H:m:s');

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.purchase_behaviour_display').html('<div style="display:flex;justify-content: center;"><img src="'+img+'" height="100" width="100"></div>');

        var token = '{{csrf_token()}}';
        var url = "{{route('airport_manager.dashboard.ajax_purchase_behaviour')}}";
        $.ajax({
            url: url,
            type: 'POST',
            data: { _token:token, start_date:start_date, end_date:end_date },
            success : function(response)
            {
                $('.purchase_behaviour_display').html(response);
            }
        });

        $('.purchase_behaviour_date').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#purchase_behaviour_display').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, purchase_behaviour_range);
    purchase_behaviour_range(start, end);

    function sold_brand_range(start, end) {

        $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var start_date = start.format('MMMM D, YYYY H:m:s');
        var end_date = end.format('MMMM D, YYYY H:m:s');

        $('.sold_brand_start_date').val(start_date);
        $('.sold_brand_end_date').val(end_date);

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.sold_brand_display').html('<div style="display:flex;justify-content: center;"><img src="'+img+'" height="100" width="100"></div>');

        var token = '{{csrf_token()}}';
        var url = "{{route('airport_manager.dashboard.ajax_sold_brand')}}";
        $.ajax({
            url: url,
            type: 'POST',
            data: { _token:token, start_date:start_date, end_date:end_date },
            success : function(response)
            {
                $('.sold_brand_display').html(response);
            }
        });

        $('.sold_brand_time').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#sold_brand_display').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, sold_brand_range);
    sold_brand_range(start, end);

    function sales_by_outlet_location_range(start, end) {

        $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var start_date = start.format('MMMM D, YYYY H:m:s');
        var end_date = end.format('MMMM D, YYYY H:m:s');

        $('.start_date').val(start_date);
        $('.end_date').val(end_date);

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.sales_by_outlet_location_display').html('<div style="display:flex;justify-content: center;"><img src="'+img+'" height="100" width="100"></div>');

        var token = '{{csrf_token()}}';
        var url = "{{route('airport_manager.dashboard.ajax_sales_by_location')}}";
        $.ajax({
            url: url,
            type: 'POST',
            data: { _token:token, start_date:start_date, end_date:end_date },
            success : function(response)
            {
                $('.sales_by_outlet_location_display').html(response);
            }
        });

        $('.sales_by_outlet_location_time').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }

    $('#sales_by_outlet_location_display').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, sales_by_outlet_location_range);
    sales_by_outlet_location_range(start, end);
});


$(document).ready(function(){
    sales_by_brand('0');
})

function sales_by_brand(city_id)
{
    var token = '{{csrf_token()}}';
    var url = "{{route('airport_manager.dashboard.ajax_sales_by_brand_city')}}";

    var img = "{{asset('assets/img/loader.gif')}}";
    $('.sales_by_brand_city_display').html('<div style="display:flex;justify-content: center;"><img src="'+img+'" height="100" width="100"></div>');
    
    $.ajax({
        url: url,
        type: 'POST',
        data: { _token:token, city_id:city_id},
        success : function(response)
        {
            $('.sales_by_brand_city_display').html(response);
        }
    });
}

</script>

@endsection