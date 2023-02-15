@extends('layouts.app_admin')

@section('title')
{{ 'index' }}
@endsection

@section('content')
<div class="main-content-part">
   <div class="main-content-padd">
      <div class="title-w-arrow">
         <h1 class="mr20">Kiosk</h1>
         <a href="{{ route('admin.kiosk.create') }}" class="badge">Add New</a>
         <a class="badge import_data_btn" href="javascript:;" data-id="1" data-toggle="tooltip" title="Are you sure to Import Data ?">
            Import
        </a>

        <a class="badge export_kiosk_data_btn" href="javascript:;" data-id="1" data-toggle="tooltip" title="Are you sure to Export Data ?">
         Export
         </a>

        <!-- <a href="{{asset('sample_download/sample_import_kiosk.xls')}}" download="{{asset('sample_download/sample_import_kiosk.xls')}}" class="badge"  title="Are you sure to download kiosk import sample ?"><i class="fa fa-download"></i> Export Sample File</a> -->
   
         <div class="search-box" style="display:none">
            <img class="search-user" src="{{ asset('theme/images/search-icon.png') }}">
            <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
         </div>
      </div>
      <div class="city-sec">
         <div class="row">
            <div class="col-md-12" style="display:none">
               <div class="city-block">
                  <figure><img src="{{asset('theme/images/icon-delhi.png')}}" /></figure>
                  <h3>Delhi</h3>
               </div>
               <div class="city-block">
                  <figure><img src="{{asset('theme/images/icon-mumbai.png')}}" /></figure>
                  <h3>Mumbai</h3>
               </div>
               <div class="city-block">
                  <figure><img src="{{asset('theme/images/icon-bengaluru.png')}}" /></figure>
                  <h3>Bengaluru</h3>
               </div>
               <div class="city-block">
                  <figure><img src="{{asset('theme/images/icon-hyderabad.png')}}" /></figure>
                  <h3>Hyderabad</h3>
               </div>
               <div class="city-block">
                  <figure><img src="{{asset('theme/images/icon-kolkata.png')}}" /></figure>
                  <h3>Kolkata</h3>
               </div>
               <div class="city-block">
                  <figure><img src="{{asset('theme/images/icon-chennai.png')}}" /></figure>
                  <h3>Chennai</h3>
               </div>
            </div>
         </div>
      </div>

      <div class="common-table-sec">
         <div class="row">
            <div class="col-md-12">
               <div class="table-header">
                  <h3>Kiosk List</h3>
                  <div class="droup-right" style="display:none">
                     <div class="droupdown-select">
                        <select class="form-control" id="citiy_id">
                           <option value="">All Cities</option>
                           @if (!empty($cityArray) && count($cityArray) > 0)
                           @foreach ($cityArray as $key => $city)
                           <option value="{{$city->name}}">{{$city->name}}</option>
                           @endforeach
                           @endif
                        </select>
                     </div>
                  </div>
               </div>
               <div class="table-border-style">
                  <div class="table-responsive">
                     <table class="table" id="kiosk_table">
                        <thead>
                           <tr>
                              <th class="text-center" style="width: 5%;">Sr.No</th>
                              <th>Kiosk ID</th>
                              <th>Kiosk Name</th>
                              <th>Location</th>
                              <th>City</th>
                              <th>Airport</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if (!empty($kiosk_obj) && count($kiosk_obj) > 0)
                           @foreach ($kiosk_obj as $key => $value)
                           <tr>
                              <td class="text-center">{{ $key + 1 }}</td>
                              <td>{{ $value->kiosk_id }}</td>
                              <td>{{ $value->kiosk_name }}</td>
                              <td>
                                 @if (!empty($value['outlet_location']))
                                 @foreach ($value['outlet_location'] as $location)
                                 {{ $location->name }}
                                 @endforeach
                                 @endif
                              </td>
                              <td>
                                 @if (!empty($value['city_name']))
                                 @foreach ($value['city_name'] as $city)
                                 {{ $city->name }}
                                 @endforeach
                                 @endif
                              </td>
                              <td>{{ $value->airport }}</td>
                              <td>
                                 @if ($value->status == 1)
                                 <span class="badge" style="color:green">Active</span>
                                 @else
                                 <span class="badge inactive" style="color:#f0ad4e">Inactive</span>
                                 @endif
                              </td>
                              <td class="text-center">

                                 <a href="{{ route('admin.kiosk.view', $value->id) }}" data-toggle="tooltip" title="Are you sure to View Details ? ">
                                    <img src="{{ asset('theme/images/view.png') }}" />
                                 </a>

                                 <a class="edit_icon" href="{{ route('admin.kiosk.edit', $value->id) }}" data-toggle="tooltip" title="Are you sure to edit Details ? ">
                                    <img src="{{ asset('theme/images/icon-edit.png') }}" />
                                 </a>

                                 <a class="delete_button" href="javascript:;" data-id="{{ $value->id }}" data-toggle="tooltip" title="Are you sure to Delete User ?">
                                    <img src="{{ asset('theme/images/delete.png') }}" />
                                 </a>

                              </td>
                           </tr>
                           @endforeach
                           @else
                           <tr>
                              <td colspan="10">Kiosk Not Found</td>
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
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 style="font-size:20px">Are You sure?</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <h5 style="font-size:15px; margin: 0 0 0px;">Are you sure to Delete Kiosk ?</h5>
            <form action="{{route('admin.kiosk.delete')}}" method="POST">
               @csrf
               <input type="hidden"  name="kioskId" class="kioskId">

               <div class="modal-footer">
                   <button type="button" class="d-sm-inline-block btn btn-sm btn-info" data-bs-dismiss="modal">Close</button>
                   <button type="submit" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">Delete</button>
               </div>
           </form>
         </div>
      </div>
   </div>
</div>
   <div class="modal fade" id="importDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
                  <h5 style="font-size:20px">Are You sure?</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                  <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Import Kiosk ?</h5>
                  <form action="{{ route('admin.kiosk.import') }}" method="POST" id="kiosk_import" enctype="multipart/form-data">
                     @csrf
                     <input type="file" name="kiosk_import">
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Import</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
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
                  <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to Export Kiosk ?</h5>
                  <form action="{{ route('admin.kiosk.export_listing_data') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="export_kiosk_data">
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm hide_after_export">Export</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                     </div>
                  </form>
               </div>
         </div>
      </div>
   </div>

   <div class="modal fade" id="exportSampleDataModel" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
               <div class="modal-header">
                  <h5 style="font-size:20px">Are You sure?</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body">
                  <h5 style="font-size:15px; margin: 0 0 0px;" class="mb-3">Are you sure to download sample import kiosk file ?</h5>
                  <form action="{{ route('admin.kiosk.export') }}" method="POST" enctype="multipart/form-data">
                     @csrf
                     <input type="hidden" name="userId" class="userId">
                     <input type="hidden" name="export_data">
                     <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Import</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                     </div>
                  </form>
               </div>
         </div>
      </div>
   </div>

 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
 <script src="{{ asset('assets/validation/js/jquery.validate.min.js') }}"></script>

 <script type="text/javascript">
    $(document).on('click', '.import_data_btn', function() {
        $('#importDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })
    $(document).on('click', '.export_kiosk_data_btn', function() {
        $('#exportDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })

    $(document).on('click', '.hide_after_export', function() {
      $('#exportDataModel').modal('hide');
              toastr.success('Export Kiosk Successfully Export.');
   })

    $(document).on('click', '.export_data_btn', function() {
        $('#exportSampleDataModel').modal('show');
        $('.userId').val($(this).attr('data-id'));
    })
 </script>
 
<script type="text/javascript">
   $(document).on('click','.delete_button',function(){
       $('#deleteModal').modal('show');
       $('.kioskId').val($(this).attr('data-id'));
   })
   $("#kiosk_import").validate({
            ignore: "not:hidden",
            onfocusout: function(element) {
                this.element(element);
            },
            rules: {

                "kiosk_import": {
                    required: true,
                },
            },
            messages: {

                "kiosk_import": {
                    required: 'Please choose file for Import Kiosk.',
                },
            },
            submitHandler: function(form) {
                var $this = $('.loader_class');
                var loadingText =
                    '<i class="fa fa-spinner fa-spin" role="status" aria-hidden="true"></i> Loading...';
                $('.loader_class').prop("disabled", true);
                $this.html(loadingText);
                form.submit();
            }
      });
</script>
@endsection