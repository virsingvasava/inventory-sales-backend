<?php

namespace App\Http\Controllers\AirportManager;

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
use DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();
        $greeting_message = greeting_message();

        $currentYearFirstDay = date('Y-m-d H:i:s',strtotime(date('Y-01-01')));
        $currentDay = date('Y-m-d H:i:s');
        $lastYearFirstDay = date("Y-m-d 00:00:00",strtotime("last year January 1st"));
        $lastYearLastDay = date("Y-m-d 23:59:59",strtotime("last year December 31st"));

        //Quarterly graph started
        $fQStartDate = date('Y-m-d H:i:s',strtotime(date('Y-01-01')));
        $fQEndDate = date('Y-m-d H:i:s',strtotime(date('Y-01-31')));

        $sQStartDate = date('Y-m-d H:i:s',strtotime(date('Y-04-01')));
        $sQEndDate = date('Y-m-d H:i:s',strtotime(date('Y-06-30')));

        $tQStartDate = date('Y-m-d H:i:s',strtotime(date('Y-07-01')));
        $tQEndDate = date('Y-m-d H:i:s',strtotime(date('Y-09-30')));

        $ftQStartDate = date('Y-m-d H:i:s',strtotime(date('Y-10-01')));
        $ftQEndDate = date('Y-m-d H:i:s',strtotime(date('Y-12-31')));

        $city_id = $user_detail->city_id;

        $KiosksList = Kiosk::where('city_id',$city_id)->pluck('id')->toArray();

        $fQSale = Order::whereIn('kiosk_id',$KiosksList)->whereBetween('created_at',[$fQStartDate,$fQEndDate])->sum('total_amount');
        $sQSale = Order::whereIn('kiosk_id',$KiosksList)->whereBetween('created_at',[$sQStartDate,$sQEndDate])->sum('total_amount');
        $tQSale = Order::whereIn('kiosk_id',$KiosksList)->whereBetween('created_at',[$tQStartDate,$tQEndDate])->sum('total_amount');
        $ftQSale = Order::whereIn('kiosk_id',$KiosksList)->whereBetween('created_at',[$ftQStartDate,$ftQEndDate])->sum('total_amount');

        $totalYearPrice = $fQSale + $sQSale + $tQSale + $ftQSale;

        $quarterArr = [ 'first' => $fQSale, 'second' => $sQSale, 'third' => $tQSale, 'fourth' => $ftQSale, 'totalYearPrice' => $totalYearPrice];
        //Quarterly graph Ended

        return view('airport_manager.dashboard.dashboard', compact('quarterArr','greeting_message','user_detail'));
    }

    public function dashboard_ajax(Request $request)
    {   
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $startDate = date('Y-m-d H:i:s',strtotime($request->start_date));
        $endDate = date('Y-m-d H:i:s',strtotime($request->end_date));

        $totalUsersCount = User::where('city_id',$user_detail->city_id);
        $totalUsersCount = $totalUsersCount->whereBetween('created_at',[$startDate,$endDate]);
        $totalUsersCount = $totalUsersCount->count();

        $activatedUserCount = User::where('city_id',$user_detail->city_id);
        $activatedUserCount = $activatedUserCount->where('status',1);
        $activatedUserCount = $activatedUserCount->whereBetween('created_at',[$startDate,$endDate]);
        $activatedUserCount = $activatedUserCount->count();

        $KiosksList = Kiosk::where('city_id',$user_detail->city_id)->pluck('id');

        $orders = Order::whereIn('kiosk_id',$KiosksList)->whereBetween('created_at',[$startDate,$endDate])->get();

        $requestedQuentity = 0;
        if(!empty($orders) && count($orders) > 0)
        {
            foreach($orders as $key => $value)
            {
                $qtyAmount = OrderItem::where('order_id',$value->id)->sum('qty');
                $requestedQuentity = $requestedQuentity + $qtyAmount;
            }
        }

        $requestedStock = Stock::whereIn('kiosk_id',$KiosksList);
        $requestedStock = $requestedStock->whereBetween('created_at',[$startDate,$endDate]);      
        $requestedStock = $requestedStock->sum('requested_qty');

        return view('airport_manager.dashboard.dashboard_ajax',compact('totalUsersCount','activatedUserCount','requestedQuentity','requestedStock'));
    }

    public function ajax_sales_by_brand_city(Request $request)
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $KiosksList = Kiosk::where('city_id',$user_detail->city_id)->pluck('id')->toArray();

        $currentYearFirstDay = date('Y-m-d H:i:s',strtotime(date('Y-01-01')));
        $currentDay = date('Y-m-d H:i:s');
        $lastYearFirstDay = date("Y-m-d 00:00:00",strtotime("last year January 1st"));
        $lastYearLastDay = date("Y-m-d 23:59:59",strtotime("last year December 31st"));

        // Bar Chart code started
        $barChartArr = [];
        $brands = Brand::get()->toArray();
        if(!empty($brands) && count($brands) > 0)
        {
            foreach($brands as $key => $value)
            {
                $orders = Order::whereIn('kiosk_id',$KiosksList)->get();

                $orderIdArr = [];
                if(!empty($orders) && count($orders) > 0)
                {
                    foreach($orders as $k => $v)
                    {
                        if(!in_array($v->order_id, $orderIdArr))
                        {
                            $orderIdArr[] = $v->order_id;
                        }
                    }
                }

                $getProductArr = Product::where('brand_id',$value['id'])->pluck('id')->toArray();

                $lastYearCount = OrderItem::whereBetween('created_at',[$lastYearFirstDay,$lastYearLastDay])->whereIn('order_id',$orderIdArr)->whereIn('product_id',$getProductArr)->sum('qty');

                $firstYearCount = OrderItem::whereIn('product_id',$getProductArr);
                $firstYearCount = $firstYearCount->whereIn('order_id',$orderIdArr)->whereBetween('created_at',[$currentYearFirstDay,$currentDay]);
                $firstYearCount = $firstYearCount->sum('qty');

                $barChartArr[$key]['y'] = $value['name'];
                $barChartArr[$key]['a'] = $firstYearCount;
                $barChartArr[$key]['b'] = $lastYearCount;
            }
        }
        $barChart = json_encode($barChartArr);

        return view('airport_manager.dashboard.sales_by_brand', compact('barChart'));
    }

    public function ajax_purchase_behaviour(Request $request)
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $KiosksList = Kiosk::where('city_id',$user_detail->city_id)->pluck('id')->toArray();

        $startDate = date('Y-m-d H:i:s',strtotime($request->start_date));
        $endDate = date('Y-m-d H:i:s',strtotime($request->end_date));

        $orderIds = Order::whereIn('kiosk_id',$KiosksList)->whereBetween('created_at',[$startDate,$endDate])->pluck('id')->toArray();


        $singlePackUnit = OrderItem::where('qty',1)->whereIn('order_id',$orderIds)->count();
        $singlePackTotal = OrderItem::where('qty',1)->whereIn('order_id',$orderIds)->sum('total_amount');

        $towPackUnit = OrderItem::whereBetween('qty',[2,4])->whereIn('order_id',$orderIds)->count();
        $towPackTotal = OrderItem::whereBetween('qty',[2,4])->whereIn('order_id',$orderIds)->sum('total_amount');

        $fivePackUnit = OrderItem::whereBetween('qty',[5,7])->whereIn('order_id',$orderIds)->count();
        $fivePackTotal = OrderItem::whereBetween('qty',[5,7])->whereIn('order_id',$orderIds)->sum('total_amount');

        $eightPackUnit = OrderItem::whereBetween('qty',[8,10])->whereIn('order_id',$orderIds)->count();
        $eightPackTotal = OrderItem::whereBetween('qty',[8,10])->whereIn('order_id',$orderIds)->sum('total_amount');

        $tenPackUnit = OrderItem::where('qty','>',10)->whereIn('order_id',$orderIds)->count();
        $tenPackTotal = OrderItem::where('qty','>',10)->whereIn('order_id',$orderIds)->sum('total_amount');

        $packageArr = ['singlePackUnit' => $singlePackUnit, 'singlePackTotal' => $singlePackTotal, 'towPackUnit' => $towPackUnit, 'towPackTotal' => $towPackTotal, 'fivePackUnit' => $fivePackUnit, 'fivePackTotal' => $fivePackTotal, 'eightPackUnit' => $eightPackUnit, 'eightPackTotal' => $eightPackTotal, 'tenPackUnit' => $tenPackUnit, 'tenPackTotal' => $tenPackTotal ];
        //Package wise graph End

        return view('airport_manager.dashboard.purchase_behaviour', compact('packageArr'));
    }

    public function ajax_sold_brand(Request $request)
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $KiosksList = Kiosk::where('city_id',$user_detail->city_id)->pluck('id')->toArray();

        $startDate = date('Y-m-d H:i:s',strtotime($request->start_date));
        $endDate = date('Y-m-d H:i:s',strtotime($request->end_date));

        $SoldBrands = Brand::select('id','name')->get()->toArray();
        if(!empty($SoldBrands) && count($SoldBrands) > 0)
        {
            foreach($SoldBrands as $key => $value)
            {
                $orderIdArr = [];
                $orders = Order::whereIn('kiosk_id',$KiosksList)->get();
                if(!empty($orders) && count($orders) > 0)
                {
                    foreach($orders as $k => $v)
                    {
                        if(!in_array($v->order_id, $orderIdArr))
                        {
                            $orderIdArr[] = $v->order_id;
                        }
                    }
                }

                $getProductArr = Product::where('brand_id',$value['id'])->pluck('id')->toArray();
                $soldItems = OrderItem::whereIn('product_id',$getProductArr);
                $soldItems = $soldItems->whereIn('order_id',$orderIdArr);
                $soldItems = $soldItems->whereBetween('created_at',[$startDate,$endDate]);
                $soldItems = $soldItems->sum('qty');
                $SoldBrands[$key]['sold_items'] = $soldItems;
                $SoldBrands[$key]['percentage'] = rand(2,15);
                if($soldItems == 0)
                {
                    $SoldBrands[$key]['percentage'] = 0;
                }
            }

            $sortArr = array_column($SoldBrands, 'sold_items');
            array_multisort($sortArr, SORT_DESC, $SoldBrands);

            $SoldBrands = array_slice($SoldBrands, 0, 4);
        }

        return view('airport_manager.dashboard.sold_brand', compact('SoldBrands'));
    }

    public function ajax_sales_by_location(Request $request)
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $startDate = date('Y-m-d H:i:s',strtotime($request->start_date));
        $endDate = date('Y-m-d H:i:s',strtotime($request->end_date));

        //Sales by Outlet Location Start

        $OutletLocation = OutletLocation::get()->toArray();
        if(!empty($OutletLocation) && count($OutletLocation) > 0)
        {
            foreach($OutletLocation as $key => $value)
            {
                $Kiosks = Kiosk::where('outlet_location_id',$value['id']);
                $Kiosks = $Kiosks->where('city_id',$user_detail->city_id)->get()->toArray();

                $priceArr = []; $qtyArr = [];
                if(!empty($Kiosks) && count($Kiosks) > 0)
                {
                    foreach($Kiosks as $k => $v)
                    {
                        $orders = Order::where('kiosk_id',$v['id'])->pluck('id')->toArray();
                        $ordersPrice = OrderItem::whereIn('order_id',$orders)->whereBetween('created_at',[$startDate,$endDate])->sum('price');
                        $ordersQuentity = OrderItem::whereIn('order_id',$orders)->whereBetween('created_at',[$startDate,$endDate])->sum('qty');

                        $priceArr[] = $ordersPrice;
                        $qtyArr[] = $ordersQuentity;
                    }
                }

                $OutletLocation[$key]['total_amount'] = array_sum($priceArr);
                $OutletLocation[$key]['total_qty'] = array_sum($qtyArr);
            }
        }
        //Sales by Outlet Location  End

        return view('airport_manager.dashboard.sales_by_location', compact('OutletLocation'));
    }

    public function salesDashboard(Request $request)
    {
        $products = Product::orderBy('name','ASC')->get();

        return view('airport_manager.dashboard.sales',compact('products'));
    }

    public function salesDashboardPost(Request $request)
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $KiosksList = Kiosk::where('city_id',$user_detail->city_id)->pluck('id')->toArray();

        $startDate = date('Y-m-d H:i:s',strtotime($request->start_date));
        $endDate = date('Y-m-d H:i:s',strtotime($request->end_date));

        $orderIds = Order::whereBetween('created_at',[$startDate,$endDate]);
        $orderIds = $orderIds->whereIn('kiosk_id',$KiosksList)->pluck('id')->toArray();

        $totalSale = OrderItem::whereIn('order_id',$orderIds);
        if(isset($request->product_id) && $request->product_id != "")
        {
            $totalSale = $totalSale->where('product_id',$request->product_id);            
        }
        $totalSale = $totalSale->sum('total_amount');

        $totalTrns = OrderItem::whereIn('order_id',$orderIds);
        if(isset($request->product_id) && $request->product_id != "")
        {
            $totalTrns = $totalTrns->where('product_id',$request->product_id);            
        }
        $totalTrns = $totalTrns->count();

        $soldPacks = OrderItem::whereIn('order_id',$orderIds);
        if(isset($request->product_id) && $request->product_id != "")
        {
            $soldPacks = $soldPacks->where('product_id',$request->product_id);
        }
        $soldPacks = $soldPacks->sum('qty');

        $totalKiosk = Order::whereBetween('created_at',[$startDate,$endDate]);
        $totalKiosk = $totalKiosk->groupBy('kiosk_id')->count();

        $averageKioskSale = ($totalSale * $totalKiosk) / 100;

        $averageKioskSale = number_format($averageKioskSale,2);
        $totalSale = number_format($totalSale,2);

        $query = "SELECT sum(`qty`) AS qty, DAY(`created_at`) AS day,MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        $query .= " where `created_at` between '".$startDate."' AND '".$endDate."'";
        if(isset($request->product_id) && $request->product_id != "")
        {
            $query .= " AND product_id = ".$request->product_id;
        }
        $query .= " GROUP BY DAY(`created_at`), MONTH(`created_at`), YEAR(`created_at`)";

        // echo $query;

        // Sales Chart started
        $SalesChart = DB::Select($query);

        $timePeriodArr = [];
        $qtyArr = []; 
        if(!empty($SalesChart) && count($SalesChart) > 0)
        {
            foreach($SalesChart as $key => $v)
            {
                $qtyArr[] = $v->qty;

                $day  = $v->day;
                $monthNum  = $v->month;
                $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
                $timePeriodArr[] = $day." ".$monthName;
            }
        }

        $categories = json_encode($timePeriodArr);
        $qtyData = json_encode($qtyArr);

        // Sales Chart Ended

        // Sales History Started

        $sql = "SELECT MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        $sql .= " where `created_at` between '".$startDate."' AND '".$endDate."'";
        if(isset($request->product_id) && $request->product_id != "")
        {
            $sql .= " AND product_id = ".$request->product_id;
        }
        $sql .= " GROUP BY MONTH(`created_at`), YEAR(`created_at`)";

        $SalesHistory = DB::Select($sql);

        $historyArr = [];
        if(!empty($SalesHistory) && count($SalesHistory) > 0)
        {
            foreach($SalesHistory as $key => $value)
            {
                $monthNum  = $value->month;
                $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
                $MonthYear = $monthName."-".$value->year;
                $Converted = date('m-Y', strtotime($MonthYear));

                $totalOrders = OrderItem::whereMonth('created_at',$monthNum);
                $totalOrders = $totalOrders->whereYear('created_at',$value->year);
                $totalOrders = $totalOrders->whereIn('order_id',$orderIds);
                if(isset($request->product_id) && $request->product_id != "")
                {
                    $totalOrders = $totalOrders->where('product_id',$request->product_id);
                }
                $totalOrders = $totalOrders->groupBy('order_id');
                $totalOrders = $totalOrders->count();

                $grossSales = OrderItem::whereMonth('created_at',$monthNum);
                $grossSales = $grossSales->whereYear('created_at',$value->year);
                $grossSales = $grossSales->whereIn('order_id',$orderIds);
                if(isset($request->product_id) && $request->product_id != "")
                {
                    $grossSales = $grossSales->where('product_id',$request->product_id);
                }
                $grossSales = $grossSales->sum('total_amount');

                $historyArr[$key]['period'] = date('F Y', strtotime($MonthYear));
                $historyArr[$key]['total_orders'] = $totalOrders;
                $historyArr[$key]['gross_sales'] = number_format($grossSales,2);
                $historyArr[$key]['total_sales'] = number_format($grossSales,2);
            }
        }

        return view('airport_manager.dashboard.sales_ajax',compact('totalSale','averageKioskSale','totalTrns','soldPacks','qtyData','categories','historyArr'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message','Your are logout successfully');
    }
}
