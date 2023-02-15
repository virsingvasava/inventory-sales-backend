<div class="table-border-style">
    <div class="table-responsive">
       <table class="table" id="kiosk_view_sales_history">
          <thead>
             <tr>
                <th class="text-center" style="width: 5%;">Sr.No</th>
                <th>Order Id</th>
                {{-- <th>Time</th> --}}
                <th>Date</th>
                <th>Pick sold</th>
                <th>Mode</th>
                <th>Total Amount</th>
             </tr>
          </thead>
          <tbody>
             @if (!empty($sales_history) && count($sales_history) > 0)
             @foreach ($sales_history as $key => $value)
             <tr>
                <td class="text-center">#{{ $key + 1 }}</td>
                <td>{{ $value->id }}</td>
                {{-- <td>{{ $value->created_at }}</td> --}}
                <td>{{ $value->created_at }}</td>
                <td>{{ $value->qty }}</td>
                <td>{{ $value->payment_mode }}</td>
                <td>{{ $value->total_amount }}</td>
             </tr>
             @endforeach
             @else
             <tr>
                <td colspan="10">Sales History List Not Found</td>
             </tr>
             @endif
          </tbody>
       </table>
    </div>
 </div>