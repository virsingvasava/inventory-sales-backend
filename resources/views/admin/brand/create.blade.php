@extends('layouts.app_admin')

@section('title') 
    {{'Create'}}
@endsection

@section('content')
      <div class="main-content-part">
         <div class="main-content-padd">
            <div class="title-w-arrow">
               <span><img src="images/grey-big-arrow.png"/></span>
               <h1 class="mr20">Classic RT</h1>
               <a href="#" class="badge green">Active</a>
               <div class="top-btn-sec"><a href="#">Done</a></div>
            </div>
            <div class="profile-main-sec">
               <div class="row mt-5">
                  <div class="col-md-2">
                     <div class="photo-upload-sec">
                        <figure><img src="images/image-upload.png"/></figure>
                        <button type="submit" class="upload-btn">Upload</button>
                     </div>
                  </div>
                  <div class="col-md-10">
                     <div class="from-group w100">
                        <label>Tittle</label>
                        <input type="text" name="product name" />
                     </div>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="from-group">
                              <label>SKU</label>
                              <input type="text" name="sku" />
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="from-group">
                              <label>Brand</label>
                              <div class="droup-select">
                                 <select class="form-control">
                                    <option>Brand</option>
                                    <option>Brand 1</option>
                                    <option>Brand 2</option>
                                    <option>Brand 3</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="from-group">
                              <label>Product Status</label>
                              <div class="droup-select">
                                 <select class="form-control">
                                    <option>Active</option>
                                    <option>Inactive</option>
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-4">
                           <div class="from-group">
                              <label>Price</label>
                              <div class="input-text"><span>₹</span>
                                 <input type="text" name="price" />
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="from-group">
                              <label>Discount</label>
                              <div class="input-text"><span>%</span>
                                 <input type="text" name="discount" />
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="from-group">
                              <label>Tax</label>
                              <div class="input-text"><span>%</span>
                                 <input type="text" name="discount" />
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="from-group w100 pack-size">
                        <label>Pack Size</label>
                        <div class="pack-badge"><a href="#" class="badge green-active">10</a><a href="#" class="badge">20</a></div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
@endsection