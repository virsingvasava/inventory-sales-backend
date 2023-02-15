<?php 
      $route_name = \Request::route()->getName(); 
      $logged_user = \Auth::User();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
    {{-- <title>Inventory - @yield('title')</title> --}}
    <title> @yield('title')</title>
    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/nice-select.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/morris.css') }}">
    <link href="{{ asset('theme/css/style.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/validation/css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/validation/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/validation/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">


    <script type="text/javascript">
        var SITE_URL = '{{URL::to('/')}}'
    </script>

</head>

<body>
    
    <div class="l-navbar" id="nav-bar">
        <div class="profile-sec">
           <div class="pro-img">
            @if ($logged_user->role == 1)
                <a href="{{route('admin.settings.profile')}}">
                @if($logged_user->profile_img != '' && file_exists(public_path('assets/profile_picture/'.$logged_user->profile_img)))
                <img id="profile-img" class="img-profile rounded-circle"
                    src="{{asset('assets/profile_picture/'.$logged_user->profile_img)}}" alt="Profile Picture">
                @else
                {{-- <img id="profile-img" src="{{asset('users/avatar.png')}}" alt="Profile Picture" class="img-profile rounded-circle" /> --}}
                <img class="profile-img" src="{{ asset('theme/images/user-sagar.png') }}" alt="User-Profile-Image">
                @endif

                </a>
            @else
                <a href="{{route('airport_manager.profile.index')}}">
                    
                @if($logged_user->profile_img != '' && file_exists(public_path('assets/profile_picture/'.$logged_user->profile_img)))
                <img id="profile-img" class="img-profile rounded-circle"
                    src="{{asset('assets/profile_picture/'.$logged_user->profile_img)}}" alt="Profile Picture">
                @else
                {{-- <img id="profile-img" src="{{asset('users/avatar.png')}}" alt="Profile Picture" class="img-profile rounded-circle" /> --}}
                <img class="profile-img" src="{{ asset('theme/images/user-sagar.png') }}" alt="User-Profile-Image">
                @endif

            </a>

            @endif
            </div>

            <div class="user-details">
                {{$logged_user->name}}<span class="ud-des">Designation</span>
            </div>
        </div>
        @include('partials.sidebar')
    </div>



