@extends('layouts.app_admin')
@section('title','Dashboard')
@section('content')
<!--  -->
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <a href="{{route('admin.dashboard')}}">
                <span>
                    <img src="{{asset('assets/images/grey-big-arrow.png')}}" />
                </span>
                @foreach($brand_id as $value)
                <h1>{{$value->name}}</h1>
                @endforeach
            </a>
            <div class="search-box">
                <img class="search-user" src="{{asset('assets/images/search-icon.png')}}">
                <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
            </div>
        </div>
        <div class="top-droupdown-sec">
            <div class="row text-right">
                <div class="col-md-12">
                    <div class="d-badge-sec">
                        <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                            <i class="fa fa-calendar"></i>&nbsp;
                            <span></span> <i class="fa fa-caret-down"></i>
                        </div>
                    </div>
                    <input type="hidden" class="start_date">
                    <input type="hidden" class="end_date">
                    <div class="droupdown-select" style=" width: 200px;">
                        <select class="form-control kiosk_dropdown">
                            <option value="">All Kiosk</option>
                            @foreach($kiosk as $value)
                            <option value="{{$value->id}}">{{ucfirst($value->kiosk_name)}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- <div class="droupdown-select">
                        <select class="form-control city_dropdown">
                            <option value="">All Cities</option>
                            @foreach($cities as $value)
                            <option value="{{$value->id}}">{{ucfirst($value->name)}}</option>
                            @endforeach
                        </select>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="response_display"></div>
    </div>
</div>
<!--  -->
<script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/moment.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/daterangepicker.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/daterangepicker.css')}}" />

<script type="text/javascript">
    $(function() {

        var start = moment().subtract(12, 'months');
        var end = moment();

        function boxreportrange(start, end) {

            $('#id_daterangepicker span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            var start_date = start.format('MMMM D, YYYY H:m:s');
            var end_date = end.format('MMMM D, YYYY H:m:s');

            $('.start_date').val(start_date);
            $('.end_date').val(end_date);

            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

            var img = "{{asset('assets/img/loader.gif')}}";
            $('.boxreportrange').html('<div style="display:flex;justify-content: center;"><img src="' + img + '" height="100" width="100"></div>');

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_brand_dashboard_post',$brand)}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date
                },
                success: function(response) {
                    $('.response_display').html(response);
                }
            });
        }

        $('#reportrange').daterangepicker({
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

        $('.city_dropdown').change(function(e) {
            var start_date = $('.start_date').val();
            var end_date = $('.end_date').val();
            var city_id = $(this).val();
            var product_id = $('.product_dropdown').val();
            var kiosk_id = $('.kiosk_dropdown').val();

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_brand_dashboard_post',$brand)}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date,
                    city_id: city_id,
                    product_id: product_id,
                    kiosk_id: kiosk_id
                },
                success: function(response) {
                    $('.response_display').html(response);
                }
            });
        });

        $(document).on('change', '.product_dropdown', function() {
            var start_date = $('.start_date').val();
            var end_date = $('.end_date').val();
            var product_id = $(this).val();
            var city_id = $('.city_dropdown').val();
            var kiosk_id = $('.kiosk_dropdown').val();

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_brand_dashboard_post',$brand)}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date,
                    city_id: city_id,
                    product_id: product_id,
                    kiosk_id: kiosk_id
                },
                success: function(response) {
                    $('.response_display').html(response);
                }
            });
        });

        $(document).on('change', '.kiosk_dropdown', function() {
            var start_date = $('.start_date').val();
            var end_date = $('.end_date').val();
            var product_id = $('.product_dropdown').val();
            var city_id = $('.city_dropdown').val();
            var kiosk_id = $(this).val();

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_brand_dashboard_post',$brand)}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    start_date: start_date,
                    end_date: end_date,
                    city_id: city_id,
                    product_id: product_id,
                    kiosk_id: kiosk_id
                },
                success: function(response) {
                    $('.response_display').html(response);
                }
            });
        });
    });
</script>
@endsection