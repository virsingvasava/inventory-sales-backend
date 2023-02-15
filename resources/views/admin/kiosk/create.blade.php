@extends('layouts.app_admin')

@section('title') 
    {{'Create'}}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <a href="{{route('admin.kiosk.index')}}">
                <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
            </a>
            <h1 class="mr20 back_title_text">Kiosk Create</h1>
        </div>
        <div class="profile-main-sec">
            <form action="{{ route('admin.kiosk.store') }}" method="post" id="or_kiosk_create"  enctype="multipart/form-data">
                @csrf
                <div class="row mt-5">
                   
                    <div class="col-md-12">
                        <div class="from-group w100">
                            <label>Kiosk Name</label>
                            <input type="text" name="kisok_name" value="{{ old('kisok_name') }}" class="form-control">
                            @if ($errors->has('kisok_name'))
                                <span class="text-danger">{{ $errors->first('kisok_name') }}</span>
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="from-group ">
                                    <label>Kiosk Id</label>
                                    <input type="text" name="kiosk_id" value="{{$kiosk_genrateId}}" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="from-group">
                                    <label>Location</label>
                                    <div class="droup-select">
                                        <select class="form-control nice-select" name="location_id">
                                            <option value="">Location</option>
                                            @if (!empty($location) &&  count($location) > 0)
                                                @foreach ($location as $key => $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label id="location_id-error" class="error" for="location_id"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="from-group">
                                    <label>City</label>
                                    <div class="droup-select">
                                        <select class="form-control nice-select" name="city_id">
                                            <option value="">City</option>
                                            @if (!empty($city) &&  count($city) > 0)
                                                @foreach ($city as $key => $value)
                                                    <option value="{{$value->id}}">{{$value->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <label id="city_id-error" class="error" for="city_id"></label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="from-group">
                                    <label>All Airport</label>
                                    <div class="droup-select">
                                        <select class="form-control nice-select" name="airport">
                                            <option value="International">International</option>
                                            <option value="Domestic">Domestic</option>
                                        </select>
                                        <label id="airport-error" class="error" for="airport"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="from-group">
                                    <label>Status</label>
                                    <div class="droup-select">
                                        <select class="form-control custom-select nice-select" name="status">
                                            <option value="">Select Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">InActive</option>
                                        </select>
                                        <label id="status-error" class="error" for="status"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="from-group w100 button-sec">
                            <button type="submit" value="Save" class="btn btn-outline-success">Submit</button>
                            {{-- <button type="submit" value="Save" class="btn-save">Save</button><span></span>
                            <button type="done" value="Done" class="btn-done">Done</button> --}}
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

            "location_id": {
                required: true,
            },
            "city_id": {
                required: true,
            },
            "airport": {
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

            "location_id": {
                required: 'Please select location',
            },

            "city_id": {
                required: 'Please select city',
            },

            "airport": {
                required: 'Please select airport',
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