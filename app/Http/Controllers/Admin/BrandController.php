<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index() 
    {
        $products = Product::where('status', TRUE)->orderBy('id', 'DESC')->get();
        return view('admin.brand.index',compact('products'));
    }

    public function create()
    {
        return view('admin.brand.create');
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

    public function product_details($id){

        $products = Product::where(['status' => TRUE, 'brand_id' => $id])->orderBy('id', 'DESC')->get();        
        return view('admin.brand.index',compact('products'));
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
}
