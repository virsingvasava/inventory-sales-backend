@extends('layouts.app_admin')
@section('title','Insentive')
@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <h1 class="mr20">ECP List</h1>
            <a class="badge export_kiosk_data_btn" href="javascript:;" data-id="1" data-toggle="tooltip" title="Are you sure to Export Data ?">Export</a>
        </div>
        <div class="common-table-sec">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-header">
                    </div>
                    <div class="table-border-style">
                        <div class="table-responsive">
                            <table class="table" id="insentive_list_table">
                                <thead>
                                    <tr>
                                        <th>Sr.No.</th>
                                        <th>Sales Person</th>
                                        <th>City</th>
                                        <th>Outlet</th>
                                        <th>Outlet Location</th>
                                        <th>Domestic/International</th>
                                        <th>FY</th>
                                        <th>Date</th>
                                        <th>Month</th>
                                        <th>Pack size</th>
                                        <th>Brand Name</th>
                                        <th>SKU Name</th>
                                        <th>Order Receipt</th>
                                        <th>QTY</th>
                                        <th>ECPA Consumer</th>
                                        <th>ECPA Staff</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($responseArr) && count($responseArr) > 0)
                                        @foreach ($responseArr as $key => $value)
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value['sale_person_name']}}</td>
                                            <td>{{$value['kiosk_city']}}</td>
                                            <td>{{$value['kiosk_outlet']}}</td>
                                            <td>{{$value['kiosk_name']}}</td>
                                            <td>{{$value['kiosk_airport']}}</td>
                                            <td>{{date('Y',strtotime($value['order_date']))}}</td>
                                            <td>{{date('d-m-Y',strtotime($value['order_date']))}}</td>
                                            <td>{{date('M Y',strtotime($value['order_date']))}}</td>
                                            <td>{{$value['product_package_size']}}</td>
                                            <td>{{$value['product_name']}}</td>
                                            <td>{{$value['sku']}}</td>
                                            @if($value['order_receipt'] != "")
                                            <td>
                                                @if(file_exists(public_path('assets/order_receipt/'.$value['order_receipt'])))
                                                <img src="{{asset('assets/order_receipt/'.$value['order_receipt'])}}" height="30" width="30">
                                                @else
                                                <img src="{{asset('assets/img/no_image.jpg')}}" height="30" width="30">
                                                @endif
                                            </td>
                                            @else
                                            <td>-</td>
                                            @endif
                                            <td>{{$value['qty']}}</td>
                                            <td>{{$value['ecpa_consumer']}}</td>
                                            <td>{{$value['ecpa_staff']}}</td>
                                        </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="10">Kiosk Not Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to download Insentive data?</h5>
                <form action="{{ route('admin.insentive.export') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_export">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>

 <script type="text/javascript">
    $(document).on('click', '.export_kiosk_data_btn', function() {
        $('#exportDataModel').modal('show');
    })

    $(document).on('click', '.hide_after_export', function() {
        $('#exportDataModel').modal('hide');
        toastr.success('Export Insentive Successfully Export.');
   })

 </script>

@endsection