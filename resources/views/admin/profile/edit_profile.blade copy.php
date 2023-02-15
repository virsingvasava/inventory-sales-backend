@extends('layouts.app_admin')
@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800">Edit Profile</h1>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"> Edit Profile Details</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-default">
                        <form action="{{route('admin.profile.update')}}" method="post" id="edit_profile" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>First Name</label>
                                            <input type="text" class="form-control" name="first_name" value="{{$user_detail->first_name}}" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Last Name</label>
                                            <input type="text" value="{{$user_detail->last_name}}" class="form-control" name="last_name" placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="text" value="{{$user_detail->email}}" class="form-control" placeholder="E-Mail" readonly="readonly">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Phone Number</label>
                                            <input type="text" value="{{$user_detail->phone_number}}" class="form-control" name="phone_number" placeholder="Phone Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Profile Image</label><br>
                                            <input type="file" class="image" onclick="imageUpload()" name="image" accept="image/*" id="upload" hidden/><label class="image_upload_btn" for="upload">Choose file</label><br><br>
                                            @if($user_detail->profile_picture_name != '' && file_exists(public_path('users/'.$user_detail->profile_picture_name)))
                                            <img id="image_preview" src="{{asset('users/'.$user_detail->profile_picture_name)}}" height="100" width="100" />
                                            @else
                                             <img style="display: none;" src="#" alt="Restaurant Image" height="100" width="100" />
                                            @endif 
                                        </div>                                   
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="card-footer">
                                        <a href="{{route('admin.dashboard')}}" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm btn_loader">Cancel</a>
                                        <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm loader_class">Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript">

    $(document).on('change','.image',function(){
        var class_name = "image_preview";
        $('#'+class_name).hide();
        readURL(this,class_name);
    });
    function readURL(input,class_name) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#'+class_name).attr('src', e.target.result);
                $('#'+class_name).show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    function imageUpload() {
         document.getElementById("image").click();
    }
</script>
@endsection