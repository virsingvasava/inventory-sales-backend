<link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('theme/css/nice-select.css') }}" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('theme/css/morris.css') }}">
<link href="{{ asset('theme/css/style.css') }}" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('assets/validation/css/toastr.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/validation/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/validation/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

<div class="table-border-style">
    <div class="table-responsive">
        <table class="table" id="request_qty_table">
            <thead>
                <tr>
                    <th>Brand</th>
                    <th>Product</th>
                    <th>Packge Size</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($product) && count($product) > 0)
                    @foreach ($product as $key => $value)
                        
                        <tr>
                            <td>{{ $value->brand_name }}</td>
                            <td>{{ $value->product_name }}</td>
                            <td>{{ $value->packge_size }}</td>
                            <td>{{ $value->price }}</td>
                            <td id="qty{{ $value->id }}">
                                {{ isset($value->qty) ? $value->qty : 0 }}
                            </td>
                            <td>
                                <a class="update_button" href="javascript:;"
                                    data-id="{{ $value->id }}"
                                    data-kiosk_id="{{ isset($value->kioskId) ? $value->kioskId : $kioskId}}"
                                    data-product_id="{{ $value->productId }}"
                                    data-quantity="{{ isset($value->qty) ? $value->qty : 0 }}" data-toggle="tooltip"
                                    title="Stock Qty Update ?">
                                    <img src="{{ asset('theme/images/icon-edit.png') }}" />
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="10">Stocks Not Found</td>
                    </tr>
                @endif
                <div class="data"></div>
            </tbody>
        </table>
    </div>
</div>

<script src="{{asset('assets/validation/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/validation/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/validation/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/validation/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ asset('theme/js/jquery.nice-select.min.js') }}"></script>
<script src="{{asset('assets/validation/js/custom.js')}}"></script>
<script src="{{asset('assets/validation/js/toastr.min.js')}}"></script>
<script>
    $(document).ready(function() {
        $('#stocks_update_qty_table').DataTable();
    });
</script>