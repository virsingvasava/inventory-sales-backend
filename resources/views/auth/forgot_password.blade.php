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
                                <p class="text-center">You forgot your password? Here you can easily retrieve a new password.</p>
                            </div>
                            <div class="photo-upload-sec">
                                <figure><img src="{{ asset('assets/img/sample_logo.png') }}" /></figure>
                            </div>
                        </div>
                    </div>
                    <form action="{{route('forgot_password.submit')}}" method="post" id="forgot_password_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="from-group">
                                    <input type="email" name="email" value="{{old('email')}}" class="form-control" placeholder="Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1 text-center">
                                <button type="submit" class="btn btn-signin">Request New Password</button>
                            </div>
                        </div>
                    </form>
                    <p class="mt-2 mb-1 text-right">
                        <a href="{{route('login')}}" class="or_forgot_btn">Sign In ?</a>
                    </p>        
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
<script src="{{asset('assets/validation/js/jquery.validate.min.js')}}"></script>
{{-- <script src="{{asset('assets/validation/js/jquery_validation.js')}}"></script> --}}

<script>
    $("#forgot_password_form").validate({
        ignore: "not:hidden",
        onfocusout: function(element) {
            this.element(element);  
        },
        rules: {
            "email":{
                required:true,
                email:true,
                emailCheck:true,
            },
        },
        messages: {
            "email":{
                required:'Please enter email address',
                email:'Please enter valid email address',
                emailCheck:'Please enter valid email address',
            },
        },
        submitHandler: function(form) {
            var $this = $('.loader_class');
            var loadingText = '<i class="fa fa-spinner fa-spin" role="status" aria-hidden="true"></i> Loading...';
            $('.loader_class').prop("disabled", true);
            $this.html(loadingText);
            form.submit();
        }
    });

</script>
@endsection

