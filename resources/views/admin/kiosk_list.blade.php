<select class="form-control sales_by_time_interval sales_by_time_interval_kiosk">
    <option value="">All Kiosk</option>
    @foreach($kiosks as $value)
    <option value="{{$value['id']}}">{{ucfirst($value['kiosk_id'])}} - {{ucfirst($value['kiosk_name'])}}</option>
    @endforeach
</select>