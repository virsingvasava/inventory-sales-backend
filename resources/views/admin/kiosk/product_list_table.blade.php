<div class="table-border-style">
    <div class="table-responsive">
       <table class="table" id="kiosk_view_products_list">
          <thead>
             <tr>
                <th class="text-center" style="width: 5%;">Sr.No</th>
                <th>Brand Name</th>
                <th>Product Name</th>
                <th>Packge Size</th>
                <th>Price</th>
                <th>Qty</th>
             </tr>
          </thead>
          <tbody>
             @if (!empty($products) && count($products) > 0)
             @foreach ($products as $key => $value)
             <tr>
                <td class="text-center">#{{ $key + 1 }}</td>
                <td>{{ $value->brand_name }}</td>
                <td>{{ $value->product_name }}</td>
                <td>{{ $value->packge_size }}</td>
                <td>{{ $value->price }}</td>
                <td>{{ isset($value->qty) ? $value->qty : 0 }}</td>
             </tr>
             @endforeach
             @else
             <tr>
                <td colspan="10">Product List Not Found</td>
             </tr>
             @endif
          </tbody>
       </table>
    </div>
 </div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>
