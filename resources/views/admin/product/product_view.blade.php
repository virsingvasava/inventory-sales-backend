@extends('layouts.app_admin')

@section('title') 
    {{'Create'}}
@endsection

@section('content')
<div class="main-content-part">
   <div class="main-content-padd">
      <div class="title-w-arrow">
         <span><img src="{{ asset('theme/images/grey-big-arrow.png')}}"/></span>
         <h1 class="mr20">{{$brand->name}}</h1>
         <a href="#" class="badge green">Active</a>
         {{-- 
         <div class="top-btn-sec"><a href="#">Done</a></div>
         --}}
      </div>
      <div class="profile-main-sec">
         <form action="{{ route('admin.product.brand.store', $id) }}" method="post" id="or_product_create"  enctype="multipart/form-data">
            @csrf
            <div class="row mt-5">
               <div class="col-md-2">
                  <div class="photo-upload-sec">
                     <figure><img id="product_picture" src="{{ asset('theme/images/image-upload.png') }}" /></figure>
                     <div class="upload-btn-wrapper">
                        <input type='file' onchange="readURL2(this);" name="product_picture">
                        <button class="btn">Upload a file</button>
                        <label id="product_picture-error" class="error" for="product_picture"></label>
                     </div>
                  </div>
               </div>
               <div class="col-md-10">
                  <div class="from-group w100">
                     <label>Tittle</label>
                     <input type="text" name="product_name" value="{{ old('product_name') }}" class="form-control">
                    
                     @if ($errors->has('product_name'))
                        <span class="text-danger">{{ $errors->first('product_name') }}</span>
                     @endif

                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>SKU</label>
                           <input type="text" name="sku" value="{{$productSkuId}}" class="form-control" readonly>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Brand</label>
                           <div class="droup-select">
                              <select class="form-control" name="brand_id">
                                 <option value="">Select Brand</option>
                                 @if (!empty($brand_list) && count($brand_list) > 0)
                                    @foreach ($brand_list as $key => $value)
                                    <option value="{{$value->id}}" {{ $value->id == $brand->id ? 'selected' : '' }}>{{$value->name}}</option>
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
                              <select class="form-control custom-select" name="status">
                                 <option value="">Select Status</option>
                                 <option value="1">Active</option>
                                 <option value="0">InActive</option>
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
                              <input type="text" name="price" value="{{ old('price') }}" class="form-control">
                              @if ($errors->has('price'))
                              <span class="text-danger">{{ $errors->first('price') }}</span>
                              @endif
                           </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Discount</label>
                           <div class="input-text"><span>%</span>
                              <input type="text" name="discount" value="{{ old('discount') }}" class="form-control">
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
                              <input type="text" name="tax_price" value="{{ old('tax_price') }}" class="form-control">
                              @if ($errors->has('tax_price'))
                              <span class="text-danger">{{ $errors->first('tax_price') }}</span>
                              @endif
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="from-group w100 pack-size">
                     <label>Package Size</label>
                     <div class="pack-badge" id="package_size_choose">
                        {{-- <a href="#" class="badge green-active">10</a>
                        <a href="#" class="badge">20</a> --}}
                        <div class="form-check or_package_size10">
                           <input class="form-check-input or_package_size1" type="checkbox" name="package_size" id="" value="10" checked>
                              <label class="form-check-label" for="radiobutton1">
                                 10
                              </label>
                        </div>
                        <div class="form-check or_package_size20">
                           <input class="form-check-input or_package_size2" type="checkbox" name="package_size" id="radiobutton2"
                              value="20">
                              <label class="form-check-label" for="exampleRadios2">
                                 20
                              </label>
                        </div>
                     </div>
                  </div>
                  <div class="from-group w100 button-sec">
                     <button type="submit" value="Save" class="btn-save">Save</button><span></span>
                     <button type="done" value="Done" class="btn-done">Done</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
<script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>
<script>
   $("#or_product_create").validate({
            ignore: "not:hidden",
            onfocusout: function(element) {
                this.element(element);
            },
            rules: {

                "product_picture": {
                    required: true,
                },

                "product_name": {
                    required: true,
                },

                "brand_id": {
                    required: true,
                },

                "price": {
                    required: true,
                },

                "discount" : {
                   required:true,
                },

                "tax_price" : {
                   required:true,
                },

                "status": {
                    required: true,
                },
            },
            messages: {

                "product_picture": {
                    required: 'Please upload the product picture',
                },

                "product_name": {
                    required: 'Please enter name',
                },

                "brand_id": {
                    required: 'Please select brand',
                },

                "price": {
                    required: 'Please enter price',
                },

                "discount": {
                    required: 'Please enter discount',
                },

                "tax_price": {
                    required: 'Please enter taxt',
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
