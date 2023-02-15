<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Brand;
use App\Models\Stock;
use App\Models\Product;
use App\Models\City;
use App\Models\Kiosk;
use App\Models\OutletLocation;
use Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {        
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();
        $greeting_message = greeting_message();

        $currentYearFirstDay = date('Y-m-d H:i:s',strtotime(date('Y-01-01')));
        $currentDay = date('Y-m-d H:i:s');
        $lastYearFirstDay = date("Y-m-d 00:00:00",strtotime("last year January 1st"));
        $lastYearLastDay = date("Y-m-d 23:59:59",strtotime("last year December 31st"));

        #Bar Chart
        $barChartArr = [];
        $brands = Brand::get()->toArray();
        if(!empty($brands) && count($brands) > 0)
        {
            foreach($brands as $key => $value)
            {
                $getProductArr = Product::where('brand_id',$value['id'])->pluck('id')->toArray();

                $lastYearCount = OrderItem::whereBetween('created_at',[$lastYearFirstDay,$lastYearLastDay]);
                $lastYearCount = $lastYearCount->whereIn('product_id',$getProductArr);
                $lastYearCount = $lastYearCount->sum('qty');

                $firstYearCount = OrderItem::whereIn('product_id',$getProductArr);
                $firstYearCount = $firstYearCount->whereBetween('created_at',[$currentYearFirstDay,$currentDay]);
                $firstYearCount = $firstYearCount->sum('qty');

                $barChartArr[$key]['y'] = $value['name'];
                $barChartArr[$key]['a'] = $firstYearCount;
                $barChartArr[$key]['b'] = $lastYearCount;
            }
        }
        $barChart = json_encode($barChartArr);
           
        #Total Sale
        $total_sale = OrderItem::sum('total_amount');;
        $curYear = OrderItem::whereBetween('created_at',[$currentYearFirstDay,$currentDay])->sum('total_amount');
        $lastYear = OrderItem::whereBetween('created_at',[$lastYearFirstDay,$lastYearLastDay])->sum('total_amount');

        $subCal = $curYear - $lastYear / 100; 
        // dd(abs($subCal));
        // $divideCal = ($subCal / 90);
        // $finalCal = 100 * $divideCal;
        $total_sale_percentage = $subCal;

        #Average Kiosk Sale
        $average_kiosk_sale = 0;
        $average_kiosk_sale_percentage = 0;

        #Total Transaction Counts
        $total_transaction_counts = 0;
        $total_transaction_counts_percentage = 0;

        #Pack Sold
        $pack_sold = 0;
        $pack_sold_percentage = 0;

        #Sales History
        $sales_history = Order::where('sale_by_user_id', 2)
        ->with(['order_item_details'])->get();

        return view('salesman.dashboard', compact('total_sale', 'average_kiosk_sale','total_transaction_counts','pack_sold', 'sales_history', 'barChart', 'total_sale_percentage', 'average_kiosk_sale_percentage', 'total_transaction_counts_percentage', 'pack_sold_percentage'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message','Your are logout successfully');
    }
}
