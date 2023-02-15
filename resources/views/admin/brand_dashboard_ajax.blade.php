<div class="row">
    <div class="col-md-12">
        <div class="salse-whitebox">
            <div class="c-block">
                <div class="card-title">Total Sale</div>
                <h3><span>₹</span>{{$totalpack_Sale}}</h3>
            </div>
            <div class="c-block">
                <div class="card-title">Pack Sold</div>
                <h3><span></span>{{$totalpack_sold}}</h3>
            </div>
            <div class="c-block">
                <div class="card-title">No. of Products</div>
                <h3>{{$totalproduct}}</h3>
            </div>
        </div>
    </div>
</div>
<div class="salsechart mt-5">
    <div class="table-header">
        <h3>Sales Chart</h3>
    </div>
    <div id="bar-chart"></div>
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
                                <th>Sku</th>
                                <th>Product</th>
                                <th>Pack Sold</th>
                                <th>Total sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($OutletLocation as $key => $value)
                            <tr>
                                <td>{{$value['sku']}}</td>
                                <td>{{$value['name']}}</td>
                                <td>{{$value['total_qty']}}</td>
                                <td>{{$value['total_amount']}}</td>
                            </tr>
                            @endforeach
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
                            <form action="{{ route('admin.dashboard.export_listing_data_post') }}" method="POST" enctype="multipart/form-data">
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
<div class="h30"></div>

<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.nice-select.min.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>
<script src="{{asset('assets/js/apexcharts.min.js')}}"></script>
<script src="{{ asset('theme/js/raphael.min.js') }}"></script>
<script src="{{ asset('theme/js/morris.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>
