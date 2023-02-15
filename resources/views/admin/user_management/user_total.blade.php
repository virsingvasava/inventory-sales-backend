@extends('layouts.app_admin')

@section('title')
{{ 'index' }}
@endsection

@section('content')
<div class="main-content-part">
    <div class="main-content-padd">
        <div class="title-w-arrow">
            <h1 class="mr20">User Management</h1>
            <div class="search-box" style="display:none">
                <img class="search-user" src="{{ asset('theme/images/search-icon.png') }}">
                <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
            </div>
        </div>
        <div class="common-table-sec um-table">
            <div class="row">
                <div class="col-sm-12">
                    @include('partials.login.toastr')
                </div>

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
                        <!--  -->
                        <div class="table-responsive">
                            <table class="table" id="user_table">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="width: 5%;">Sr.No</th>
                                        <th>User Id</th>
                                        <th>User Name</th>
                                        <th>Email Id</th>
                                        <th>Role</th>
                                        <th>City</th>
                                        <th></th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($user_obj) && count($user_obj) > 0)
                                    @foreach ($user_obj as $key => $value)
                                    <tr>
                                        <td class="text-center">{{$key+1}}</td>
                                        <td>{{ $value->user_id }}</td>
                                        <td>{{ $value->name }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>
                                            @if($value->role_id == AIRPORT_MANAGER)
                                            @php echo "Airport Manager"; @endphp
                                            @elseif($value->role_id == BRANCH_MANAGER)
                                            @php echo "Branch Manager"; @endphp
                                            @elseif( $value->role_id == HO)
                                            @php echo "HO"; @endphp
                                            @elseif($value->role_id == SALESMAN)
                                            @php echo "Salesman"; @endphp
                                            @endif
                                        </td>
                                        <td>
                                            @foreach ($value->city_name as $key => $city)
                                            {{ $city->name }}
                                            @endforeach
                                        </td>
                                        <td>

                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('admin.user_management.view', $value->id)}}" data-toggle="tooltip" title="Are you sure to View Details ? ">
                                                <img src="{{ asset('theme/images/view.png')}}" />
                                            </a>

                                            <a class="edit_icon" href="{{route('admin.user_management.edit', $value->id)}}" data-toggle="tooltip" title="Are you sure to edit Details ? ">
                                                <img src="{{ asset('theme/images/icon-edit.png')}}" />
                                            </a>

                                            <a class="delete_button" href="javascript:;" data-id="{{$value->id}}" data-toggle="tooltip" title="Are you sure to Delete User ?">
                                                <img src="{{ asset('theme/images/delete.png')}}" />
                                            </a>

                                        </td>

                                        @endforeach
                                        @else
                                    <tr>
                                        <td colspan="10">User Not Found</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!--  -->
                    </div>
                </div>
            </div>
        </div>
        <div class="h30"></div>
    </div>
</div>

<div class="modal fade" id="deleteModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;">Are you sure to Delete User ?</h5>
                <form action="{{ route('admin.user_management.destroy') }}" method="POST">
                    @csrf
                    <input type="hidden" name="userId" class="userId">

                    <div class="modal-footer">
                        <button type="button" class="d-sm-inline-block btn btn-sm btn-info" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="importDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Import Users ?</h5>
                <form action="{{ route('admin.user_management.import') }}" method="POST" id="users_import" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="users_import">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Import</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exportUserDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Users ?</h5>
                <form action="{{ route('admin.user_management.export_user_listing_data') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="export_kiosk_data">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_export">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>

<script type="text/javascript">
    $(document).on('click', '.import_data_btn', function() {
        $('#importDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })

    $(document).on('click', '.export_data_btn', function() {
        $('#exportDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })


    $(document).on('click', '.export_user_management_data_btn', function() {
        $('#exportUserDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })

    $(document).on('click', '.hide_after_export', function() {
        $('#exportUserDataModel').modal('hide');
        toastr.success('Export Users Successfully Export.');
    })

    $("#users_import").validate({
        ignore: "not:hidden",
        onfocusout: function(element) {
            this.element(element);
        },
        rules: {

            "users_import": {
                required: true,
            },
        },
        messages: {

            "users_import": {
                required: 'Please choose file for Import Users.',
            },
        },
        submitHandler: function(form) {
            var $this = $('.loader_class');
            var loadingText =
                '<i class="fa fa-spinner fa-spin" role="status" aria-hidden="true"></i> Loading...';
            $('.loader_class').prop("disabled", true);
            $this.html(loadingText);
            form.submit();
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#kiosk_table').DataTable();
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.delete_button', function() {
        $('#deleteModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })
</script>

<script type="text/javascript">
    $(document).on('change', '#status', function() {
        let status = $(this).val();
        alert(status)
        var token = "{{csrf_token()}}";
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "{{url('admin/user-management/status_filter')}}?" + 'status=' + status,
            data: {
                'status': status,
                _token: token
            },
            success: function(data) {
                $('.table-border-style').html(data);
            }
        });
    });
</script>
@endsection