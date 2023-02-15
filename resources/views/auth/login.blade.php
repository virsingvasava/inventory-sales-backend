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
                            {{-- <div class="title-w-arrow">
                                <h1 class="login-box-msg">ITC Sign In</h1>
                            </div> --}}

                            @if(Session::has("success"))
                            <div class="alert alert-success">
                                {{Session::get("success")}}
                            </div>
                            @elseif(Session::has("failed")) 
                                {{Session::get("failed")}}
                            @endif

                            <div class="photo-upload-sec">
                                <figure><img src="{{ asset('assets/img/sample_logo.png') }}" /></figure>
                            </div>
                        </div>
                    </div>
                    <form action="{{ route('login.submit') }}" method="post" id="or_login_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="from-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="from-group ">
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                    @if ($errors->has('password'))
                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mt-1 text-center">
                                <button type="submit" class="btn btn-signin">Sign In</button>
                            </div>
                        </div>
                    </form>
                    <p class="mt-2 mb-1 text-right">
                        <a href="{{route('forgot_password')}}" class="or_forgot_btn">Forgot Password?</a>
                    </p>        
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript" src="{{ asset('theme/js/jquery.min.js') }}"></script>
<script src="{{asset('assets/validation/js/jquery.validate.min.js')}}"></script>
{{-- <script src="{{asset('assets/validation/js/jquery_validation.js')}}"></script> --}}

<script>

    $("#or_login_form").validate({
        ignore: "not:hidden",
        onfocusout: function(element) {
            this.element(element);  
        },
        rules: {
            "email":{
                required:true,
                email:true,
            },
            "password":{
                required:true,
                minlength:6,
            },
        },
        messages: {
            "email":{
                required:'Please enter email address',
                email:'Please enter valid email address',
            },
            "password":{
                required:'Please enter password',
                minlength:'Password must be more then 6 characters',
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

