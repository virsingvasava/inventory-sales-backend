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


class RequestQtyController extends Controller
{
    public function index(Request $request) 
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $kiosk_list = Kiosk::where('status', '!=', FALSE)
        ->where('city_id', $user->city_id)->get();

        $product = [];
  $product = DB::select('SELECT stocks.*,brand.name as brand_name, products.name as product_name, products.price, products.packge_size, products.id as productId, "'.$kiosk_list[0]->id.'" as kioskId   
            FROM `brand` 
            LEFT JOIN products on products.brand_id = brand.id
            LEFT JOIN stocks on stocks.product_id = products.id AND stocks.kiosk_id = ?
            where stocks.requested_qty > 0 AND stocks.requested_qty IS NOT NULL', [$kiosk_list[0]->id]); if(count($kiosk_list)){
          
        }

        return view('airport_manager.requested_qty.index',compact('product', 'user_detail', 'kiosk_list'));
    }


    public function search_filter_req_qty(Request $request)
    {

        $product = [];

        if($request->has('kioskId')){     
       
            $product = DB::select('SELECT IFNULL(stocks.requested_qty, 0) as requested_qty, stocks.qty, brand.name as brand_name, products.name as product_name, products.price, products.packge_size, products.id as productId, "'.$request->kioskId.'" as kioskId   
            FROM `brand` 
            LEFT JOIN products on products.brand_id = brand.id
            LEFT JOIN stocks on stocks.product_id = products.id
            WHERE stocks.requested_qty > 0 AND stocks.kiosk_id = ?', [$request->kioskId]);
        } 
        $kioskId = $request->kioskId;
        
        return view('airport_manager.requested_qty.req_qty_table',compact('product', 'kioskId'));

    }

    public function approved_update(Request $request)
    {
        $qtyApproved = Stock::where(['kiosk_id' => $request->kioskId, 'product_id' => $request->productId])->first();

        if(!empty($qtyApproved)){
            $qtyApproved->qty += $request->requested_qty;
            $qtyApproved->requested_qty = FALSE;
            $qtyApproved->save();
            $message = 'Qty Approved Successfully';
            return response()->json(['success' => 'Qty Approved Successfully'], 200);
        }
    }

}