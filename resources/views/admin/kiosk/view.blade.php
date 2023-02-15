@extends('layouts.app_admin')

@section('title') 
    {{'View Product'}}
@endsection

@section('content')

<div class="main-content-part">
    <div class="main-content-padd">
       <div class="title-w-arrow">
          <a href="{{ route('admin.kiosk.index') }}">
          <span><img src="{{ asset('theme/images/grey-big-arrow.png') }}" /></span>
          </a>
          <h1 class="mr20 back_title_text">{{$view->kiosk_id}}</h1>
          <div class="tabing">
             <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                   <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Product List</button>
                </li>
                <li class="nav-item" role="presentation">
                   <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Sales History</button>
                </li>
             </ul>
             <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                   <div class="common-table-sec um-table">
                      <div class="row">
                         <div class="col-md-12">
                            <div class="table-header pr-theader">
                               <input type="hidden" name="city_id" id="city_id" value="{{$view->city_id}}">
                               <input type="hidden" name="kiosk_id" id="kiosk_id" value="{{$id}}">

                               <div class="droupdown-select" style="display:none">
                                  <select class="form-control" name="brand_name" id="brand_filter">
                                     @if (!empty($brands) && count($brands) > 0)
                                     @foreach ($brands as $key => $value)
                                     <option value="{{ $value->id }}">{{ $value->name }}</option>
                                     @endforeach
                                     @endif
                                  </select>
                               </div>
                            </div>
                           @include('admin.kiosk.product_list_table')
                         </div>
                      </div>
                   </div>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                   <div class="common-table-sec um-table">
                      <div class="row">
                         <div class="col-md-12">
                            <div class="table-header pr-theader">
                               <div class="droupdown-select" style="display:none">
                                  <select class="form-control" name="brand_name" id="payment_mode_filter">
                                     <option value="">-- Mode --</option>
                                     <option value="Cash">Cash</option>
                                     <option value="Card">Card</option>
                                     <option value="UPI">UPI</option>
                                  </select>
                               </div>
                            </div>
                            @include('admin.kiosk.sales_history_table')
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
 </div>
 </div>


<script type="text/javascript">
   $(document).on('click', '.update_button', function() {
       $('#updateModal').modal('show');
       $('.stock_id').val($(this).attr('data-id'));
       $('.quantity').val($(this).attr('data-quantity'));

   })
</script>

<script type="text/javascript">
   $(document).on('change', '#brand_filter', function(e) {

       var brand_id = $('#brand_filter').val();
       var token = "{{ csrf_token() }}";
       var city_id = $("#city_id").val();
       var kiosk_id = $("#kiosk_id").val();

       $.ajax({
           type: 'GET',
           dataType: "json",
           url: '{{ route("admin.kiosk.product_list_search") }}',
           data: {
               'brand_id': brand_id, 'city_id':city_id,'kiosk_id': kiosk_id,
               _token: token
           },
           success: function(data) {

               $('table tbody').empty();
               for (var i = 0; i < data.brands.length; i++) {
                   $('table tbody').append('<tr><td>#' + data.brands[i].id + '</td><td>' +
                       data.brands[i].name + '</td><td>' + data.brands[i].product_name + '</td><td>' + data
                       .brands[i].packge_size + '</td><td>' + data.brands[i].price +
                       '</td><td>' + data.brands[i].qty +
                       '</td></tr>'
                   )
               }
           },
           timeout: 10000
       });
   });
</script>

<script type="text/javascript">
   $(document).on('change', '#payment_mode_filter', function(e) {

       var payment_mode_type = $('#payment_mode_filter').val();
       var token = "{{ csrf_token() }}";
       var city_id = $("#city_id").val();
       var kiosk_id = $("#kiosk_id").val();

       $.ajax({
           type: 'GET',
           dataType: "json",
           url: '{{ route("admin.kiosk.payment_mode_search") }}',
           data: {
               'payment_mode_type': payment_mode_type, 'city_id':city_id, 'kiosk_id': kiosk_id,
               _token: token
           },
           success: function(data) {

               $('table tbody').empty();
               for (var i = 0; i < data.payments_mode.length; i++) {
                   $('table tbody').append('<tr><td>#' + data.payments_mode[i].id + '</td><td>' +
                       data.payments_mode[i].order_id + '</td><td>' + data.payments_mode[i].created_at + '</td><td>' + data
                       .payments_mode[i].qty + '</td><td>' + data.payments_mode[i].payment_mode +
                       '</td><td>' + data.payments_mode[i].total_amount +
                       '</td></tr>'
                   )
               }
           },
           timeout: 10000
       });

   });
</script>
<style>
   button.d-none.d-sm-inline-block.btn.btn-sm.btn-info.stock_update {
       background-color: #5C3FFE;
       color: #fff;
       border-color: #5C3FFE;
   }

   .btn-info:hover {
       color: #fff;
       background-color: #5C3FFE;
       border-color: #5C3FFE;
   }
            
   .tabing{display: block;margin: 30px 0 0;}
   .tabing .tabnav{display: inline-block;color: #707070;margin: 0 15px 0 0;}
   .tabing .tabnav.active{color: #5C3FFE;}
   .tabing .nav-pills .nav-link{ color:  #5C3FFE;}
   .tabing .nav-pills .nav-link.active {
   color:  #5C3FFE;
   background-color:#E5E5E5;}
</style>
@endsection