<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>City</th>
            <th>Unit</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            @if(!empty($salesRegionArr) && count($salesRegionArr) > 0)
                @foreach($salesRegionArr as $key => $value)
                    <tr>
                        <td scope="row">{{$value['name']}}</td>
                        <td>{{$value['unit']}}</td>
                        @if($value['percentage'] == 0)
                        <td class="text-right"><span class="budge">-</span> </td>
                        @elseif($value['percentage'] > 0)
                        <td class="text-right"><span class="budge"><img src="{{asset('theme/images/green-arrow-up.png')}}"/>{{$value['percentage']}}%</span></td>
                        @else
                        <td class="text-right"><span class="budge" style="color: red;"><img src="{{asset('theme/images/red-arrow-down.png')}}"/>{{$value['percentage']}}%</span></td>
                        @endif
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>