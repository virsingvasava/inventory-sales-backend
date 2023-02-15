@extends('layouts.app_admin')

@section('title')
    {{ 'Create' }}
@endsection
<style>
    .product-block{
        justify-content: center
    }
    .delete{
        top: 0;
    position: absolute;
    right: 0;
    padding: 15px;
    }
    .product-block{
        width: 29.4%;
    display: inline-flex;
    align-items: center;
    vertical-align: top;
    padding: 20px 27px;
    flex-direction: column;
    background: #fff;
    box-shadow: 0 10px 30px rgb(0 0 0 / 16%);
    -moz-box-shadow: 0 10px 30px rgba(0, 0, 0, 0.16);
    -webkit-box-shadow: 0 10px 30px rgb(0 0 0 / 16%);
    border-radius: 15px;
    margin: 0 3% 33px 0;
    min-height: 145px;
    position: relative;
    }
</style>
@section('content')
    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <h1 class="mr20">Products</h1>
                <a href="{{ route('admin.product.create') }}" class="badge">Add New</a>
                {{-- <a href="#" class="badge">Import</a> --}}
                {{-- <a class="badge import_data_btn" href="javascript:;" data-id="1" data-toggle="tooltip" title="Are you sure to Import Data ?">
            Import
        </a> --}}
                {{-- <a href="#" class="badge">Export</a> --}}
                <div class="search-box" style="display:none">
                    <img class="search-user" src="{{ asset('theme/images/search-icon.png') }}">
                    <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
                </div>
            </div>
            <div class="product-block-sec">
                <div class="row">
                    <div class="col-md-12">
                        @if (!empty($brand) && count($brand) > 0)
                            @foreach ($brand as $key => $val)
                                <div class="product-block">
                                    <div class="delete">
                                    <a class="delete_product_button" href="javascript:;" data-id="{{ $val->id }}"
                                        data-toggle="tooltip" title="Are you sure to Delete Brand with products ?">
                                        <img src="{{ asset('theme/images/delete.png') }}" />
                                    </a>
                                </div>
                                    
                                    <a href="{{ route('admin.product.brand.index', $val->id) }}">
                                        <h3 class="text-center">
                                            {{ $val->name }}
                                        </h3>
                                    </a>
                                    
                                </div>
                               
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="modal fade" id="importDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-size:20px">Are You sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Import Product ?</h5>
                    <form action="{{ route('admin.product.index') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="userId" class="userId">
                        <input type="file" name="import_data">

                        <div class="modal-footer">
                            <button type="submit"
                                class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Import</button>
                            <button type="button" class="d-sm-inline-block btn btn-sm btn-info"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>

    <div class="modal fade" id="deleteModalProduct" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 style="font-size:20px">Are You sure?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 style="font-size:15px; margin: 0 0 0px;">Are you sure to Delete Brand Product ?</h5>
                    <form action="{{ route('admin.product.brand_product_delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="brandId" class="brandId">

                        <div class="modal-footer">
                            <button type="button" class="d-sm-inline-block btn btn-sm btn-info"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit"
                                class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).on('click', '.import_data_btn', function() {
            $('#importDataModel').modal('show');
            $('.userId').val($(this).attr('data-id'));
        })

        $(document).on('click', '.delete_product_button', function() {
            $('#deleteModalProduct').modal('show');
            $('.brandId').val($(this).attr('data-id'));
        })
    </script>

@endsection
