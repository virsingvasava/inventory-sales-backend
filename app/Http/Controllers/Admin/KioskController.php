<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\OutletLocation;
use App\Models\Kiosk;
use App\Models\Brand;
use App\Imports\KioskImport;
use App\Exports\KioskExport;
use App\Exports\ExportKioskData;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use DataTables;
use App\Models\User;
use Auth;

class KioskController extends Controller
{
    public function index(Request $request) 
    {        
        $kiosk_obj = Kiosk::with('city_name', 'outlet_location')->where('status', TRUE)->get();       
        $cityArray = City::where('status', TRUE)->get();
        return view('admin.kiosk.index',compact('kiosk_obj', 'cityArray'));
    }

    public function create()
    {
        $kiosk = Kiosk::get()->count();
        $kiosk_id = $kiosk+true;
        $kiosk_genrateId = 'KOS_'.$kiosk_id;

        $city = City::where('status', TRUE)->get();
        $location = OutletLocation::where('status', TRUE)->get();
        return view('admin.kiosk.create',compact('kiosk_genrateId', 'city', 'location'));
    }

    public function store(Request $request)
    { 
        $store = new Kiosk;
        $store->kiosk_name = $request->kisok_name;
        $store->kiosk_id = $request->kiosk_id;
        $store->outlet_location_id = $request->location_id;
        $store->airport = $request->airport;
        $store->city_id = $request->city_id;
        $store->status = $request->status;
        $store->save();
        
        return redirect()->route('admin.kiosk.index')->with('message','Kiosk added Successfully');
    }

    public function view($id)
    {
        $view = Kiosk::where('id',$id)->first();
        $brands = Brand::where('status', '!=', FALSE)->get();

        $products1 =  DB::table('brand')
        ->leftJoin('products', 'brand.id', '=', 'products.brand_id')
        ->leftJoin('stocks', 'stocks.product_id', '=', 'products.id')
        ->select('stocks.*','brand.name as brand_name', 'products.name as product_name','products.price', 'products.packge_size', 'products.id as productId')
        ->where('stocks.kiosk_id', $id)
        ->where('stocks.qty', '>=', 0)
        ->get();
            
        
        $products = DB::select('SELECT stocks.*,brand.name as brand_name, products.name as product_name, products.price, products.packge_size, products.id as productId, "'.$id.'" as kioskId   
        FROM `brand` 
        LEFT JOIN products on products.brand_id = brand.id
        LEFT JOIN stocks on stocks.product_id = products.id AND stocks.kiosk_id = ?', [$id]);
        
        $sales_history =  DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->where('kiosk_id', $id)
        ->get();

        return view('admin.kiosk.view',compact('view', 'id', 'brands','products', 'sales_history'));
    }

    public function edit($id)
    {
        $city = City::where('status', TRUE)->get();
        $location = OutletLocation::where('status', TRUE)->get();
        $edit = Kiosk::where('id',$id)->first();
        return view('admin.kiosk.edit',compact('edit', 'city', 'location'));
    }

    public function update(Request $request)
    {
        $update = Kiosk::where('id', $request->kioskId)->first();
        $update->kiosk_name = $request->kiosk_name;
        $update->kiosk_id = $request->Kiosk_id;
        $update->outlet_location_id = $request->location_id;
        $update->airport = $request->airport;
        $update->city_id = $request->city_id;
        $update->status = $request->status;
        $update->save();

        return redirect()->route('admin.kiosk.index')->with('message','Kiosk update Successfully');
    }

    public function destroy(Request $request)
    {   
        $id = $request->kioskId;
        Kiosk::where('id',$id)->delete();
        return redirect()->route('admin.kiosk.index')->with('message','Kiosk deleted Successfully');

    }

  
    public function kiosk_status_update(Request $request)
    {
        $status_update = Kiosk::where('id',$request->brand_id)->first();
        $status_update->status = $request->status;
        $status_update->save();
        return redirect()->route('admin.kiosk.index')->with('message','Kiosk status updated Successfully');
    }

    public function search_filter(){

        $project->where('categorie', 'like', '%' . request('categorie') . '%');

        $kiosk_obj = Kiosk::with('city_name', 'outlet_location')->where('status', TRUE)->get();        
        return view('admin.kiosk.index',compact('kiosk_obj'));
    }

    public function kioskImport(Request $request)
    {   
       Excel::import(new KioskImport, $request->file('kiosk_import')->store('temp'));
       return redirect()->route('admin.kiosk.index')->with('message','Kiosk Import Successfully');

    }

    public function kioskExport(Request $request) 
    {
        return Excel::download(new KioskExport(), 'sample_import_kiosk.xls');
    }

    public function export_listing_data(Request $request) 
    {
        $file_name = 'export_kiosk'.date('Y_m_d_H_i_s').'.csv'; 
        return Excel::download(new ExportKioskData, $file_name);
    }

    public function product_list_search(Request $request)
    {
        $brands = [];

        if($request->has('brand_id')){
           
            $brands =  DB::table('orders')
            ->distinct()
            ->join('kiosk', 'orders.kiosk_id', '=', 'kiosk.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('city', 'kiosk.city_id', '=', 'city.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('brand', 'products.brand_id', '=', 'brand.id')
            ->select('brand.*', 'products.name as product_name','products.price',
                'products.packge_size', 'order_items.qty')
            ->where('brand.id',$request->brand_id)
            ->where(['orders.kiosk_id' => $request->kiosk_id])
            ->where('city.id', $request->city_id)
            ->get();
        
        }  
        return response()->json(['brands' => $brands]);
    }


    public function payment_mode_search(Request $request)
    {

        $payments_mode = [];
        
        if($request->has('payment_mode_type')){
           
            $payments_mode =  DB::table('orders')
            ->distinct()
            ->join('kiosk', 'orders.kiosk_id', '=', 'kiosk.id')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('city', 'kiosk.city_id', '=', 'city.id')
            ->where('orders.payment_mode', $request->payment_mode_type)
            ->where('orders.kiosk_id', $request->kiosk_id)
            ->where('city.id', $request->city_id)
            ->get();
        }  
        return response()->json(['payments_mode' => $payments_mode]);
    }



}

