@extends('layouts.app_admin')

@section('title') 
    {{'Edit'}}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
       <div class="title-w-arrow">
          <span><img src="images/grey-big-arrow.png"/></span>
          <h1 class="mr20">Sagar Gupta</h1>
          <a href="#" class="badge green">Active</a>
       </div>
       <div class="profile-main-sec">
          <div class="row mt-5">
             <div class="col-md-2">
                <div class="photo-upload-sec">
                   <figure><img src="images/profile-pic.png"/></figure>
                   <button type="submit" class="upload-btn">Upload</button>
                </div>
             </div>
             <div class="col-md-10">
                <div class="from-group w100">
                   <label>Admin Name</label>
                   <input type="text" name="admin name" />
                </div>
                <div class="row">
                   <div class="col-md-4">
                      <div class="from-group">
                         <label>Admin Id</label>
                         <input type="text" name="admin id" />
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="from-group">
                         <label>Phone No.</label>
                         <input type="text" name="phone no" />
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="from-group">
                         <label>Email Id</label>
                         <input type="text" name="email id" />
                      </div>
                   </div>
                </div>
                <div class="row">
                   <div class="col-md-4">
                      <div class="from-group">
                         <label>Role</label>
                         <div class="droup-select">
                            <select class="form-control">
                               <option>Role</option>
                               <option>Salse Man</option>
                               <option>Project Manager</option>
                               <option>Other</option>
                            </select>
                         </div>
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="from-group">
                         <label>Date of Joining</label>
                         <input type="date" name="date of joining" />
                      </div>
                   </div>
                   <div class="col-md-4">
                      <div class="from-group">
                         <label>Status</label> 
                         <div class="droup-select">
                            <select class="form-control">
                               <option>Active</option>
                               <option>Inactive</option>
                            </select>
                         </div>
                      </div>
                   </div>
                </div>
                <div class="from-group w100 button-sec">
                   <a href="#" class="save">Save</a><span></span><a href="#" class="done">Done</a>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div> 
@endsection