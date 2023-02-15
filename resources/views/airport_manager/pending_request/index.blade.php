@extends('layouts.app_admin')

@section('title')
    {{ 'Dashboard' }}
@endsection

@section('content')

    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="title-w-arrow">
                <a href="{{ route('airport_manager.dashboard.index') }}">
                    <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
                </a>
                <h1 class="mr20 back_title_text">Pending Request</h1>
                <div class="search-box" style="display:none">
                    <img class="search-user" src="{{ asset('theme/images/search-icon.png') }}">
                    <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
                </div>
            </div>
            <div class="city-sec"></div>
            <div class="common-table-sec um-table">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-header pr-theader">
                            <div class="droupdown-select" style="display:none">
                                <select class="form-control">
                                    <option>Pending</option>
                                    <option>Inactive</option>
                                </select>
                            </div>
                            <div class="droupdown-select" style="display:none">
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
                                <table class="table" id="pending_request_table">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 5%;">Sr.No</th>
                                            <th>User Id</th>
                                            <th>User Name</th>
                                            <th>Email Id</th>
                                            <th>Role</th>
                                            <th>City</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    @if (!empty($requestArray) && count($requestArray) > 0)
                                        @foreach ($requestArray as $key => $value)
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">{{ $key + 1 }}</td>
                                                    <td>{{ $value->user_id }}</td>
                                                    <td>{{ $value->name }}</td>
                                                    <td>{{ $value->email }}</td>
                                                    <td>
                                                        @if ($value->role_id == AIRPORT_MANAGER)
                                                            @php echo "Airport Manager"; @endphp
                                                        @elseif($value->role_id == BRANCH_MANAGER)
                                                            @php echo "Branch Manager"; @endphp
                                                        @elseif($value->role_id == HO)
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
                                                        <div class="grey-droupdown">
                                                            <label class="switch">
                                                                <input type="checkbox" id="togBtn"
                                                                    {{ $value->status == 1 ? 'checked' : '' }}>
                                                                <div class="status_check slider round"
                                                                    data-id="{{ $value->id }}"
                                                                    data-status="{{ $value->status }}">
                                                                    <span class="on">Active</span>
                                                                    <span class="off">Pending</span>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="10">Pending Request Not Found</td>
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
    <script src="{{ asset('assets/validation/plugins/jquery/jquery.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.status_check').click(function() {
                let status = $(this).prop('checked') === true ? 1 : 0;
                let req_userId = $(this).data('id');
                let req_status = $(this).data('status');
                var token = "{{ csrf_token() }}";

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: '{{ route("airport_manager.pending_request.user_status_update") }}',
                    data: {
                        'status': status,
                        'req_status': req_status,
                        'req_userId': req_userId,
                        _token: token
                    },
                    success: function(data) {
                        console.log(data.message);
                    }
                });
            });
        });
    </script>
    <style>
        .switch1 {
            position: relative;
            display: inline-block;
            width: 90px;
            height: 34px;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 80px;
            height: 26px;
        }

        .switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ca2222;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider1:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2ab934;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(55px);
            -ms-transform: translateX(55px);
            transform: translateX(55px);
        }

        /*------ ADDED CSS ---------*/
        .on {
            display: none;
        }

        .on1,
        .off2 {
            color: white;
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 50%;
            font-size: 10px;
            font-family: Verdana, sans-serif;
        }

        .on,
        .off {
            color: white;
            position: absolute;
            transform: translate(-50%, -50%);
            top: 50%;
            left: 60%;
            font-size: 12px;
            font-family: Verdana, sans-serif;
        }

        input:checked+.slider .on {
            display: block;
            transform: translate(-80%, -50%);
        }

        input:checked+.slider .off {
            display: none;
        }

        /*--------- END --------*/

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
@endsection
