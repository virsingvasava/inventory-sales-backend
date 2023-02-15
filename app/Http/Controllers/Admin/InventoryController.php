<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreInventoryRequest;
use App\Models\User;

class InventoryController extends Controller
{
    public function index() 
    {
        $inventory = User::get();
        return view('admin.inventory.index',compact('inventory'));
    }

    public function create()
    {
        $inventory_create = User::get();
        return view('admin.inventory.create',compact('inventory_create'));
    }

    public function store(StoreInventoryRequest $request)
    { 
        $brand = new User;
        $brand->sub_category_id = $request->sub_category_id;
        $brand->name = $request->name;
        $brand->model = $request->model;
        $brand->slug = Str::slug($request->slug);
        $brand->status = $request->status;
        $brand->save();
        return redirect()->route('admin.inventory.index')->with('success', __('Inventory added successfully'));
    }

    public function view($id)
    {
        $id = base64_decode($id);
        $view_inventory = User::where('id',$id)->first();
        return view('admin.inventory.view',compact('view_inventory'));
    }

    public function edit($id)
    {
        $id = base64_decode($id);
        $edit_inventory = User::where('id',$id)->first();
        return view('admin.inventory.edit',compact('edit_inventory'));

    }

    public function update(Request $request)
    {
        $brand_update = User::where('id',$request->id)->first();
        $brand_update->sub_category_id = $request->sub_category_id;
        $brand_update->name = $request->name;
        $brand->model = $request->model;
        $brand_update->slug = Str::slug($request->slug);
        $brand_update->status = $request->status;
        $brand_update->save();
        return redirect()->route('admin.inventory.index')->with('success', __('Inventory updated successfully'));
    }

    public function destroy(Request $request)
    {
        $id = $request->brand_id;
        User::where('id',$id)->delete();
        return redirect()->route('admin.inventory.index')->with('success', __('Inventory deleted successfully'));

    }

    public function brand_status_update(Request $request)
    {
        $status_update = User::where('id',$request->brand_id)->first();
        $status_update->status = $request->status;
        $status_update->save();
        return redirect()->route('admin.inventory.index')->with('success', __('Inventory status update successfully'));
    }
}
