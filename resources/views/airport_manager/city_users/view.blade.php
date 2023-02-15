@extends('layouts.app_admin')

@section('title')
    {{ 'View' }}
@endsection

@section('content')

<div class="main-content-part">
    <div class="main-content-padd">
       <div class="title-w-arrow">
          <a href="{{route('airport_manager.city_users.index')}}">
            <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
          </a>
         <h1 class="mr20 back_title_text">User Profile</h1>
       </div>
       <div class="d-block w-100 mt-5">
          <div class="row">
             <div class="col-md-12">
                <div class="user-profile-sec-main">
                   <div class="user-profile-img">
                        @if($view->profile_img != '' && file_exists(public_path('assets/profile_picture/'.$view->profile_img)))
                            <img width="129px" height="149px" src="{{asset('assets/profile_picture/'.$view->profile_img)}}"/>
                        @else
                            <img src="{{asset('theme/images/small-profile-pic.png')}}"/>
                        @endif 
                    </div>
                   <div class="user-profile-sec">
                      <div class="profile-title">
                         <h3>{{$view->name}}</h3>
                         <span>/ {{$view->user_id}}</span>
                            @if($view->status == TRUE)
                                <a href="javascript:void(0)" class="badge green">Active</a>
                            @else 
                                <span style="color:red;">InActive</span> 
                            @endif
                      </div>
                      <div class="emp-deg">
                         <p>Sales Man, <span>New Delhi</span></p>
                         <p><span>Employee Since</span> {{$view->date_of_joining}}</p>
                      </div>
                      <div class="emp-detail">
                         <p><span>Email Id:</span> <a href="mailto:{{$view->email}}">{{$view->email}}</a></p>
                         <p><span>Phone No.:</span> <a href="tel:{{$view->mobile}}">+91 {{$view->mobile}}</a></p>
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
                      <h3><span>₹</span>{{$total_sale}}</h3>
                      <div class="year-sales"><span class="budge">
                         <img src="{{asset('theme/images/white-arrow-up.png')}}" />{{$percent_from}}%</span> vs Last Year
                      </div>
                   </div>
                   <div class="c-block">
                      <div class="card-title">Average Monthly Sale</div>
                      <h3><span>₹</span>{{$average_monthly_sale}}</h3>
                      <div class="year-sales"><span class="budge">
                         <img src="{{asset('theme/images/white-arrow-up.png')}}" />{{$percent_from}}%</span> vs Last Year
                      </div>
                   </div>
                   <div class="c-block">
                      <div class="card-title">Total Login Session</div>
                      <h3>{{$total_login_session}}</h3>
                   </div>
                   <div class="c-block">
                      <div class="card-title">Pack Sold</div>
                      <h3>{{$pack_sold}}</h3>
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
                      <table class="table">
                         <thead>
                            <tr>
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
                         @if(!empty($sales_history) && count($sales_history) > 0)
                            @foreach($sales_history as $key => $value)
                                <tbody>
                                    <tr>
                                    <td>{{$value->created_at}}</td>
                                    <td><span class="clr-g">P (?)</span></td>
                                    <td>12pm-6am (?)</td>
                                    <td>{{$value->kiosk_id}}</td>
                                    <td>Domestic (?)</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>{{$value->total_amount}}</td>
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
