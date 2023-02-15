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
                <h1 class="mr20 back_title_text">Sales History</h1>
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
                                <select class="form-control" name="brand_name" id="brand_name_filter">
                                    @if (!empty($brands) && count($brands) > 0)
                                        @foreach ($brands as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="table-border-style">
                            <div class="table-responsive">
                                <table class="table" id="request_qty_table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%;">Sr.No</th>
                                            <th>Brand Name</th>
                                            <th>Product Name</th>
                                            <th>Packge Size</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($sales_history) && count($sales_history) > 0)
                                            @foreach ($sales_history as $key => $value)
                                                <tr>
                                                  
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $value->brand_name }}</td>
                                                    <td>{{ $value->product_name }}</td>
                                                    <td>{{ $value->packge_size }}</td>
                                                    <td>{{ $value->price }}</td>
                                                    <td>{{ $value->qty }}</td>
                                                    {{-- <td>
                                                        <a class="update_button" href="javascript:;"
                                                            data-id="{{ $value->id }}"
                                                            data-quantity="{{ $value->qty }}" data-toggle="tooltip"
                                                            title="Stock Qty Update ?">
                                                            <img src="{{ asset('theme/images/stock.png') }}" />
                                                        </a>
                                                    </td> --}}

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="10">Sales History Not Found</td>
                                            </tr>
                                        @endif
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
                    <form action='{{ route('airport_manager.stock_qty.qty_status_update') }}' method="POST">
                        @csrf
                        <input type="hidden" name="stock_id" class="stock_id">

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
            $('.stock_id').val($(this).attr('data-id'));
            $('.quantity').val($(this).attr('data-quantity'));

        })
    </script>

    <script type="text/javascript">
        $(document).on('change', '#brand_name_filter', function(e) {

            var stock_id = $('#brand_name_filter').val();
            var kiosk_name = $("#brand_name_filter  option:selected").text();
            var token = "{{ csrf_token() }}";

            $.ajax({
                type: 'GET',
                dataType: "json",
                url: '{{ route("salesman.sales_history.search") }}',
                data: {
                    'stock_id': stock_id,
                    _token: token
                },
                success: function(data) {

                    $('table tbody').empty();
                    // $('#request_qty_table').empty();
                    for (var i = 0; i < data.products.length; i++) {
                        $('table tbody').append('<tr><td>#' + data.products[i].id + '</td><td>' +
                            data.products[i].brand_name + '</td><td>' + data.products[i].product_name + '</td><td>' + data
                            .products[i].packge_size + '</td><td>' + data.products[i].price +
                            '</td><td>' + data.products[i].qty +
                            '</td><td><a class="update_button" href="javascript:;" data-id="' + data
                            .products[i].kiosk_id + '" data-quantity="' + data.products[i].qty +
                            '" data-toggle="tooltip" title="Stock Qty Update ?"> <img src="{{ asset('theme/images/stock.png') }}" /> </a></td></tr>'
                        )
                    }
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
