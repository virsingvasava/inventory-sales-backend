@extends('layouts.app_admin')
@section('title')
    {{ 'Create' }}
@endsection
@section('content')
    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <a href="{{ route('admin.user_management.index') }}">
                    <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
                </a>
                <h1 class="mr20 back_title_text">User Create</h1>
            </div>
            <div class="profile-main-sec">
                <form action="{{ route('admin.user_management.store') }}" method="post" id="or_user_create"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mt-5">
                        <div class="col-md-2">
                            <div class="photo-upload-sec">
                                <figure><img id="profile_picture" src="{{ asset('theme/images/profile-pic.png') }}" />
                                </figure>
                                <div class="upload-btn-wrapper">
                                    <input type='file' onchange="readURL1(this);" name="profile_picture">
                                    <button class="btn btn_file_upload">Upload a file</button>
                                    <label id="profile_picture-error" class="error" for="profile_picture"></label>
                                    @if ($errors->has('profile_picture'))
                                        <span class="text-danger">{{ $errors->first('profile_picture') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="from-group w100">
                                <label>User Name</label>
                                <input type="text" name="user_name" value="{{ old('user_name') }}" class="form-control">
                                @if ($errors->has('user_name'))
                                    <span class="text-danger">{{ $errors->first('user_name') }}</span>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group ">
                                        <label>User Id</label>
                                        <input type="text" name="user_id" value="{{ $genrateId }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Phone No.</label>
                                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                                            class="form-control">
                                        @if ($errors->has('mobile'))
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Email Address</label>
                                        <input type="text" name="email" value="{{ old('email') }}"
                                            class="form-control">
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Role</label>
                                        <div class="droup-select">
                                            <select class="form-control nice-select" name="role_id">
                                                <option value="">Role</option>
                                                <option value="{{ AIRPORT_MANAGER }}">Airport Manager</option>
                                                <option value="{{ BRANCH_MANAGER }}">Branch Manager</option>
                                                <option value="{{ HO }}">HO</option>
                                                <option value="{{ SALESMAN }}">Salesman</option>
                                            </select>
                                            <label id="role_id-error" class="error" for="role_id"></label>
                                            @if ($errors->has('role_id'))
                                                <span class="text-danger">{{ $errors->first('role_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Date of Joining</label>
                                        <input type="date" id="datepicker" name="date_of_joining" />
                                        @if ($errors->has('date_of_joining'))
                                            <span class="text-danger">{{ $errors->first('date_of_joining') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>City</label>
                                        <div class="droup-select cityd">
                                            <select class="form-control custom-select" id="citySelect" name="city_id">
                                                <option value="">All Cities</option>
                                                @if (!empty($cityArray) && count($cityArray) > 0)
                                                    @foreach ($cityArray as $key => $city)
                                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label id="citySelect-error" class="error" for="citySelect"></label>
                                            @if ($errors->has('city_id'))
                                                <span class="text-danger">{{ $errors->first('city_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
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
                                            @if ($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group ">
                                        <label>Password</label>
                                        <input type="password" name="password" id="password"
                                            value="{{ old('password') }}" class="form-control">
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Confirm Password</label>
                                        <input type="password" name="confirm_password"
                                            value="{{ old('confirm_password') }}" class="form-control">
                                        @if ($errors->has('confirm_password'))
                                            <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
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
    <script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>


<script language="javascript">
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;
    $('#datepicker').attr('min',today);
</script>


    <script>
        $(document).ready(function() {
            $('select:not(.ignore)').niceSelect();
            FastClick.attach(document.body);
        });

        $ = jQuery;

        $(document).ready(function() {
            $('select').niceSelect();
        });

        $(document).ready(function() {

            $('#citySelect').niceSelect();

        });

        $("#or_user_create11").validate({
            ignore: "not:hidden",
            onfocusout: function(element) {
                this.element(element);
            },
            rules: {

                "profile_picture": {
                    required: true,
                },

                "user_name": {
                    required: true,
                },

                "mobile": {
                    required: true,
                    number: true,
                },

                "email": {
                    required: true,
                    email: true,
                },

                "role_id": {
                    required: true,
                },

                "city_id": {
                    required: true,
                },

                "date_of_joining": {
                    required: true,
                },

                "status": {
                    required: true,
                },

                "password": {
                    required: true,
                    minlength: 6,
                },
                "confirm_password": {
                    equalTo: '#password',
                }
            },
            messages: {

                "profile_picture": {
                    required: 'Please upload the profile picture',
                },

                "user_name": {
                    required: 'Please enter user name',
                },

                "mobile": {
                    required: 'Please enter phone number',
                    number: "Please enter valid phone number",
                },

                "email": {
                    required: 'Please enter email address',
                    email: 'Please enter valid email address',
                },

                "role_id": {
                    required: 'Please select role',
                },

                "city_id": {
                    required: 'Please select city',
                },

                "date_of_joining": {
                    required: 'Please select Date of Joining',
                },

                "status": {
                    required: 'Please select status',
                },
                "password": {
                    required: 'Please enter password',
                    minlength: 'Please password must be 6 character',
                },
                "confirm_password": 'Password and re-type password must match',
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


        $(document).ready(function() {
            $('select:not(.ignore)').niceSelect();
            FastClick.attach(document.body);
        });

        $ = jQuery;

        $(document).ready(function() {
            $('select').niceSelect();
        });

        $(document).ready(function() {

            $('#citySelect').niceSelect();

        });
    </script>

    <style>
        .from-group .cityd.droup-select .nice-select .list {
            width: 100%;
            height: 175px;
            overflow-y: scroll;
        }
        
    </style>

@endsection
