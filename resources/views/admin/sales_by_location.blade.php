<div class="table-responsive ">
    <table class="table">
        <thead>
        <tr>
            <th class="text-center">Kiosk</th>
            <th class="text-center">Units</th>
            <th class="text-center">Transactions</th>
            <th class="text-center">Amount (in INR)</th>
            <th class="text-center">ATV</th>
        </tr>
        </thead>
        <tbody>
            @if(!empty($OutletLocation) && count($OutletLocation) > 0)
                @foreach($OutletLocation as $key => $value)
                <tr>
                    <td class="text-center">{{$value['kiosk_name']}}</td>
                    <td class="text-center">{{$value['total_qty']}}</td>
                    <td class="text-center">{{$value['total_transactions']}}</td>
                    <td class="text-center">{{$value['total_amount']}}</td>
                    <td class="text-center">{{$value['ATV']}}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

<div class="modal fade" id="salesbylocationexport" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Sales by Outlet Location ?</h5>
                <form action="{{ route('admin.dashboard.ajax_sales_by_location_export') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="start_date" value="{{$startNewDate}}"><input type="hidden" name="end_date" value="{{$endNewDate}}"><input type="hidden" name="city_id" value="{{$city_id}}">
                    <input type="hidden" name="export_kiosk_data">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_exports">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>