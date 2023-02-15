<div class="col-md-4">
    <div class="card pink-bg">
        <div class="card-block kiosku-block">
            <div class="card-header">
                <figure>
                    <img src="{{asset('theme/images/icon-salse.png')}}" />
                </figure>
                <div class="card-title">
                    <a href="{{route('admin.dashboard.sales')}}">
                        <h3>Sales</h3>
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <div class="tuser">
                    <span>Total Sales</span>
                    <h4>{{$totalrequestedQuentity}}</h4>
                </div>
                <div class="auser">
                    <span>Sales</span>
                    <h4>{{$requestedQuentity}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card green-bg">
        <div class="card-block kiosku-block">
            <div class="card-header">
                <figure>
                    <img src="{{asset('theme/images/icon-inventory.png')}}" />
                </figure>
                <div class="card-title">
                    <a href="{{route('admin.dashboard.kiosk')}}">
                        <h3>Inventory</h3>
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <div class="tuser">
                    <span>Total Inventory</span>                   
                    <h4>{{$testotalrequestedStockt_qty}}</h4>
                </div>
                <div class="auser">
                    <span>Inventory</span>
                    <h4>{{$requestedStock}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card purple-bg">
        <div class="card-block kiosku-block">
            <div class="card-header">
                <figure>
                    <img src="{{asset('theme/images/icon-kioskusers.png')}}" />
                </figure>
                <div class="card-title">
                    <a href="{{route('admin.user_management.index')}}">
                        <h3>Kiosk Users</h3>
                    </a>
                </div>
            </div>
            <div class="card-footer">
                <div class="tuser">
                    <span>Total Users</span>
                    <h4>{{$totalUsersCount}}</h4>
                </div>
                <div class="auser">
                    <span>Active Users</span>
                    <h4>{{$activatedUserCount}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>