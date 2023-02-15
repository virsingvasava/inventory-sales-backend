<div class="col-md-4">
    <div class="card pink-bg">
        <div class="card-block salse-block">
        <div class="card-header">
            <figure>
                <img src="{{asset('theme/images/icon-salse.png')}}"/>
            </figure>
            <div class="card-title">
                <a href="{{route('airport_manager.dashboard.sales')}}"><h3>Sales</h3></a>
            </div>
        </div>
        <div class="card-footer">
            <h4>{{$requestedQuentity}} <span>Packs Sold</span></h4>
        </div>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="card green-bg">
        <div class="card-block inven-block">
        <div class="card-header">
            <figure>
                <img src="{{asset('theme/images/icon-inventory.png')}}"/>
            </figure>
            <div class="card-title">
                <a href="{{route('airport_manager.stock_qty_update.index')}}"><h3>Inventory</h3></a>
            </div>
        </div>
        <div class="card-footer">
            <h4>{{$requestedStock}}</h4>
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
                <img src="{{asset('theme/images/icon-kioskusers.png')}}"/>
            </figure>
            <div class="card-title">
                <a href="{{route('airport_manager.pending_request.index')}}"><h3>Kiosk Users</h3></a>
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