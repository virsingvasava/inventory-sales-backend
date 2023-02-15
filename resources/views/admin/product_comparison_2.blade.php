@foreach($test as $value)
<ul class="plan-features">
    <li>{{$value->total_amount}}</li>
    <li>{{$value->qty}}</li>
    <li>{{$value->brand_name}}</li>
    <li>{{$value->sku}}</li>
    <li>{{$value->price}}</li>
    <li>{{$value->packge_size}}</li>
</ul>
@endforeach