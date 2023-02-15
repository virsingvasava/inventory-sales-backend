@extends('layouts.app_admin')

@section('title')
    {{ 'Dashboard' }}
@endsection

@section('content')

    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <a href="{{ route('airport_manager.dashboard.index') }}">
                    <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
                </a>
                <h1 class="mr20 back_title_text"> Stocks Qty Update</h1>
                <div class="search-box" style="display:none">
                    <img class="search-user" src="{{ asset('theme/images/search-icon.png') }}">
                    <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
                </div>
            </div>
            <div class="city-sec"></div>
            <div class="common-table-sec um-table">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-header pr-theader">
                            <div class="droupdown-select" style="display:none">
                                <select class="form-control">
                                    <option>Pending</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                            <div class="droupdown-select">
                                <select class="form-control kiosk_name_filter" name="kiosk_name" id="kiosk_name_filter2">
                                    @if (!empty($kiosk_list) && count($kiosk_list) > 0)
                                        @foreach ($kiosk_list as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->kiosk_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="table-border-style">
                            <div class="table-responsive" id="updateDiv">
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
                                                            data-kiosk_id="{{ $value->kioskId }}"
                                                            data-product_id="{{ $value->productId }}"
                                                            data-quantity="{{ isset($value->qty) ? $value->qty : 0 }}"
                                                            data-toggle="tooltip" title="Stock Qty Update ?">
                                                            <img src="{{ asset('theme/images/icon-edit.png') }}" />
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10">Pending Request Not Found</td>
                                            </tr>
                                        @endif
                                        <div class="data"></div>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h30"></div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-size:20px">Are You sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 style="font-size:15px; margin: 0 0 0px;">Are you sure to Update Stock Qty ?</h5>
                    {{-- action='{{ route('airport_manager.stock_qty_update.qty_status_update') }}' method="POST" --}}
                    <form  id="formSubmitForupdate">
                        @csrf
                        <input type="hidden" name="kioskId" class="kioskId">
                        <input type="hidden" name="productId" class="productId">

                        <div class="from-group">
                            <label>Quantity</label>
                            <input type="text" class="quantity" name="quantity">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="d-sm-inline-block btn btn-sm btn-info"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit"
                                class="d-none d-sm-inline-block btn btn-sm  btn-info stock_update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).on('click', '.update_button', function() {
            $('#updateModal').modal('show');
            $('.kioskId').val($(this).attr('data-kiosk_id'));
            $('.productId').val($(this).attr('data-product_id'));
            $('.quantity').val($(this).attr('data-quantity'));

        })

        $('#formSubmitForupdate').submit(function(event) {
            event.preventDefault();
            var token = "{{ csrf_token() }}";
            $.ajax({
                url: '{{ route('airport_manager.stock_qty_update.qty_status_update') }}',
                type: 'post',
                data: $('#formSubmitForupdate').serialize(), // Remember that you need to have your csrf token included
                dataType: 'json',
                success: function(data) {
                    $('#updateModal').modal('hide');
                    res = data;
                    // console.log("res", res);
                    document.getElementById("qty"+res.data.id).innerHTML = res.data.qty;
                    toastr.success(data.success);
                    // setTimeout(function(){ location.reload(); }, 1000);
                },
                error: function(data) {
                }
            });
        });
    </script>


    <script type="text/javascript">
        $(document).on('change', '.kiosk_name_filter', function(e) {

            var kioskId = $('.kiosk_name_filter').val();
            var kiosk_name = $(".kiosk_name_filter  option:selected").text();
            var token = "{{ csrf_token() }}";

            $.ajax({
                type: 'GET',
                dataType: "html",
                url: '{{ route('airport_manager.stock_qty_update.search') }}',
                data: {
                    'kioskId': kioskId,
                    _token: token
                },
                success: function(data) {
                    $('#updateDiv').html(data);
                    /*
                    $('table tbody').empty();
                    for (var i = 0; i < data.products.length; i++) {
                        let qty = 0;
                        if ((data.products[i].qty === undefined || data.products[i].qty === null)) {
                            qty = 0;
                        } else {
                            qty = data.products[i].qty;
                        }
                        console.log("qty", qty);
                        console.log("data.products[i].qty", data.products[i].qty);
                        $('table tbody').append('<tr><td>' + data.products[i].brand_name + '</td><td>' +
                            data.products[i].product_name + '</td><td>' + data
                            .products[i].packge_size + '</td><td>' + data.products[i].price +
                            '</td><td>' + qty +
                            '</td><td><a class="update_button" href="javascript:;" data-id="' + data
                            .products[i].id + '" data-kiosk_id="' + stock_id +
                            '" data-product_id="' + data.products[i].productId +
                            '" data-quantity="' + qty +
                            '" data-toggle="tooltip" title="Stock Qty Update ?"><img src="{{ asset('theme/images/icon-edit.png') }}" /></a></td></tr>'
                        )
                    }
                    */
                },
                timeout: 10000
            });

        });
    </script>
    <style>
        button.d-none.d-sm-inline-block.btn.btn-sm.btn-info.stock_update {
            background-color: #5C3FFE;
            color: #fff;
            border-color: #5C3FFE;
        }

        .btn-info:hover {
            color: #fff;
            background-color: #5C3FFE;
            border-color: #5C3FFE;
        }
    </style>
@endsection
