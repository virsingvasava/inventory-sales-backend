<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stock;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Auth;
use App\Models\Kiosk;
use DB;

class SalesHistoryController extends Controller
{

    public function index(Request $request) 
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $brands = Brand::where('status', '!=', FALSE)->get();
        
        $sales_history =  DB::table('order_items')
        ->join('orders', 'order_items.order_id', '=', 'orders.id')
        ->join('products', 'order_items.product_id', '=', 'products.id')
        ->join('brand', 'products.brand_id', '=', 'brand.id')
        ->select('brand.name as brand_name', 'products.name as product_name','products.price', 'products.packge_size', 'order_items.qty')
        ->where('order_items.user_id', $user->id)
        ->get();

        return view('salesman.sales_history.index',compact('brands', 'sales_history'));
    }

    public function search(Request $request)
    {
        //p($request->all());

        $products = [];

        if($request->has('stock_id')){
           
            $products =  DB::table('stocks')
            ->join('products', 'stocks.product_id', '=', 'products.id')
            ->join('brand', 'products.brand_id', '=', 'brand.id')
            ->select('stocks.*', 'brand.name as brand_name', 'products.name as product_name','products.price', 'products.packge_size', 'order_items.qty')
            ->where('kiosk_id',$request->stock_id)
            ->get();

        }  
        return response()->json(['products' => $products]);
    }



}
