<div class="table-border-style">
    <div class="table-responsive">
        <table class="table" id="user_table">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">Sr.No</th>
                    <th>Sku</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Quantity</th>
                    <th>Kiosk Name</th>
                    <th>City</th>
                </tr>
            </thead>
            <tbody>
                @if (!empty($test) && count($test) > 0)
                <?php $i = 1; ?>
                @foreach($test as $value)
                <tr>
                    <td class="text-center">{{$i}}</td>
                    <td>{{$value->sku}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{$value->brand_name}}</td>
                    <td>{{$value->qty}}</td>
                    <td>{{$value->kiosk_name}}</td>
                    <td>{{$value->city_name}}</td>
                </tr>
                <?php $i++; ?>
                @endforeach
                @else
                <tr>
                    <td colspan="10">Data Not Found</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="exportDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:20px">Are You sure?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Kiosk ?</h5>
                <form action="{{ route('admin.dashboard.export_listing_data_post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="export_kiosk_data">
                    <input type="hidden" name="city_id" value="{{$cities}}"><input type="hidden" name="kiosk_id" value="{{$Kiosks}}">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_export">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>