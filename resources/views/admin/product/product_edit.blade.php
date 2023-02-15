@extends('layouts.app_admin')

@section('title')
    {{ 'Create' }}
@endsection

@section('content')
    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <a href="{{ route('admin.product.brand.index', $brand->id) }}">
                    <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
                </a>
                <h1 class="mr20 back_title_text">{{ $brand->name }} Edit</h1>
                <a href="#" class="badge green">Active</a>
                {{-- <div class="top-btn-sec"><a href="#">Done</a></div> --}}
            </div>
            <div class="profile-main-sec">
                <form action="{{ route('admin.product.brand.update', $id) }}" method="post" id="or_product_create"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-5">
                        {{-- <div class="col-md-2" >
                            <div class="photo-upload-sec" style="display:none">

                                @if ($edit->image != '' && file_exists(public_path('assets/product_picture/' . $edit->image)))
                                    <figure><img id="product_picture"
                                            src="{{ asset('assets/product_picture/' . $edit->image) }}" /></figure>
                                @else
                                    <figure><img id="product_picture" src="{{ asset('theme/images/image-upload.png') }}" />
                                    </figure>
                                @endif
                                <div class="upload-btn-wrapper">
                                    <input type='file' onchange="readURL2(this);" name="product_picture">
                                    <button class="btn btn_file_upload">Upload a file</button>
                                    <label id="product_picture-error" class="error" for="product_picture"></label>
                                </div>

                            </div>
                        </div> --}}
                        <div class="col-md-12">
                            <div class="from-group w100">
                                <label>Tittle</label>
                                <input type="text" name="product_name" value="{{ $edit->name }}" class="form-control">

                                @if ($errors->has('product_name'))
                                    <span class="text-danger">{{ $errors->first('product_name') }}</span>
                                @endif

                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>SKU</label>
                                        <input type="text" name="sku" value="{{ $edit->sku }}" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Brand</label>
                                        <div class="droup-select">
                                            <input type="hidden" name="brand_id" value="{{$edit->brand_id}}" class="form-control">
                                            <select class="form-control nice-select" name="brand_id" readonly>
                                                <option value="">Select Brand</option>
                                                @if (!empty($brand_list) && count($brand_list) > 0)
                                                    @foreach ($brand_list as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $edit->brand_id ? 'selected' : '' }}>
                                                            {{ $value->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label id="brand_id-error" class="error" for="brand_id"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Product Status</label>
                                        <div class="droup-select">
                                            <select class="form-control nice-select custom-select" name="status">
                                                <option value="">Select Status</option>
                                                <option @if ($edit->status == 1) selected="selected" @endif
                                                    value="1">Active</option>
                                                <option @if ($edit->status == 0) selected="selected" @endif
                                                    value="0">InActive</option>
                                            </select>
                                            <label id="status-error" class="error" for="status"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Price</label>
                                        <div class="input-text"><span>₹</span>
                                            <input type="text" name="price" value="{{ $edit->price }}"
                                                class="form-control">
                                            @if ($errors->has('price'))
                                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!--
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Discount</label>
                                        <div class="input-text"><span>%</span>
                                            <input type="text" name="discount" value="{{ $edit->discount }}"
                                                class="form-control">
                                            @if ($errors->has('discount'))
                                                <span class="text-danger">{{ $errors->first('discount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Tax</label>
                                        <div class="input-text"><span>%</span>
                                            <input type="text" name="tax_price" value="{{$edit->text}}"
                                                class="form-control">
                                            @if ($errors->has('tax_price'))
                                                <span class="text-danger">{{ $errors->first('tax_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                -->
                            </div>
                            <div class="from-group w100 pack-size">
                                <label>Package Size</label>
                               
                                <div class="pack-badge" id="package_size_choose">
                                 
                                    <div class="form-check or_package_size10">
                                        <input class="form-check-input or_package_size1" type="checkbox"
                                            name="package_size" id="" value="10"
                                            {{ $edit->packge_size == 10 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="radiobutton1">
                                            10
                                        </label>
                                    </div>

                                    <div class="form-check or_package_size16">
                                        <input class="form-check-input or_package_size3" type="checkbox"
                                            name="package_size" id="" value="16"
                                            {{ $edit->packge_size == 16 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="radiobutton1">
                                            16
                                        </label>
                                    </div>
                                    
                                    <div class="form-check or_package_size20">
                                       <input class="form-check-input or_package_size3" type="checkbox" name="package_size" id="" value="20" {{ $edit->packge_size == 20 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="radiobutton1">20</label>
                                   </div>

                                </div>
                            </div>
                            <div class="from-group w100 button-sec">
                                <button type="submit" value="Save" class="btn btn-outline-success">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/validation/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>
    <script>
        $("#or_product_create").validate({
            ignore: "not:hidden",
            onfocusout: function(element) {
                this.element(element);
            },
            rules: {

                "product_name": {
                    required: true,
                },

                "brand_id": {
                    required: true,
                },

                "price": {
                    required: true,
                },

                "status": {
                    required: true,
                },
            },
            messages: {

                "product_name": {
                    required: 'Please enter name',
                },

                "brand_id": {
                    required: 'Please select brand',
                },

                "price": {
                    required: 'Please enter price',
                },

                "status": {
                    required: 'Please select status',
                },
            },
            submitHandler: function(form) {
                var $this = $('.loader_class');
                var loadingText =
                    '<i class="fa fa-spinner fa-spin" role="status" aria-hidden="true"></i> Loading...';
                $('.loader_class').prop("disabled", true);
                $this.html(loadingText);
                form.submit();
            }
        });
    </script>
    <script type="text/javascript">
        $(document).on('click', 'input[type="checkbox"]', function() {
            $('input[type="checkbox"]').not(this).prop('checked', false);
        });
    </script>
@endsection
