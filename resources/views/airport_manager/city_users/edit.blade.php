@extends('layouts.app_admin')

@section('title')
    {{ 'Edit' }}
@endsection

@section('content')

    <style>
        .from-group .cityd.droup-select .nice-select.open .list {
            width: 100%;
            height: 175px;
            overflow-y: scroll;
        }
        }
    </style>
    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <a href="{{ route('airport_manager.city_users.index') }}">
                    <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
                </a>
                <h1 class="mr20 back_title_text">User Edit</h1>
            </div>
            <div class="profile-main-sec">
                <form action="{{ route('airport_manager.city_users.update') }}" method="post" id="or_user_create"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="userId" value="{{ $edit->id }}">
                    <div class="row mt-5">
                        <div class="col-md-2">
                            <div class="photo-upload-sec">
                                @if ($edit->profile_img != '' && file_exists(public_path('assets/profile_picture/' . $edit->profile_img)))
                                    <figure><img id="profile_picture"
                                            src="{{ asset('assets/profile_picture/' . $edit->profile_img) }}" /></figure>
                                @else
                                    <figure><img id="profile_picture" src="{{ asset('theme/images/profile-pic.png') }}" />
                                    </figure>
                                @endif
                                <div class="upload-btn-wrapper">
                                    <input type='file' onchange="readURL1(this);" name="profile_picture">
                                    <button class="btn btn_file_upload">Upload a file</button>
                                    <label id="profile_picture-error" class="error" for="profile_picture"></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="from-group">
                                        <label>User Name</label>
                                        <input type="text" name="user_name" value="{{ $edit->name }}"
                                            class="form-control">
                                        @if ($errors->has('user_name'))
                                            <span class="text-danger">{{ $errors->first('user_name') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="from-group">
                                        <input type="hidden" id="city_id" name="city_id" value="{{ $edit->city_id }}">
                                        <label>City</label>
                                        <div class="droup-select cityd">
                                            <select class="form-control custom-select" id="citySelect" name="city_id"
                                                disabled>
                                                <option value="">All Cities</option>
                                                @if (!empty($cityArray) && count($cityArray) > 0)
                                                    @foreach ($cityArray as $key => $city)
                                                        <option value="{{ $city->id }}"
                                                            {{ $city->id == $edit->city_id ? 'selected' : '' }}>
                                                            {{ $city->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <label id="citySelect-error" class="error" for="citySelect"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="from-group ">
                                        <label>User Id</label>
                                        <input type="text" name="user_id" value="{{ $edit->user_id }}"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <input type="hidden" name="mobile" value="{{ $edit->mobile }}">
                                        <label>Phone No.</label>
                                        <input type="text" name="mobile" value="{{ $edit->mobile }}"
                                            class="form-control" readonly>
                                        @if ($errors->has('mobile'))
                                            <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Email Address</label>
                                        <input type="text" name="email" value="{{ $edit->email }}"
                                            class="form-control" readonly>
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
                                            <input type="hidden" id="role_id" name="role_id"
                                                value="{{ SALESMAN }}">
                                            <select class="form-control nice-select" name="role_id" disabled>
                                                <option value="">Role</option>
                                                <option @if ($edit->role_id == 2) selected="selected" @endif
                                                    value="{{ AIRPORT_MANAGER }}">Airport Manager</option>
                                                <option @if ($edit->role_id == 3) selected="selected" @endif
                                                    value="{{ BRANCH_MANAGER }}">Branch Manager</option>
                                                <option @if ($edit->role_id == 4) selected="selected" @endif
                                                    value="{{ HO }}">HO</option>
                                                <option @if ($edit->role_id == 5) selected="selected" @endif
                                                    value="{{ SALESMAN }}">Salesman</option>
                                            </select>
                                            <label id="role_id-error" class="error" for="role_id"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Date of Joining</label>
                                        <input type="date" id="datepicker" name="date_of_joining" value="{{ $edit->date_of_joining }}">
                                        @if ($errors->has('date_of_joining'))
                                            <span class="text-danger">{{ $errors->first('date_of_joining') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="from-group">
                                        <label>Status</label>
                                        <div class="droup-select">
                                            <select class="form-control custom-select nice-select" name="status">
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
                            <div class="from-group w100 button-sec">
                                <button type="submit" value="Save" class="btn btn-outline-success">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
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

                "user_name": {
                    required: true,
                },

                "email": {
                    required: true,
                    email: true,
                },

                "city_id": {
                    required: true,
                },

                "role_id": {
                    required: true,
                },

                "status": {
                    required: true,
                }
            },
            messages: {

                "user_name": {
                    required: 'Please enter user name',
                },

                "email": {
                    required: 'Please enter email address',
                    email: 'Please enter valid email address',
                    emailCheck: 'Please enter valid email address',
                },

                "role_id": {
                    required: 'Please select role',
                },

                "city_id": {
                    required: 'Please select city',
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
@endsection
