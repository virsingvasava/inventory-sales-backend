<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Brand;
use App\Imports\ImportProduct;
use App\Exports\ProductExport;


use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;


class ProductController extends Controller
{
    public function index() 
    {
        $brand = Brand::where('status', TRUE)->orderBy('id', 'ASC')->get();
        return view('admin.product.index',compact('brand'));
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    { 
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->save();
    
        return redirect()->route('admin.product.index')->with('message','Brand added Successfully');
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $view = User::where('id',$id)->first();
        return view('admin.inventory.view',compact('view'));
    }

    public function edit($id)
    {
        $id = base64_decode($id);
        $edit_inventory = User::where('id',$id)->first();
        return view('admin.inventory.edit',compact('edit_inventory'));

    }

    public function update(Request $request)
    {
        $brand_update = Brand::where('id',$request->id)->first();
        $brand_update->name = $request->name;
        $brand_update->status = $request->status;
        $brand_update->save();
        return redirect()->route('admin.product.index')->with('message','Brand updated Successfully');
    }

    public function destroy(Request $request)
    {
        $id = $request->brand_id;
        Brand::where('id',$id)->delete();
        return redirect()->route('admin.product.index')->with('message','Brand deleted Successfully');

    }

    public function brand_status_update(Request $request)
    {
        $status_update = Brand::where('id',$request->brand_id)->first();
        $status_update->status = $request->status;
        $status_update->save();
        return redirect()->route('admin.product.index')->with('message','Brand status update Successfully');
    }


    public function productIndex($id){

        $products = Product::with('brand_name')->where('brand_id', $id)->orderBy('id', 'DESC')->get();
        $brand = Brand::where('id', $id)->first();
        return view('admin.product.product_index',compact('products', 'id', 'brand'));
    }

    public function productCreate($id)
    {
        $brand = Brand::where('id', $id)->first();
        $brand_list = Brand::where('status', TRUE)->get();

        $product = Product::where('brand_id', $id)->get()->count();
        $productId = $product+true;
        $productSkuId = 'C_'.$productId;

        return view('admin.product.product_create', compact('id', 'brand', 'brand_list', 'productSkuId'));
    }

    public function productStore(Request $request)
    { 
        $brandId = $request->brand_id;
        $add = new Product;

        /*
        if ($request->product_picture) {
            $product_picture = $request->product_picture;

            $destination = public_path("assets/product_picture");
            if(!is_dir($destination)){
                mkdir($destination, 0777, true);
            }
            $name = 'product_picture_' . time();
            $product_pictureName = $name . '.' . $product_picture->getClientOriginalExtension();
            
            $product_picture->move($destination, $product_pictureName);
        }

        $add->image = $product_pictureName;
        */
        $add->brand_id = $request->brand_id;
        $add->sku = $request->sku;
        $add->name = $request->product_name;
        $add->packge_size	= $request->package_size;
        $add->price = $request->price;
        // $add->discount = $request->discount;
        // $add->text = $request->tax_price;
        $add->status = $request->status;
        $add->save();
        return redirect()->route('admin.product.brand.index', $brandId)->with('message','Product added Successfully');
    }

    public function productEdit($id)
    {
        $edit = Product::where('id',$id)->first();
        $brand = Brand::where('id', $edit->brand_id)->first();
        $brand_list = Brand::where('status', TRUE)->get();
        return view('admin.product.product_edit',compact('edit', 'id', 'brand_list', 'brand'));

    }

    public function productUpdate(Request $request)
    {
        //p($request->all());

        $brandId = $request->brand_id;

        $update_product = Product::where('id',$request->id)->first();

        /*
        if ($request->product_picture) {
            $product_picture = $request->product_picture;
            $destination = public_path("assets/product_picture");
            if(!is_dir($destination)){
                mkdir($destination, 0777, true);
            }
            $name = 'product_picture_' . time();
            
            $product_pictureName = $name . '.' . $product_picture->getClientOriginalExtension();

            $product_picture->move($destination, $product_pictureName);
        
        }else{
            $product_pictureName = $update_product->image;
        } 

        $update_product->image = $product_pictureName;
        */
        $update_product->brand_id = $request->brand_id;
        $update_product->sku = $request->sku;
        $update_product->name = $request->product_name;
        $update_product->packge_size = $request->package_size;
        $update_product->price = $request->price;
        // $update_product->discount = $request->discount;
        // $update_product->text = $request->tax_price;
        $update_product->status = $request->status;
        $update_product->save();

        return redirect()->route('admin.product.brand.index', $brandId)->with('message','Product updated Successfully');
    }

    public function productView($id)
    {
        $view_product = Product::where('id',$id)->first();
        return view('admin.product.product_edit',compact('view_product', 'id'));
    }

    public function productDestroy(Request $request, $id)
    {
        $brandId = $request->brandId;
        $productId = $request->productId;
        Product::where('id',$productId)->delete();
        return redirect()->route('admin.product.brand.index', $brandId)->with('message','Product deleted Successfully');

    }

    public function productImport(Request $request, $id)
    {   
    
       Excel::import(new ImportProduct, $request->file('import_data')->store('temp'));
       return redirect()->route('admin.product.brand.index', $id)->with('message','Product Import Successfully');

    }

    public function productExport(Request $request) 
    {
        return Excel::download(new ProductExport(), 'sample_import_product.xls');

    }

    public function brand_product_delete(Request $request)
    { 
        $brandId = $request->brandId;
        Brand::where('id',$brandId)->delete();
        Product::where('brand_id',$brandId)->delete();
        return redirect()->route('admin.product.index')->with('message','Brand and products are deleted Successfully');

    }
    
}
