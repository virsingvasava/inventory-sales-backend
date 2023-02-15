@extends('layouts.app_admin')
@section('title','Dashboard')
@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <a href="{{route('admin.dashboard.sales')}}">
                <span>
                    <img src="{{asset('assets/images/grey-big-arrow.png')}}" />
                </span>
                <h1>Month Sales History</h1>
            </a>
            <a class="badge export_data_btn" href="javascript:;" data-id="" data-toggle="tooltip" title="Are you sure to Export Data ?">
                Export
            </a>
            <div class="search-box">
                <img class="search-user" src="{{asset('assets/images/search-icon.png')}}">
                <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
            </div>
        </div>
        <!--  -->
        <div class="wbgw-table-sec mt-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-header">
                        <h3>Month Sales</h3>
                    </div>
                    <div class="table-border-style">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sr.No</th>
                                        <th>Order_Id</th>
                                        <th>Items</th>
                                        <th>Total</th>
                                        <th>Mode</th>
                                        <!-- <th>Action</th> -->

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    @foreach($order_items as $value)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{$value->id}}</td>
                                        <td>{{$value->qty}}</td>
                                        <td>{{$value->total_amount}}</td>
                                        <td>{{$value->payment_mode}}</td>
                                        <!-- <td>0</td> -->
                                    </tr>
                                    <?php $i++; ?>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  -->
        <div class="response_display"></div>
    </div>
    <div class="modal fade" id="exportSalesDashboardmonth" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-size:20px">Are You sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Sales by date  ?</h5>
                    <form action="{{ route('admin.dashboard.sales_day_export') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="date" value="{{$date}}">
                        <input type="hidden" name="export_kiosk_data">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary btn-sm hide_after_exports">Export</button>
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/apexcharts.min.js')}}"></script>
<script type="text/javascript">
    $(document).on('click', '.export_data_btn', function() {
        $('#exportSalesDashboardmonth').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })
    $(document).on('click', '.hide_after_export', function() {
        $('#exportSalesDashboardmonth').modal('hide');
        toastr.success('Sales History Successfully Export.');
    })
</script>
@endsection