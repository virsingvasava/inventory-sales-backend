<div class="table-responsive">
    <table class="table" id="kiosk_table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">Sr.No</th>
                <th>Kiosk ID</th>
                <th>Kiosk Name</th>
                <th>Location</th>
                <th>City</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        @if (!empty($kiosk_obj) && count($kiosk_obj) > 0)
            @foreach ($kiosk_obj as $key => $value)
                <tbody>
                    <tr>
                        <td class="text-center">#{{ $key + 1 }}</td>
                        <td>{{ $value->kiosk_id }}</td>
                        <td>{{ $value->kiosk_name }}</td>
                        <td>
                            @if (!empty($value['outlet_location']))
                                @foreach ($value['outlet_location'] as $location)
                                    {{ $location->name }}
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if (!empty($value['city_name']))
                                @foreach ($value['city_name'] as $city)
                                    {{ $city->name }}
                                @endforeach
                            @endif
                        </td>
                        <td>
                            @if ($value->status == 1)
                                <span class="badge" style="color:green">Active</span>
                            @else
                                <span class="badge inactive" style="color:#f0ad4e">Inactive</span>
                            @endif
                        </td>
                        <td class="text-center">

                            <a style="display:none" href="{{ route('admin.kiosk.view', $value->id) }}"
                                data-toggle="tooltip" title="Are you sure to View Details ? ">
                                <img src="{{ asset('theme/images/view.png') }}" />
                            </a>

                            <a class="edit_icon" href="{{ route('admin.kiosk.edit', $value->id) }}"
                                data-toggle="tooltip" title="Are you sure to edit Details ? ">
                                <img src="{{ asset('theme/images/icon-edit.png') }}" />
                            </a>

                            <a class="delete_button" href="javascript:;" data-id="{{ $value->id }}"
                                data-toggle="tooltip" title="Are you sure to Delete User ?">
                                <img src="{{ asset('theme/images/delete.png') }}" />
                            </a>

                        </td>
                    </tr>
                </tbody>
            @endforeach
        @else
            <tr>
                <td colspan="10">Kiosk Not Found</td>
            </tr>
        @endif
    </table>
</div>
