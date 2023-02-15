@extends('layouts.app_admin')

@section('title') 
    {{'Profile Update'}}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
       <form action="{{route('salesman.profile.profile_update')}}" enctype="multipart/form-data" method="POST" id="profile_update">
         @csrf
         <div class="title-w-arrow">
            <a href="{{route('salesman.dashboard.index')}}">
               <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
           </a>
           <h1 class="mr20 back_title_text">{{$user_detail->name}}</h1>
          <a href="javascript:void(0)" class="badge green">Active</a>
         </div>
         <div class="profile-main-sec">
            <div class="row mt-5">
               <div class="col-md-2">
                  <div class="photo-upload-sec">
                     @if($user_detail->profile_img != '' && file_exists(public_path('assets/profile_picture/'.$user_detail->profile_img)))
                     
                         <figure><img id="current_login_user_picture" src="{{asset('assets/profile_picture/'.$user_detail->profile_img)}}" /></figure>
                     @else
                         <figure><img id="current_login_user_picture" src="{{ asset('theme/images/profile-pic.png') }}" /></figure>
                     @endif 

                     <div class="upload-btn-wrapper">
                         <input type='file' onchange="readURL3(this);" name="profile_picture">
                         <button class="btn btn_file_upload">Upload a file</button>
                         <label id="profile_picture-error" class="error" for="profile_picture"></label>
                     </div>
                 </div>
               </div>
               <div class="col-md-10">
                  <div class="from-group w100">
                     <label>Admin Name</label>
                     <input type="text" name="name" value="{{$user_detail->name}}">
                     @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                     @endif
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Admin Id</label>
                           <input type="text" name="admin_id" value="{{$user_detail->user_id}}"  readonly>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Phone No.</label>
                           <input type="text"  name="mobile" value="{{$user_detail->mobile}}">
                           @if ($errors->has('mobile'))
                              <span class="text-danger">{{ $errors->first('mobile') }}</span>
                           @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Email Id</label>
                           <input type="text" name="email" value="{{$user_detail->email}}" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Role</label>
                           <div class="droup-select">
                              <input type="hidden" name="role_id" value="{{$roleId}}"/>
                              <select class="form-control nice-select" name="role_id" disabled>
                                 <option value="">Role</option>
                                 <option  @if($role == 2) selected="selected" @endif value="{{ AIRPORT_MANAGER }}">Airport Manager</option>
                                 <option  @if($role == 3) selected="selected" @endif value="{{ BRANCH_MANAGER }}">Branch Manager</option>
                                 <option  @if($role == 4) selected="selected" @endif value="{{ HO }}">HO</option>
                                 <option  @if($role == 5) selected="selected" @endif value="{{ SALESMAN }}">Salesman</option>
                             </select>
                              <label id="role_id-error" class="error" for="role_id"></label>
                          </div>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Date of Joining</label>
                              <input type="date" name="date_of_joining" value="{{$user_detail->date_of_joining}}" readonly>
                              @if ($errors->has('date_of_joining'))
                                 <span class="text-danger">{{ $errors->first('date_of_joining') }}</span>
                              @endif
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="from-group">
                           <label>Status</label> 
                           <div class="droup-select">
                              <select class="form-control custom-select nice-select" name="status" disabled>
                                 <option value="">Select Status</option>
                                 <option @if($user_detail->status == 1) selected="selected" @endif value="1">Active</option>
                                 <option @if($user_detail->status == 0) selected="selected" @endif value="0">InActive</option>
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
         </div>
      </form>
    </div>
 </div> 
@endsection

