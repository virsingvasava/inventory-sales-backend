@extends('layouts.app_admin')

@section('title') 
    {{'index'}}
@endsection

@section('content')

{{-- @php 

dd($id)

@endphp  --}}
<div class="main-content-part">
   <div class="main-content-padd">
      <div class="title-w-arrow">
         <span><img src="images/grey-big-arrow.png"/></span>
         <h1 class="mr20">Classic</h1>
         <a href="{{route('admin.product.add')}}" class="badge">Add New</a><a href="#" class="badge">Import</a><a href="#" class="badge">Export</a>
         <div class="search-box">
            <img class="search-user" src="images/search-icon.png">
            <input class="form-control" type="text" placeholder="Search..." aria-label="Search">
         </div>
      </div>
      <div class="common-table-sec mt-5">
         <div class="row">
            <div class="col-md-12">
               <div class="table-border-style">
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <tr>
                              <th><input type="checkbox" name="k0"></th>
                              <th>SKU</th>
                              <th>Product Name</th>
                              <th>Brand</th>
                              <th>Pack Size</th>
                              <th>Price (in INR)</th>
                              <th>Edit</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_001</td>
                              <td>Classic RT</td>
                              <td>CLASSIC</td>
                              <td>20</td>
                              <td>350</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_002</td>
                              <td>Classic RT</td>
                              <td>CLASSIC</td>
                              <td>10</td>
                              <td>300</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_003</td>
                              <td>Classic R&S</td>
                              <td>CLASSIC</td>
                              <td>20</td>
                              <td>400</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_004</td>
                              <td>Classic R&S</td>
                              <td>CLASSIC</td>
                              <td>10</td>
                              <td>350</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_005</td>
                              <td>Classic FTP</td>
                              <td>CLASSIC</td>
                              <td>20</td>
                              <td>300</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_006</td>
                              <td>Classic FTP</td>
                              <td>CLASSIC</td>
                              <td>10</td>
                              <td>400</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_007</td>
                              <td>Classic BT</td>
                              <td>CLASSIC</td>
                              <td>20</td>
                              <td>350</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_008</td>
                              <td>Classic BT</td>
                              <td>CLASSIC</td>
                              <td>10</td>
                              <td>300</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_009</td>
                              <td>Classic Low Smell</td>
                              <td>CLASSIC</td>
                              <td>20</td>
                              <td>400</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                           <tr>
                              <td><input type="checkbox" name="k1"></td>
                              <td>C_010</td>
                              <td>Classic Low Smell</td>
                              <td>CLASSIC</td>
                              <td>10</td>
                              <td>250</td>
                              <td><img src="images/icon-edit.png"/></td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
