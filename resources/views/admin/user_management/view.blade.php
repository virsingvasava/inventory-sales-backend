@extends('layouts.app_admin')

@section('title')
    {{ 'View' }}
@endsection

@section('content')

    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <a href="{{ route('admin.user_management.index') }}">
                    <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
                </a>
                <h1 class="mr20 back_title_text">User Profile</h1>
            </div>
            <div class="d-block w-100 mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="user-profile-sec-main">
                            <div class="user-profile-img">
                                @if ($view->profile_img != '' && file_exists(public_path('assets/profile_picture/' . $view->profile_img)))
                                    <img width="129px" height="149px"
                                        src="{{ asset('assets/profile_picture/' . $view->profile_img) }}" />
                                @else
                                    <img src="{{ asset('theme/images/small-profile-pic.png') }}" />
                                @endif
                            </div>
                            <div class="user-profile-sec">
                                <div class="profile-title">
                                    <h3>{{ $view->name }}</h3>
                                    <span>/ {{ $view->user_id }}</span>
                                    @if ($view->status == true)
                                        <a href="javascript:void(0)" class="badge green">Active</a>
                                    @else
                                        <span style="color:red;">InActive</span>
                                    @endif
                                </div>
                                <div class="emp-deg">
                                    @foreach ($view_details as $city)
                                        <p>
                                            @if ($city->role == ADMIN_ROLE)
                                                Admin
                                            @elseif($city->role == AIRPORT_MANAGER)
                                                Airport Manager
                                            @elseif($city->role == BRANCH_MANAGER)
                                                Branch Manager
                                            @elseif($city->role == HO)
                                                HO
                                            @elseif($city->role == SALESMAN)
                                                Salesman
                                            @endif

                                            <span>
                                                @foreach ($city->city_name as $city_name)
                                                    {{ $city_name->name }}
                                                @endforeach
                                            </span>
                                        </p>
                                    @endforeach

                                    @php
                                        $date_of_joining = date('d-m-Y', strtotime($view->date_of_joining));
                                    @endphp

                                    <p><span>Employee Since :</span> {{ $date_of_joining }} </p>
                                </div>
                                <div class="emp-detail">
                                    <p><span>Email Id:</span> <a href="mailto:{{ $view->email }}">{{ $view->email }}</a>
                                    </p>
                                    <p><span>Phone No.:</span> <a href="tel:{{ $view->mobile }}">+91
                                            {{ $view->mobile }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block w-100 mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="salse-whitebox">
                            <div class="c-block">
                                <div class="card-title">Total Sale</div>
                                <h3><span>₹</span>{{ $total_sale }}</h3>
                                <div class="year-sales"><span class="budge">
                                        <img
                                            src="{{ asset('theme/images/white-arrow-up.png') }}" />{{ $percent_from }}%</span>
                                    vs Last Year
                                </div>
                            </div>
                            <div class="c-block">
                                <div class="card-title">Average Monthly Sale</div>
                                <h3><span>₹</span>{{ $average_monthly_sale }}</h3>
                                <div class="year-sales"><span class="budge">
                                        <img
                                            src="{{ asset('theme/images/white-arrow-up.png') }}" />{{ $percent_from }}%</span>
                                    vs Last Year
                                </div>
                            </div>
                            <div class="c-block">
                                <div class="card-title">Total Login Session</div>
                                <h3>{{ $total_login_session }}</h3>
                            </div>
                            <div class="c-block">
                                <div class="card-title">Pack Sold</div>
                                <h3>{{ $pack_sold }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wbgw-table-sec mt-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-border-style">
                            <div class="table-responsive">
                                <table class="table" id="usersSales">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%;">Sr.No</th>
                                            <th>Day</th>
                                            <th>Attendence</th>
                                            <th>Time Slot</th>
                                            <th>Kiosk</th>
                                            <th>Terminal</th>
                                            <th>Pack Sold</th>
                                            <th>Transaction</th>
                                            <th class="text-right">Total Sale</th>
                                        </tr>
                                    </thead>
                                    @if (!empty($sales_history) && count($sales_history) > 0)
                                        @foreach ($sales_history as $key => $value)
                                            <tbody>
                                                <tr>
                                                    @php
                                                        $kiosk_data =   App\Models\Kiosk::where('id', $value->kiosk_id)->first();
                                                        $loginTime = isset($value->login_at) ?  date('h:i A', strtotime($value->login_at)) : false;
                                                        $logoutTime = isset($value->logout_at) ? date('h:i A', strtotime($value->logout_at)) : false
                                                    @endphp
                                                    <td class="text-center">#{{ $key + 1 }}</td>
                                                    <td>{{ $value->created_at->format('j F Y') }}</td>
                                                    <td>
                                                        @if (Auth::check())
                                                            <span class="clr-g">P</span>
                                                        @else
                                                            <span style="color:red">A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!empty($loginTime) && !empty($logoutTime))
                                                            <span>{{$loginTime}}</span>
                                                            <span>-</span>
                                                            <span>{{$logoutTime}}</span>         
                                                        @else
                                                            {{ $loginTime && $logoutTime ? $logoutTime : "-" }}
                                                        @endif                     
                                                    </td>
                                                    <td>{{ $kiosk_data->kiosk_id }}</td>
                                                    <td>{{ $kiosk_data->kiosk_name }}</td>
                                                    <td>{{ $value->pack_sold }}</td>
                                                    <td>{{$value->transaction_order_count}}</td>
                                                    <td>{{ $value->total_sale }}</td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">Sales Datails Not Found</td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="h30"></div>
        </div>
    </div>
@endsection
