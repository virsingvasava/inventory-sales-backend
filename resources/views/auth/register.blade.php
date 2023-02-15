@extends('partials.login.app_login')
@section('title')
    {{ 'Login' }}
@endsection
@section('content')
    <div class="login-box">
        <div class="main-content-part">
            <div class="main-content-padd">
                <div class="profile-main-sec">
                    <form action="{{ route('register.submit') }}" method="post" id="or_user_create"
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
                                    <input type="text" name="user_name" value="{{ old('user_name') }}"
                                        class="form-control" placeholder="Name">
                                    @if ($errors->has('user_name'))
                                        <span class="text-danger">{{ $errors->first('user_name') }}</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="from-group ">
                                            <input type="text" name="user_id" value="{{ $genrateId }}"
                                                placeholder="User ID" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="from-group">
                                            <input type="text" name="mobile" value="{{ old('mobile') }}"
                                                class="form-control" placeholder="Phone Number">
                                            @if ($errors->has('mobile'))
                                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="from-group">
                                            <input type="text" name="email" value="{{ old('email') }}"
                                                class="form-control" placeholder="Email">
                                            @if ($errors->has('email'))
                                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="from-group">
                                            <input type="date" id="datepicker" name="date_of_joining"
                                                placeholder="Date of Joining<">
                                            @if ($errors->has('date_of_joining'))
                                                <span class="text-danger">{{ $errors->first('date_of_joining') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="from-group">
                                            <div class="droup-select droup-select cityd">
                                                <select class="form-control custom-select" id="citySelect" name="city_id">
                                                    <option value="">All Cities</option>
                                                    @if (!empty($cityArray) && count($cityArray) > 0)
                                                        @foreach ($cityArray as $key => $city)
                                                            <option value="{{ $city->id }}">{{ $city->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                <label id="citySelect-error" class="error" for="citySelect"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="from-group">
                                            <input type="hidden" id="role_id" name="role_id"
                                                value="{{ SALESMAN }}">
                                            <div class="droup-select salseman">
                                                <select class="form-control nice-select" name="role_id" disabled>
                                                    <option value="{{ SALESMAN }}">Salesman</option>
                                                </select>
                                                <label id="role_id-error" class="error" for="role_id"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="from-group ">
                                            <input type="password" name="password" id="password"
                                                value="{{ old('password') }}" class="form-control" placeholder="Password">
                                            @if ($errors->has('password'))
                                                <span class="text-danger">{{ $errors->first('password') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="from-group">
                                            <input type="password" name="confirm_password"
                                                value="{{ old('confirm_password') }}" class="form-control"
                                                placeholder="Confirm Password">
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
    </div>
    <script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>
    <script>
        $("#or_user_create").validate({
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

                "city_id": {
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
                "date_of_joining": {
                    required: true,
                    date: true

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

                "city_id": {
                    required: 'Please select city',
                },

                "mobile": {
                    required: 'Please enter phone number',
                    number: "Please enter valid phone number",
                },

                "email": {
                    required: 'Please enter email address',
                    email: 'Please enter valid email address',
                },

                "date_of_joining": {
                    required: 'Please select Date of Joining',
                    date: "Can contain digits only"
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
        .profile-main-sec {
            width: 1000px;
        }

        body.salesman_regi {
            height: 100vh;
        }

        .from-group .cityd.droup-select .nice-select .list {
            width: 100%;
            height: 175px;
            overflow-y: scroll;
        }
        .from-group .droup-select.salseman .nice-select.form-control::after{display:none;}
    </style>
@endsection
