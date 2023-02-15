<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />
    <title>@yield('title')</title>
    <link href="{{ asset('theme/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('theme/css/nice-select.css') }}" type="text/css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/css/morris.css') }}">
    <link href="{{ asset('theme/css/style.css') }}" type="text/css" rel="stylesheet">
    <link href="{{ asset('assets/css/login_custom.css') }}" type="text/css" rel="stylesheet">
    <script src="{{asset('assets/validation/js/jquery.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/validation/css/toastr.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/validation/css/toastr.min.css')}}">

    <script type="text/javascript">
        var SITE_URL = '{{URL::to('/')}}'
    </script>
</head>
<body class="salesman_regi">
    