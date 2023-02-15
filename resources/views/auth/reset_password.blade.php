@extends('partials.login.app_login')

@section('title')
    {{ 'Login' }}
@endsection

@section('content')
    <div class="login-box">
     
        <div class="main-content-part">
            <div class="main-content-padd">
                <div class="profile-main-sec">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="title-w-arrow">
                                <p class="text-center">You are only one step a way from your new password, recover your password now.</p>
                            </div>
                            <div class="photo-upload-sec">
                                <figure><img src="{{ asset('assets/img/sample_logo.png') }}" /></figure>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('password.submit')}}" method="post" id="reset_password_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="from-group">
                                    <input type="text" class="form-control" value="{{$user->email}}" placeholder="E-mail" readonly="readonly">
                                    <input type="hidden" name="user_id" value="{{$user->_id}}">
                                    <input type="hidden" name="email" value="{{$user->email}}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="from-group ">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="from-group ">
                                    <label id="confirm_password-error" class="error" for="confirm_password"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1 text-center">
                                <button type="submit" class="btn btn-signin">Change Password</button>
                            </div>
                        </div>
                    </form>
                    <p class="mt-2 mb-1 text-right">
                        <a href="{{route('login')}}" class="or_forgot_btn">Login</a>
                    </p>        
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
<script src="{{asset('assets/validation/js/jquery.validate.min.js')}}"></script>
{{-- <script src="{{asset('assets/validation/js/jquery_validation.js')}}"></script> --}}

<script>
   
    $("#reset_password_form").validate({
        ignore: "not:hidden",
        onfocusout: function(element) {
            this.element(element);  
        },
        rules: {
            "password":{
                required:true,
                minlength:6,
            },
            "confirm_password":{
                equalTo:'#password',
            },
        },
        messages:{
            "password":{
                required:'Please enter password',
                minlength:'Please password must be 6 character',
            },
            "confirm_password":'Password and re-type password must match',
        },
        submitHandler: function(form) {
            var $this = $('.loader_class');
            var loadingText = '<i class="fa fa-spinner fa-spin" role="status" aria-hidden="true"></i> Loading...';
            $('.loader_class').prop("disabled", true);
            $this.html(loadingText);
            form.submit();
        },
    });

</script>
@endsection

