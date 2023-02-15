<div class="row" >
@if(!empty($SoldBrands) && count($SoldBrands) > 0)
    @foreach($SoldBrands as $key => $value)
    <div class="col-md-3">
        <div class="brand-box-inr">
        <h4>{{$value['name']}}</h4>
        <div class="bb-left-part">
            @if($value['percentage'] != 0)
            <span class="budge"><img src="{{asset('theme/images/green-arrow-up.png')}}">{{$value['percentage']}}%</span>
            @else
            <span class="budge">-</span>
            @endif
            <h3>{{$value['sold_items']}}</h3>
            <p>Pack Sold</p>
        </div>
        <div class="bb-right-part">
            <img src="{{asset('theme/images/small-chart.png')}}">
            <!-- <div id="clasic-area-chart" style="height:100px;"></div> --> 
        </div>
        </div>
    </div>
    @endforeach
@endif
</div>