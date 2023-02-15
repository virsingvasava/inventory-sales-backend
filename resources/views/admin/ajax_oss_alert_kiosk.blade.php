<select class="form-control kiosk_dropdown">
    <option value="">All kiosk</option>
    @foreach($kiosk_list as $value)
    <option value="{{$value['id']}}">{{ucfirst($value['kiosk_name'])}}</option>
    @endforeach
</select>