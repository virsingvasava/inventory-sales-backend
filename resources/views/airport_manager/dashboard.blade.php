@extends('layouts.app_admin')
@section('title','Dashboard')
@section('content')

    <div class="main-content-part">
        <div class="main-content-padd">
            <div class="dashboard-title">
                <h1><span> {{ $greeting_message }} , </span> {{ $user_detail->name }} !</h1>
                <div class="search-box">
                    <img class="search-user" src="{{ asset('theme/images/search-icon.png') }}">
                    <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
                </div>
            </div>
            <div class="dashboard-top-sec">
                <div class="row text-right">
                    <div class="col-md-12">
                        <div class="d-badge-sec">
                            <a href="#" class="badge">1D</a><a href="#" class="badge">1W</a><a href="#"
                                class="badge">1M</a><a href="#" class="badge active">1Y</a>
                        </div>
                        {{-- <div class="city-droupdown">
                        <select class="form-control">
                            <option>All Cities</option>
                            <option>Baroda</option>
                            <option>Mumbai</option>
                            <option>Bhopal</option>
                        </select>
                    </div> --}}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card pink-bg">
                        <div class="card-block salse-block">
                            <div class="card-header">
                                <figure>
                                    <img src="{{ asset('theme/images/icon-salse.png') }}" />
                                </figure>
                                <div class="card-title">
                                    <h3>Sales</h3>
                                </div>
                            </div>
                            <div class="card-footer">
                                <h4>{{ $requestedQuentity }} <span>Packs Sold</span></h4>
                                <!-- <div class="year-sales"><span class="budge"><img
                                            src="{{ asset('theme/images/white-arrow-up.png') }}" />20.7%</span> vs Last Year
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card green-bg">
                        <div class="card-block inven-block">
                            <div class="card-header">
                                <figure>
                                    <img src="{{ asset('theme/images/icon-inventory.png') }}" />
                                </figure>
                                <div class="card-title">
                                    <h3>Inventory</h3>
                                </div>
                            </div>
                            <div class="card-footer">
                                <h4>{{ $requestedStock }}</h4>
                                <p>Stores have <span>less stock</span> than expected quantity</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card purple-bg">
                        <div class="card-block kiosku-block">
                            <div class="card-header">
                                <figure>
                                    <img src="{{ asset('theme/images/icon-kioskusers.png') }}" />
                                </figure>
                                <div class="card-title">
                                    <a href="{{route('airport_manager.city_users.index')}}"><h3>Kiosk Users</h3></a>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="tuser">
                                    <span>Total Users</span>
                                    <h4>{{ $totalUsersCount }}</h4>
                                </div>
                                <div class="auser">
                                    <span>Active Users</span>
                                    <h4>{{ $activatedUserCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dashboard-chart">
                <div class="row">
                    <div class="col-sm-12">
                        <h3>Sale by Brand</h3>
                        <div id="bar-chart"></div>
                        <div class="d-block w-100 text-center">
                            <div class="brand-label-sec">
                                <div class="last-year"><span class="ly-bg"></span>Last Year</div>
                                <div class="last-year"><span class="cy-bg"></span>Current Year</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="brand-box-sec">
                <div class="row">
                    @if (!empty($SoldBrands) && count($SoldBrands) > 0)
                        @foreach ($SoldBrands as $key => $value)
                            <div class="col-md-3">
                                <div class="brand-box-inr">
                                    <h4>{{ $value['name'] }}</h4>
                                    <div class="bb-left-part">
                                        @if ($value['percentage'] != 0)
                                            <span class="budge"><img src="{{ asset('theme/images/green-arrow-up.png') }}">{{ $value['percentage'] }}%</span>
                                        @else
                                            <span class="budge">-</span>
                                        @endif
                                        <h3>{{ $value['sold_items'] }}</h3>
                                        <p>Pack Sold</p>
                                    </div>
                                    <div class="bb-right-part">
                                        <img src="{{ asset('theme/images/small-chart.png') }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="dashboard-table-sec">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Sales by Quarter</h3>
                                <div class="card-header-right">
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle" type="button" id="dropdownMenuClickableInside"
                                            data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                            <img src="{{ asset('theme/images/dot-img.png') }}" alt=""></button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuClickableInside">
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block sbquarter">
                                <div class="card-title">Total Sale</div>
                                <h3><span class="icon-rupee">₹</span>{{ $quarterArr['totalYearPrice'] }}<span
                                        class="year-text">({{ date('Y') }})</span></h3>
                                <ul>
                                    <li class="qa">Q1</li>
                                    <li class="qb">Q2</li>
                                    <li class="qc">Q3</li>
                                    <li class="qd">Q4</li>
                                </ul>
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qa"></span>
                                    </dl>
                                    <dl class="qt-text">Q1</dl>
                                    <dl class="qt-money">₹ {{ $quarterArr['first'] }}</dl>
                                    <dl class="qt-updown">
                                        <span class="budge">
                                            @if ($quarterArr['first'] == 0)
                                                -
                                            @else
                                                <img src="{{ asset('theme/images/green-arrow-up-big.png') }}" />
                                                {{ rand(0, 10) }}%
                                            @endif
                                        </span>
                                    </dl>
                                </div>
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qb"></span>
                                    </dl>
                                    <dl class="qt-text">Q2</dl>
                                    <dl class="qt-money">₹ {{ $quarterArr['second'] }}</dl>
                                    <dl class="qt-updown">
                                        <span class="budge">
                                            @if ($quarterArr['second'] == 0)
                                                -
                                            @else
                                                <img src="{{ asset('theme/images/green-arrow-up-big.png') }}" />
                                                {{ rand(0, 10) }}%
                                            @endif
                                        </span>
                                    </dl>
                                </div>
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qc"></span>
                                    </dl>
                                    <dl class="qt-text">Q3</dl>
                                    <dl class="qt-money">₹ {{ $quarterArr['third'] }}</dl>
                                    <dl class="qt-updown">
                                        <span class="budge">
                                            @if ($quarterArr['third'] == 0)
                                                -
                                            @else
                                                <img src="{{ asset('theme/images/green-arrow-up-big.png') }}" />
                                                {{ rand(0, 10) }}%
                                            @endif
                                        </span>
                                    </dl>
                                </div>
                                <div class="quarter-box">
                                    <dl class="qt-bg">
                                        <span class="qd"></span>
                                    </dl>
                                    <dl class="qt-text">Q4</dl>
                                    <dl class="qt-money">₹ {{ $quarterArr['fourth'] }}</dl>
                                    <dl class="qt-updown">
                                        <span class="budge">
                                            @if ($quarterArr['fourth'] == 0)
                                                -
                                            @else
                                                <img src="{{ asset('theme/images/green-arrow-up-big.png') }}" />
                                                {{ rand(0, 10) }}%
                                            @endif
                                        </span>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3>Purchase Behavioura</h3>
                                <div class="card-header-right">
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle" type="button"
                                            id="dropdownMenuClickableInside" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside" aria-expanded="false"> <img
                                                src="{{ asset('theme/images/dot-img.png') }}" alt=""></button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuClickableInside">
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block table-border-style">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Pack</th>
                                                <th>Units</th>
                                                <th>Amount (in INR)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Single Pack</td>
                                                <td>{{ $packageArr['singlePackUnit'] }}</td>
                                                <td class="text-right">{{ $packageArr['singlePackTotal'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>2-4 Pack</td>
                                                <td>{{ $packageArr['towPackUnit'] }}</td>
                                                <td class="text-right">{{ $packageArr['towPackTotal'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>5-7 Pack</td>
                                                <td>{{ $packageArr['fivePackUnit'] }}</td>
                                                <td class="text-right">{{ $packageArr['fivePackTotal'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>8-10 Pack</td>
                                                <td>{{ $packageArr['eightPackUnit'] }}</td>
                                                <td class="text-right">{{ $packageArr['eightPackTotal'] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Above 10 Pack</td>
                                                <td>{{ $packageArr['tenPackUnit'] }}</td>
                                                <td class="text-right">{{ $packageArr['tenPackTotal'] }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3>Sales by Outlet Location</h3>
                                <div class="card-header-right">
                                    <div class="btn-group">
                                        <button class="btn dropdown-toggle" type="button"
                                            id="dropdownMenuClickableInside" data-bs-toggle="dropdown"
                                            data-bs-auto-close="outside" aria-expanded="false"> <img
                                                src="{{ asset('theme/images/dot-img.png') }}" alt=""></button>
                                        <ul class="dropdown-menu dropdown-menu-end"
                                            aria-labelledby="dropdownMenuClickableInside">
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                            <li><a class="dropdown-item" href="">Menu item</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="card-block table-border-style">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Location</th>
                                                <th>Units</th>
                                                <th>Amount (in INR)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($OutletLocation) && count($OutletLocation) > 0)
                                                @foreach ($OutletLocation as $key => $value)
                                                    <tr>
                                                        <td>{{ $value['name'] }}</td>
                                                        <td>{{ $value['total_qty'] }}</td>
                                                        <td class="text-right">{{ $value['total_amount'] }}</td>
                                                    </tr>
                                                @endforeach
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
    </div>
    <script src="{{ asset('assets/validation/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('theme/js/raphael.min.js') }}"></script>
    <script src="{{ asset('theme/js/morris.js') }}"></script>
    <script type="text/javascript">
        Morris.Bar({
            element: 'bar-chart',
            data: <?php echo $barChart; ?>,
            xkey: 'y',
            ykeys: ['a', 'b'],
            labels: ['Last Year', 'Current Year'],
            resize: true,
            barColors: ['#AB96F1', '#24DEAE'],
        });

        Morris.Area({
            element: 'clasic-area-chart',
            data: [{
                    y: '2006',
                    a: 100,
                    b: 90
                },
                {
                    y: '2007',
                    a: 75,
                    b: 65
                },
                {
                    y: '2008',
                    a: 50,
                    b: 40
                },

            ],
            xkey: 'y',
            ykeys: 'a',
        });

        Morris.Area({
            element: 'insignia-area-chart',
            data: [{
                    y: '2006',
                    a: 100,
                    b: 90
                },
                {
                    y: '2007',
                    a: 75,
                    b: 65
                },
                {
                    y: '2008',
                    a: 50,
                    b: 40
                },

            ],
            xkey: 'y',
            ykeys: 'a',
            //labels: ['Series A']
        });

        Morris.Area({
            element: 'noir-area-chart',
            data: [{
                    y: '2006',
                    a: 100,
                    b: 90
                },
                {
                    y: '2007',
                    a: 75,
                    b: 65
                },
                {
                    y: '2008',
                    a: 50,
                    b: 40
                },

            ],
            xkey: 'y',
            ykeys: 'a',
            //labels: ['Series A']
        });

        Morris.Area({
            element: 'goldflakes-area-chart',
            data: [{
                    y: '2006',
                    a: 100,
                    b: 90
                },
                {
                    y: '2007',
                    a: 75,
                    b: 65
                },
                {
                    y: '2008',
                    a: 50,
                    b: 40
                },

            ],
            xkey: 'y',
            ykeys: 'a',
            //labels: ['Series A']
        });
    </script>
@endsection
