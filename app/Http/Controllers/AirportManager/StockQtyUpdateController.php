<?php

namespace App\Http\Controllers\AirportManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stock;
use App\Models\Brand;
use App\Models\Product;
use Auth;
use App\Models\Kiosk;
use DB;

class StockQtyUpdateController extends Controller
{
    public function index(Request $request) 
    {

        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $kiosk_list = Kiosk::where('status', '!=', FALSE)
        ->where('city_id', $user->city_id)->get();


        $requestKioskId = request();
        $reqKioskId = $requestKioskId->kiosk_id;

        $kioskList = Kiosk::where('id', $reqKioskId)
        ->where('city_id', $user->city_id)->first();



        $product = [];
        if(count($kiosk_list)){
            $product = DB::select('SELECT stocks.*,brand.name as brand_name, products.name as product_name, products.price, products.packge_size, products.id as productId, "'.$kiosk_list[0]->id.'" as kioskId   
            FROM `brand` 
            LEFT JOIN products on products.brand_id = brand.id
            LEFT JOIN stocks on stocks.product_id = products.id AND stocks.kiosk_id = ?', [$kiosk_list[0]->id]);
        }
        
        $ids = $kiosk_list[0]->id; 
        return view('airport_manager.stock_qty_update.index',compact('product', 'user_detail', 'kiosk_list', 'ids', 'kioskList'));


    }

    public function qty_status_update(Request $request)
    {      

        $status_update = Stock::where(['kiosk_id' => $request->kioskId, 'product_id' => $request->productId])->first();

        if(!empty($status_update)){

            $status_update->qty = $request->quantity;
            $status_update->requested_qty = FALSE;
            $status_update->save();

            return response()->json(['data' => $status_update, 'success' => 'Qty update Successfully']);

        } else {

            $insert_stock  = new Stock();
            $insert_stock->kiosk_id = $request->kioskId;
            $insert_stock->product_id = $request->productId;
            $insert_stock->qty = $request->quantity;
            $insert_stock->requested_qty = FALSE;
            $insert_stock->status = TRUE;
            $insert_stock->save();

            return response()->json(['data' => $insert_stock, 'success' => 'Qty update Successfully']);
        }

    }
    
    public function search(Request $request)
    {        
        $product = [];

        if($request->has('kioskId')){     
            $product = DB::select('SELECT stocks.*,
            brand.name as brand_name, 
            products.name as product_name, 
            products.price, products.packge_size, 
            products.id as productId   
            FROM `brand` 
            LEFT JOIN products on products.brand_id = brand.id
            LEFT JOIN stocks on stocks.product_id = products.id AND stocks.kiosk_id = ?', [$request->kioskId]);
        } 
        $kioskId = $request->kioskId;

        return view('airport_manager.stock_qty_update.stock_table',compact('product', 'kioskId'));
    }
}
