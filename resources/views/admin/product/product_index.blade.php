@extends('layouts.app_admin')

@section('title') 
    {{'index'}}
@endsection

@section('content')

<div class="main-content-part">
   <div class="main-content-padd">
      <div class="title-w-arrow">
         <a href="{{route('admin.product.index')}}"><span><img src="{{ asset('theme/images/grey-big-arrow.png')}}"/></span></a>
         <h1 class="mr20">{{$brand->name}}</h1>
         <a href="{{route('admin.product.brand.create', $id)}}" class="badge">Add New</a>
         {{-- <a href="#" class="badge">Import</a> --}}
         <a class="badge import_data_btn" href="javascript:;" data-id="{{$id}}" data-toggle="tooltip" title="Are you sure to Import Data ?">
            Import
        </a>
         {{-- <a href="#exportModel" class="badge export_data_btn">Export</a> --}}

         <a href="{{asset('sample_download/sample_import_product.xls')}}" download="{{asset('sample_download/sample_import_product.xls')}}" class="badge" title="Download"><i class="fa fa-download"></i> Export Sample File</a>

         <div class="search-box" style="display:none">
            <img class="search-user" src="{{ asset('theme/images/search-icon.png')}}">
            <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
         </div>
      </div>
      <div class="common-table-sec mt-5">
         <div class="row">
            <div class="col-md-12">
               <div class="table-border-style">
                  <div class="table-responsive">
                     <table class="table" id="product_table">
                        <thead>
                           <tr>
                              {{-- <th><input type="checkbox" name="k0"></th> --}}
                              <th class="text-center" style="width: 5%;">Sr.No</th>

                              <th>SKU</th>
                              <th>Product Name</th>
                              <th>Brand</th>
                              <th>Pack Size</th>
                              <th>Price (in INR)</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if (!empty($products) && count($products) > 0)
                              @foreach ($products as $key => $val)
                                 <tr>
                                    <td class="text-center">{{$key+1}}</td>
                                    <td>{{$val->sku}}</td>
                                    <td>{{$val->name}}</td>
                                    <td>
                                       @if (!empty($val['brand_name']))
                                          @foreach ($val['brand_name'] as $brand)
                                          {{$brand->name}}
                                          @endforeach
                                       @endif
                                    </td>
                                    <td>{{$val->packge_size}}</td>
                                    <td>{{$val->price}}</td>
                                   

                                    <td class="text-right icon_section">
                                                        
                                       <a style="display:none" href="{{route('admin.product.brand.view', $val->id)}}" 
                                          data-toggle="tooltip" 
                                          title="Are you sure to View Details ? ">
                                          <img src="{{ asset('theme/images/view.png')}}"/>
                                       </a>

                                       <a class="edit_icon" href="{{route('admin.product.brand.edit', $val->id)}}" 
                                          data-toggle="tooltip" 
                                          title="Are you sure to edit Details ? ">
                                          <img src="{{ asset('theme/images/icon-edit.png')}}"/>
                                       </a>

                                       <a class="delete_button" href="javascript:;" data-id="{{$val->id}}" 
                                          data-toggle="tooltip" 
                                          title="Are you sure to Delete User ?">
                                           <img src="{{ asset('theme/images/delete.png')}}"/>
                                       </a>
                                   </td>
                                 </tr>
                              @endforeach
                           @else
                              <tr>
                                 <td colspan="10">Product Not Found</td>
                              </tr>
                           @endif
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script src="{{asset('assets/validation/plugins/jquery/jquery.min.js')}}"></script>

<div class="modal fade" id="deleteModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 style="font-size:20px">Are You sure?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <h5 style="font-size:15px; margin: 0 0 0px;">Are you sure to Delete Product ?</h5>
            <form action="{{route('admin.product.brand.delete', $id)}}" method="POST">
               @csrf
               <input type="hidden"  name="productId" class="productId">
               <input type="hidden"  name="brandId" value="{{$id}}">

               <div class="modal-footer">
                   <button type="button" class="d-sm-inline-block btn btn-sm btn-info" data-bs-dismiss="modal">Close</button>
                   <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Delete</button>
               </div>
           </form>
         </div>
      </div>
   </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).on('click','.delete_button',function(){
    $('#deleteModel').modal('show');
    $('.productId').val($(this).attr('data-id'));
})
</script>



<div class="modal fade" id="importDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
          <div class="modal-header">
              <h5 style="font-size:20px">Are You sure?</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Import Product ?</h5>
              <form action="{{ route('admin.product.brand.import', $id) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <input type="hidden" name="userId" class="userId">
                  <input type="file" name="import_data">

                  <div class="modal-footer">
                      <button type="submit"
                      class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Import</button>
                      <button type="button" class="d-sm-inline-block btn btn-sm btn-info"
                          data-bs-dismiss="modal">Close</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
</div>

<div class="modal fade" id="exportDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
       <div class="modal-content">
           <div class="modal-header">
               <h5 style="font-size:20px">Are You sure?</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body">
               <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to download sample import product file ?</h5>
               <form action="{{ route('admin.product.brand.export', $id) }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   <input type="hidden" name="userId" class="userId">
                   <input type="hidden" name="export_data">
                   <div class="modal-footer">
                       <button type="submit"
                       class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Import</button>
                       <button type="button" class="d-sm-inline-block btn btn-sm btn-info"
                           data-bs-dismiss="modal">Close</button>
                   </div>
               </form>
           </div>
       </div>
   </div>
 </div>
 
<script type="text/javascript">
   $(document).on('click', '.import_data_btn', function() {
       $('#importDataModel').modal('show');
       $('.userId').val($(this).attr('data-id'));
   })

   $(document).on('click', '.export_data_btn', function() {
       $('#exportDataModel').modal('show');
       $('.userId').val($(this).attr('data-id'));
   })
</script>
@endsection

