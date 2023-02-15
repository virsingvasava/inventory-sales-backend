@extends('layouts.app_admin')

@section('title') 
    {{'Create'}}
@endsection

@section('content')

<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <a href="{{route('admin.product.index')}}">
                <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
            </a>
            <h1 class="mr20 back_title_text">Brand Edit</h1>
        </div>
        <div class="profile-main-sec">
            <form action="{{ route('admin.product.store') }}" method="post" id="or_kiosk_create"  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="brand_Id" value="{{$edit->id}}">

                <div class="row mt-5">
                   
                    <div class="col-md-12">
                      
                        <div class="row">
                            <div class="col-md-6">
                                <div class="from-group w100">
                                    <label>Name</label>
                                    <input type="text" name="name" value="{{$edit->name}}" class="form-control">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="from-group">
                                    <label>Status</label>
                                    <div class="droup-select">
                                        <select class="form-control custom-select" name="status">
                                            <option value="">Select Status</option>
                                            <option @if($edit->status == 1) selected="selected" @endif value="1">Active</option>
                                            <option @if($edit->status == 0) selected="selected" @endif value="0">InActive</option>
                                        </select>
                                        <label id="status-error" class="error" for="status"></label>
                                    </div>
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
<script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>
{{-- <script src="{{asset('assets/validation/js/jquery_validation.js')}}"></script> --}}

<script>
    $("#or_kiosk_create").validate({
        ignore: "not:hidden",
        onfocusout: function(element) {
            this.element(element);
        },
        rules: {

            "kisok_name": {
                required: true,
            },
            "status": {
                required: true,
            },
        },
        messages: {

            "kisok_name": {
                required: 'Please enter kiosk name',
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
@endsection