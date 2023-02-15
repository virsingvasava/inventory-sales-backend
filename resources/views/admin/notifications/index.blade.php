@extends('layouts.app_admin')

@section('title')
{{ 'index' }}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <h1 class="mr20">Notification</h1>
            <div class="search-box" style="display:none">
                <img class="search-user" src="{{ asset('theme/images/search-icon.png') }}">
                <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
            </div>
        </div>

        <div class="common-table-sec um-table">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-header" style="display:none">
                        <div class="droupdown-select">
                            <select name="status" id="status" class="form-control custom-control">
                                <option value="">Select status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="droupdown-select">
                            <select class="form-control">
                                <option>All Cities</option>
                                <option>Baroda</option>
                                <option>Mumbai</option>
                                <option>Bhopal</option>
                            </select>
                        </div>
                    </div>
                    <div class="table-border-style">
                        <div class="table-responsive">
                            <table class="table" id="notification_table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%;">Sr.No</th>
                                        <th>Subject</th>
                                        <th>Dated</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($notification) && count($notification) > 0)
                                    @foreach ($notification as $key => $val)
                                    <?php
                                    if ($val->status == '0') {
                                    ?>
                                        <tr class="pending-active" style="background-color: #F4F3FB;">
                                            <td class="text-center">{{$key+1}}</td>
                                            <td>{{$val->message}}</td>
                                            <td>{{ \Carbon\Carbon::parse($val->created_at)->format('d/m/Y H:i:s A')}}</td>
                                        </tr>
                                    <?php
                                    } else {
                                    ?>
                                        <tr>
                                            <td class="text-center">#{{$key+1}}</td>
                                            <td>{{$val->message}}</td>
                                            <td>{{ \Carbon\Carbon::parse($val->created_at)->format('d/m/Y H:i:s A')}}</td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5">Notification Not Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endsection