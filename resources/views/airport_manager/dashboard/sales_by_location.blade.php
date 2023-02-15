<div class="table-responsive ">
    <table class="table">
        <thead>
        <tr>
            <th>Location</th>
            <th>Units</th>
            <th>Amount (in INR)</th>
        </tr>
        </thead>
        <tbody>
            @if(!empty($OutletLocation) && count($OutletLocation) > 0)
                @foreach($OutletLocation as $key => $value)
                <tr>
                    <td>{{$value['name']}}</td>
                    <td>{{$value['total_qty']}}</td>
                    <td class="text-right">{{$value['total_amount']}}</td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>