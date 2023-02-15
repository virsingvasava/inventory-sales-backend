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
                <th>Status</th>
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
                    @if ($value->status == 1)
                    <span class="badge" style="color:green">Active</span>
                    @else
                    <span class="badge inactive" style="color:#f0ad4e">Inactive</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{route('airport_manager.city_users.view', $value->id)}}" data-toggle="tooltip" title="Are you sure to View Details ? ">
                        <img src="{{ asset('theme/images/view.png')}}" />
                    </a>

                    <a class="edit_icon" href="{{route('airport_manager.city_users.edit', $value->id)}}" data-toggle="tooltip" title="Are you sure to edit Details ? ">
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