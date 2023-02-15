<style>
    div#salesman_history_table_wrapper {
    margin: 25px;
}
</style>
<div class="table-responsive">
    <table class="table" id="salesman_history_table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">Sr.No</th>
                <th>Month</th>
                <th>Orders</th>
                <th>Gross Sales</th>
                <th>Discount</th>
                <th>Tax</th>
                <th class="text-right">Total Sale</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($sales_history) && count($sales_history) > 0)
                @foreach ($sales_history as $key => $val)
                    <tr>
                        <td class="text-center">#{{ $key + 1 }}</td>
                        <td>{{ $val->created_at->format('M Y') }}</td>
                        <td>
                            @foreach ($val->order_item_details as $item)
                                    {{$item->qty}}
                            @endforeach
                        </td>
                        <td>{{$val->total_amount}}</td>
                        <td>0</td>
                        <td>0</td>
                        <td class="text-right">{{$val->total_amount}}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="10">Sales History Not Found</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
