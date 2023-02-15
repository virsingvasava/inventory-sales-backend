@extends('layouts.app_admin')

@section('title')
{{ 'index' }}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <h1 class="mr20">Oos Alert</h1>
            <a class="badge export_kiosk_data_btn" href="javascript:;">
                Export
            </a>
        </div>
        <div class="user-m-box">
            <div class="row">
                <div class="col-md-12">
                    <div class="droupdown-select">
                        <select class="form-control city_dropdown">
                            <option value="all_city">All Cities</option>
                            @foreach($cities as $value)
                            <option value="{{$value['id']}}">{{ucfirst($value['name'])}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="droupdown-select kiosk_dropdowns">
                        <select class="form-control kiosk_dropdown">
                            <option value=""> All kiosk First Select City</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="common-table-sec um-table">
            <div class="row">
                <div class="col-sm-12">
                    @include('partials.login.toastr')
                </div>
                <div class="col-md-12">
                    <div class="table-header" style="display:none">
                        <div class="droupdown-select">
                            <select name="status" id="status" class="form-control custom-control">
                                <option value="">Select status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="droupdown-select">
                            <select class="form-control">
                                <option>All Cities</option>
                                <option>Baroda</option>
                                <option>Mumbai</option>
                                <option>Bhopal</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="response_display">
            <div class="table-border-style">
                <div class="table-responsive">
                    <table class="table" id="user_table">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 5%;">Sr.No</th>
                                <th>Sku</th>
                                <th>Product Name</th>
                                <th>Brand</th>
                                <th>Quantity</th>
                                <th>Kiosk Name</th>
                                <th>City</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if (!empty($oos) && count($oos) > 0)
                            <?php $i = 1; ?>
                            @foreach($oos as $value)
                            <tr>
                                <td class="text-center">{{$i}}</td>
                                <td>{{$value->sku}}</td>
                                <td>{{$value->product_name}}</td>
                                <td>{{$value->brand_name}}</td>
                                <td>{{$value->qty}}</td>
                                <td>{{$value->kiosk_name}}</td>
                                <td>{{$value->city_name}}</td>
                            </tr>
                            <?php $i++; ?>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="10">Data Not Found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal fade" id="exportDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 style="font-size:20px">Are You sure?</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Kiosk ?</h5>
                            <form action="{{ route('admin.dashboard.export_listing_data') }}" method="POST" enctype="multipart/form-data">
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
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript">
    // $(document).on('click', '.import_data_btn', function() {
    //     $('#importDataModel').modal('show');
    //     $('.userId').val($(this).attr('data-id'));
    // })
    $(document).on('click', '.export_kiosk_data_btn', function() {
        $('#exportDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })

    $(document).on('click', '.hide_after_export', function() {
        $('#exportDataModel').modal('hide');
        toastr.success('Export Kiosk Successfully Export.');
    })

    $(document).on('click', '.export_data_btn', function() {
        $('#exportSampleDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })
</script>
<script type="text/javascript">
    $(function() {
        $('.city_dropdown').change(function(e) {
            var city_id = $(this).val();
            var token = '{{csrf_token()}}';
            var kiosk_id = $('.kiosk_dropdown').val();
            var url = "{{route('admin.dashboard.ajax_oss_alert')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    city_id: city_id,

                },
                success: function(response) {
                    $('.response_display').html(response);
                }
            });

            var token = '{{csrf_token()}}';
            var url = "{{route('admin.dashboard.ajax_oss_alert_kiosk')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    city_id: city_id,
                },
                success: function(response) {
                    $('.kiosk_dropdowns').html(response);
                }
            });
        });
        $('.kiosk_dropdowns').change(function(e) {
            var city_id = $('.city_dropdown').val();
            var token = '{{csrf_token()}}';
            var kiosk_id =  $('.kiosk_dropdown').val();
            var url = "{{route('admin.dashboard.ajax_oss_alert')}}";
            $.ajax({
                url: url,
                type: 'POST',
                data: {
                    _token: token,
                    city_id: city_id,
                    kiosk_id: kiosk_id,

                },
                success: function(response) {
                    $('.response_display').html(response);
                }
            });
        });
    });
</script>

<script>
    
</script>

@endsection