@extends('layouts.app_admin')
@section('title','Dashboard')
@section('content')
<style>
    .or_scroll {
        height: 500px;
        overflow-y: scroll;
    }
</style>
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
                <div class="col-md-12 text-right mb-3">
                    <!-- <div class="d-badge-sec">
                        <a href="#" class="badge">1D</a>
                        <a href="#" class="badge">1W</a>
                        <a href="#" class="badge">1M</a>
                        <a href="#" class="badge active">1Y</a> 
                    </div> -->
                    <div class="city-droupdown">
                        <select class="form-control sales_by_brand_city">
                            <option value="">All Cities</option>
                            @foreach($cityList as $value)
                            <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-12 sales_by_brand_city_display"></div>
            </div>
        </div>
        <div class="dashboard-table-sec">
            <div class="row">
                <div class="col-md-6">
                    <div class="col-md-12 text-right mb-3">
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>Total Sales by Region</h3>
                            <div class="card-header-right">
                                {{-- <a href="#" class="link-view">View Report</a> --}}
                                <a class="link-view total_sales_by_region_export" href="javascript:;" data-id="1" data-toggle="tooltip" title="Are you sure to Export Total Sales by Region Data ?">
                                    Export
                                </a>
                            </div>
                        </div>
                        <div class="card-block table-border-style total_sales_by_region_display">

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <!-- <div class="col-md-12 text-right mb-3">
                        <div class="d-badge-sec">
                            <a href="#" class="badge">1D</a>
                            <a href="#" class="badge">1W</a>
                            <a href="#" class="badge">1M</a>
                            <a href="#" class="badge active">1Y</a> 
                        </div>
                            <div class="city-droupdown">
                                <select class="form-control">
                                    <option>All Cities</option>
                                    <option>Baroda</option>
                                    <option>Mumbai</option>
                                    <option>Bhopal</option>
                                </select>
                          </div>
                    </div> -->
                    <div class="card dashboard-kiosk-table">
                        <div class="card-header">
                            <h3>Top 10 Kiosks</h3>
                            <div class="card-header-right"> 
                                <a class="link-view top_ten_model_click" href="javascript:;" data-id="1" data-toggle="tooltip" title="Are you sure to Export Top 10 Kiosks?">
                                    Export
                                </a>
                            </div>
                        </div>
                        <div class="card-block table-border-style">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Kiosk</th>
                                            <th>Terminal</th>
                                            <th class="text-right">City</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($topTenKioskArr) && count($topTenKioskArr) > 0)
                                        @foreach($topTenKioskArr as $key => $value)
                                        <tr @if($key==0) class="yellow-bg" @endif @if($key==1) class="gray-bg" @endif @if($key==2) class="orange-bg" @endif>
                                            <td>
                                                {{$value['name']}}
                                                @if($key == 0)
                                                <span class="top-badge">1<sup>st</sup></span>
                                                @endif
                                                @if($key == 1)
                                                <span class="top-badge">2<sup>nd</sup></span>
                                                @endif
                                                @if($key == 2)
                                                <span class="top-badge">3<sup>rd</sup></span>
                                                @endif
                                            </td>
                                            <td>{{$value['terminal']}}</td>
                                            <td class="text-right">{{$value['city']}}</td>
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
                    <div class="city-droupdown">
                        <select class="form-control brand_box_city">
                            <option value="">All Cities</option>
                            @foreach($cityList as $value)
                            <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                            @endforeach
                        </select>
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
                    <!-- <div class="city-droupdown">
                        <select class="form-control">
                            <option>All Cities</option>
                            <option>Baroda</option>
                            <option>Mumbai</option>
                            <option>Bhopal</option>
                        </select>
                    </div> -->
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Sales by Quarter</h3>
                            <div class="card-header-right">
                                <div class="btn-group">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"> <img src="{{asset('theme/images/dot-img.png')}}" alt=""></button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuClickableInside">
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>   
                        <div class="card-block sbquarter">
                            
                            <select name="" id="" class="form-control airportChange">
                                <option value="">Select Airport</option>
                                <option value="International">International</option>
                                <option value="Domestic">Domestic</option>
                            </select>
                           
                            <ul>
                                <li class="qa">Q1</li>
                                <li class="qb">Q2</li>
                                <li class="qc">Q3</li>
                                <li class="qd">Q4</li>
                            </ul>
                            <div class="card-title">Total Sale</div>
                            <div class="main_class_sale">
                            <h3><span class="icon-rupee">₹</span>{{$quarterArr['totalYearPrice']}}<span class="year-text">({{date('Y')}})</span></h3>
                            </div>
                            <div class="airport">
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qa"></span>
                                    </dl>
                                    <dl class="qt-text">Q1</dl>
                                    <dl class="qt-money">₹ {{$quarterArr['first']}}</dl>
                                </div>
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qb"></span>
                                    </dl>
                                    <dl class="qt-text">Q2</dl>
                                    <dl class="qt-money">₹ {{$quarterArr['second']}}</dl>
                                </div>
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qc"></span>
                                    </dl>
                                    <dl class="qt-text">Q3</dl>
                                    <dl class="qt-money">₹ {{$quarterArr['third']}}</dl>
                                </div>
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qd"></span>
                                    </dl>
                                    <dl class="qt-text">Q4</dl>
                                    <dl class="qt-money">₹ {{$quarterArr['fourth']}}</dl>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <!--  -->
                    <div class="col-md-12 text-right mb-3">
                        <div class="d-badge-sec">
                            <div id="payment_mode_display" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span class="payment_mode_time"></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <div class="city-droupdown">
                            <select class="form-control payment_mode_display_city">
                                <option value="">All Cities</option>
                                @foreach($cityList as $value)
                                <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" class="payment_mode_start_date">
                        <input type="hidden" class="payment_mode_end_date">
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3>Sales by Payment Mode</h3>
                            <div class="card-header-right">
                                <div class="btn-group">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"> <img src="{{asset('theme/images/dot-img.png')}}" alt=""></button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuClickableInside">
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="payment_mode_displays"></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3>Purchase Behaviour</h3>
                            <a class="link-view purchase_behaviour_export" href="javascript:;" style="color: #AB96F1;font-size: 12px;line-height: 15px;font-weight: 500;">
                                Export
                            </a>
                            <div class="card-header-right">
                                <div class="btn-group">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"> <img src="{{asset('theme/images/dot-img.png')}}" alt=""></button>
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
                    <div class="city-droupdown">
                        <select class="form-control sales_by_outlet_location_city">
                            <option value="">All Cities</option>
                            @foreach($cityList as $value)
                            <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h3>Sales by Outlet Location</h3>
                            <a class="link-view sales_by_location_export" href="javascript:;" style="color: #AB96F1;font-size: 12px;line-height: 15px;font-weight: 500;">
                                Export
                            </a>
                            <div class="card-header-right">
                                <div class="btn-group">
                                    <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"> <img src="{{asset('theme/images/dot-img.png')}}" alt=""></button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuClickableInside">
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                        <li><a class="dropdown-item" href="">Menu item</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-block table-border-style sales_by_outlet_location_display or_scroll"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sales_by_time_interval -->
        <div class="dashboard-table-sec">
            <div class="row">
                <div class="col-md-12 text-right mb-3">
                    <div class="city-droupdown">
                        <select class="form-control sales_by_time_interval sales_by_time_interval_city">
                            <option value="">All Cities</option>
                            @foreach($cityList as $value)
                            <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="city-droupdown sales_by_time_interval_kiosk_dropdown_response">
                        <select class="form-control sales_by_time_interval sales_by_time_interval_kiosk">
                            <option value="">All Kiosk</option>
                        </select>
                    </div>
                    <div class="city-droupdown">
                        <input type="date" name="date" class="form-control sales_by_time_interval sales_by_time_interval_date">
                    </div>
                </div>
                <div class="col-md-12 mb-3 sales_by_time_interval_response">
                    <div class="card">
                        <div class="card-header">
                            <h3>Sales by Time Interval</h3>
                        </div>
                        <div class="card-block sbquarter">
                            <div class="col-sm-12">
                                <div id="bar-chart-new"></div>
                                <div class="d-block w-100 text-center">
                                    <div class="brand-label-sec">
                                        <div class="last-year"><span class="ly-bg"></span>Transition</div>
                                        <div class="last-year"><span class="cy-bg"></span>Quantity</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End -sales_by_time_interval-->
        <!--  -->
        <!-- <div class="d-badge-sec">
            <div id="product_comparison_date" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span class="sales_by_outlet_location_time"></span> <i class="fa fa-caret-down"></i>
            </div>
        </div>
        <input type="hidden" name="start_date" class="start_date">
        <input type="hidden" name="end_date" class="end_date">
        <div class="city-droupdown">
            <select class="form-control product_comparison_city">
                <option value="">All Cities</option>
                @foreach($cityList as $value)
                <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                @endforeach
            </select>
        </div> -->

        <div class="card">
            <div class="card-header">
                <!-- <h3>Product Comparision</h3> -->
            </div>
            <div class="card-block table-border-style">

                <div class="snip1240">
                    <div class="plan plantext">
                        <header>
                            Product
                        </header>
                        <ul class="plan-features">
                            <li>Total Sale</li>
                            <li>Pack Sold</li>
                            <li>Brand</li>
                            <li>SKU</li>
                            <li>Price</li>
                            <li>Pack Size</li>
                        </ul>
                    </div>
                    <div class="plan ">
                        <header>
                            <div class="pcbrand-droupdown">
                                <select class="form-control product_comparison_1">
                                    <option>All Product</option>
                                    @foreach($ProductList as $value)
                                    <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </header>
                        <ul class="plan-features product_comparison1">
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                        </ul>
                    </div>
                    <div class="plan">
                        <header>
                            <div class="pcbrand-droupdown">
                                <select class="form-control product_comparison_2">
                                    <option>All Product</option>
                                    @foreach($ProductList as $value)
                                    <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </header>
                        <ul class="plan-features product_comparison2">
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                        </ul>
                    </div>
                    <div class="plan">
                        <header>
                            <div class="pcbrand-droupdown">
                                <select class="form-control product_comparison_3">
                                    <option>All Product</option>
                                    @foreach($ProductList as $value)
                                    <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </header>
                        <ul class="plan-features product_comparison3">
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                        </ul>
                    </div>
                    <div class="plan">
                        <header>
                            <div class="pcbrand-droupdown">
                                <select class="form-control product_comparison_4">
                                    <option>All Product</option>
                                    @foreach($ProductList as $value)
                                    <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </header>
                        <ul class="plan-features product_comparison4">
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                            <li>---</li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!--  -->
    </div>
</div>

<div class="modal fade" id="totalSalesByRegionModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Total Sales by Region ?</h5>
                <form action="{{ route('admin.dashboard.total_sales_by_region_export') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="export_kiosk_data">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_export">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="toptenModeul" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Total 10 Kiosk?</h5>
                <form action="{{ route('admin.dashboard.ajax_top_ten_kiosk_export') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="export_kiosk_data">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_export_ten">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker.css')}}" />

<script type="text/javascript">
    $(document).on('click', '.total_sales_by_region_export', function() {
        $('#totalSalesByRegionModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })

    $(document).on('click', '.hide_after_export', function() {
        $('#totalSalesByRegionModel').modal('hide');
        toastr.success('Total Sales by Region Successfully Export.');
    })

    $(document).on('click', '.sales_by_location_export', function() {
        $('#salesbylocationexport').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })
    $(document).on('click', '.hide_after_exports', function() {
        $('#salesbylocationexport').modal('hide');
        toastr.success('Sales by Outlet Location Successfully Export.');
    })

    $(document).on('click', '.purchase_behaviour_export', function() {
        $('#purchasebehaviourexport').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })
    $(document).on('click', '.hide_after_exportss', function() {
        $('#purchasebehaviourexport').modal('hide');
        toastr.success('Purchase Behaviour Successfully Export.');
    })

    // top ten start
    $(document).on('click', '.top_ten_model_click', function() {
        $('#toptenModeul').modal('show');
    })

    $(document).on('click', '.hide_after_export_ten', function() {
        $('#toptenModeul').modal('hide');
        toastr.success('Top 10 Kiosk Successfully Export.');
    })
    // top ten end

    $(function() {

        var start = moment().subtract(1, 'days');
        var end = moment();


        function boxreportrange(start, end) {

            $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var start_date = start.format('MMMM D, YYYY');
            var end_date = end.format('MMMM D, YYYY');
            // alert('jds');

            var img = "{{asset('assets/img/loader.gif')}}";
            $('.boxreportrange').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
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

        function total_sales_by_region_display_range(start, end) {

            $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var start_date = start.format('MMMM D, YYYY');
            var end_date = end.format('MMMM D, YYYY');

            var img = "{{asset('assets/img/loader.gif')}}";
            $('.total_sales_by_region_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_sales_by_region')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
                    $('.total_sales_by_region_display').html(response);
                }
            });

            $('.total_sales_by_region_date').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#total_sales_by_region_display').daterangepicker({
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
        }, total_sales_by_region_display_range);
        total_sales_by_region_display_range(start, end);

        function purchase_behaviour_range(start, end) {

            $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var start_date = start.format('MMMM D, YYYY');
            var end_date = end.format('MMMM D, YYYY');

            var img = "{{asset('assets/img/loader.gif')}}";
            $('.purchase_behaviour_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_purchase_behaviour')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
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
            var start_date = start.format('MMMM D, YYYY');
            var end_date = end.format('MMMM D, YYYY');

            $('.sold_brand_start_date').val(start_date);
            $('.sold_brand_end_date').val(end_date);

            var img = "{{asset('assets/img/loader.gif')}}";
            $('.sold_brand_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_sold_brand')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
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
            var city_id = $('.sales_by_outlet_location_city').val();
            var start_date = start.format('MMMM D, YYYY');
            var end_date = end.format('MMMM D, YYYY');

            $('.city_id').val(city_id);
            $('.start_date').val(start_date);
            $('.end_date').val(end_date);

            var img = "{{asset('assets/img/loader.gif')}}";
            $('.sales_by_outlet_location_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_sales_by_location')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    city_id: city_id,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
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
        // --------------------------
        function payment_mode_display(start, end) {
            $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var city_id = $('.payment_mode_display_city').val();
            var start_date = start.format('MMMM D, YYYY');
            var end_date = end.format('MMMM D, YYYY');           
            $('.city_id').val(city_id);
            $('.start_date').val(start_date);
            $('.end_date').val(end_date);
            var img = "{{asset('assets/img/loader.gif')}}"; //payment_mode_displays
            $('.payment_mode_displays').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');
            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.sales_payment_mode')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    city_id: city_id,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
                    $('.payment_mode_displays').html(response);
                }
            });
            $('.payment_mode_time').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }
        $('#payment_mode_display').daterangepicker({
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
        }, payment_mode_display);
        payment_mode_display(start, end);
        // ===========================
    });
    $(document).on('change', '.brand_box_city', function() {
        var city_id = $(this).val();
        var start_date = $('.sold_brand_start_date').val();
        var end_date = $('.sold_brand_end_date').val();
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.ajax_sold_brand')}}";

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.sold_brand_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                city_id: city_id,
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                $('.sold_brand_display').html(response);
            }
        });

        sales_by_brand(0);
    })
    $(document).on('change', '.payment_mode_display_city', function() {
        var city_id = $(this).val();
        var start = moment().subtract(1, 'days');
        var end = moment();

        var start_date = start.format('MMMM D, YYYY');
            var end_date = end.format('MMMM D, YYYY');     
           
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.sales_payment_mode')}}";
        var img = "{{asset('assets/img/loader.gif')}}"; //payment_mode_displays
        $('.payment_mode_displays').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                city_id: city_id,
                start_date: start_date,
                end_date: end_date,
            },
            success: function(response) {
                $('.payment_mode_displays').html(response);
            }
        });
        payment_mode_display(0);
    })

    $(document).on('change', '.sales_by_outlet_location_city', function() {
        var city_id = $(this).val();
        var start_date = $('.start_date').val();
        var end_date = $('.end_date').val();
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.ajax_sales_by_location')}}";

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.sales_by_outlet_location_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                city_id: city_id,
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                $('.sales_by_outlet_location_display').html(response);
            }
        });

        sales_by_brand(0);
    })

    $(document).on('change', '.sales_by_brand_city', function() {
        var city_id = $(this).val();
        sales_by_brand(city_id);
    })

    $(document).on('change', '.product_comparison_1', function() {
        var product_id = $(this).val();
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.product_comparison_1')}}";
        var img = "{{asset('assets/img/loader.gif')}}";
        $('.product_comparison1').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                product_id: product_id,
            },
            success: function(response) {
                $('.product_comparison1').html(response);
            }
        });
    })

    $(document).on('change', '.product_comparison_2', function() {
        var product_id = $(this).val();
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.product_comparison_2')}}";
        var img = "{{asset('assets/img/loader.gif')}}";
        $('.product_comparison2').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                product_id: product_id,
            },
            success: function(response) {
                $('.product_comparison2').html(response);
            }
        });
    })

    $(document).on('change', '.product_comparison_3', function() {
        var product_id = $(this).val();
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.product_comparison_3')}}";
        var img = "{{asset('assets/img/loader.gif')}}";
        $('.product_comparison3').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                product_id: product_id,
            },
            success: function(response) {
                $('.product_comparison3').html(response);
            }
        });
    })

    $(document).on('change', '.product_comparison_4', function() {
        var product_id = $(this).val();
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.product_comparison_4')}}";
        var img = "{{asset('assets/img/loader.gif')}}";
        $('.product_comparison4').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                product_id: product_id,
            },
            success: function(response) {
                $('.product_comparison4').html(response);
            }
        });
    })

    $(document).on('change', '.airportChange', function() {
        var kiosk_airport = $(this).val();
        $('.main_class_sale').css('display','none');
        $("#total_seling").val(kiosk_airport);
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.airportChange')}}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                kiosk_airport: kiosk_airport,
            },
            success: function(response) {
                $('.airport').html(response);
            }
        });
    })


    $(document).ready(function() {
        sales_by_brand('0');
    })

    function sales_by_brand(city_id) {
        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.ajax_sales_by_brand_city')}}";

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.sales_by_brand_city_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                city_id: city_id
            },
            success: function(response) {
                $('.sales_by_brand_city_display').html(response);
            }
        });
    }

    function sold_brand_range(start, end) {

        $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        var start_date = start.format('MMMM D, YYYY');
        var end_date = end.format('MMMM D, YYYY');

        $('.sold_brand_start_date').val(start_date);
        $('.sold_brand_end_date').val(end_date);

        var img = "{{asset('assets/img/loader.gif')}}";
        $('.sold_brand_display').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

        var token = '{{csrf_token()}}';
        var url = "{{route('admin.dashboard.ajax_sold_brand')}}";
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: token,
                start_date: start_date,
                end_date: end_date
            },
            success: function(response) {
                $('.sold_brand_display').html(response);
            }
        });

        $('.sold_brand_time').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
</script>
<script>
    function reloadP() {
        sessionStorage.setItem("reloading", "true");
        document.location.reload();
    }
</script>
<script src="{{ asset('theme/js/raphael.min.js') }}"></script>
<script src="{{ asset('theme/js/morris.js') }}"></script>
<script>
 
    Morris.Bar({
            element: 'bar-chart-new',
            data: <?php echo $barChartNewJson; ?>,
            xkey: 'y',
            // hideHover: 'auto',
            xLabelAngle: 15,
            ykeys: ['a', 'b'],
            labels: ['Transition', 'Quantity'],
            resize: true,
            barColors: ['#AB96F1', '#24DEAE'],
        });
</script>
<script type="text/javascript">
$(document).on('change','.sales_by_time_interval_city',function(){
    var city_id = $(this).val();

    var token = '{{csrf_token()}}';
    var url = "{{route('admin.dashboard.sales_by_time_interval_kiosk')}}";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: token,
            city_id: city_id,
        },
        success: function(response) {
            $('.sales_by_time_interval_kiosk_dropdown_response').html(response);
        }
    });
});

$(document).on('change','.sales_by_time_interval',function(){
    var sIDate = $('.sales_by_time_interval_date').val();
    var sIKiosk = $('.sales_by_time_interval_kiosk').val();
    var sICity = $('.sales_by_time_interval_city').val();

    var token = '{{csrf_token()}}';
    var url = "{{route('admin.dashboard.sales_by_time_interval')}}";
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: token,
            sIDate: sIDate,
            sICity: sICity,
            sIKiosk: sIKiosk
        },
        success: function(response) {
            $('.sales_by_time_interval_response').html(response);
        }
    });
});
</script>

@endsection