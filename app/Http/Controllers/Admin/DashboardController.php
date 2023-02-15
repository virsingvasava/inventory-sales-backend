<?php

namespace App\Http\Controllers\Admin;

use App\Exports\Export_oss;
use App\Exports\oss_export_alert;
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
use App\Exports\SalesHistoryExport;
use App\Exports\TotalSalesByRegion;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use App\Exports\KioskExport;
use App\Exports\oss_alert;
use App\Exports\purchase_behaviour_export;
use App\Exports\sales_by_loction_export;
use App\Exports\sales_day_export;
use App\Exports\sales_history;
use App\Exports\sales_month_export;
use App\Exports\TopTenKioskExport;
use Auth;
use DB;


use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {        
        $user = Auth::User();
        $user_detail = User::where('id', $user->id)->first();
        $greeting_message = greeting_message();

        $cityList = City::where('status', 1)->orderBy('name', 'ASC')->get();
        $ProductList = Product::where('status', 1)->orderBy('name', 'ASC')->get();

        $currentYearFirstDay = date('Y-m-d H:i:s', strtotime(date('Y-01-01')));
        $currentDay = date('Y-m-d H:i:s');
        $lastYearFirstDay = date("Y-m-d 00:00:00", strtotime("last year January 1st"));
        $lastYearLastDay = date("Y-m-d 23:59:59", strtotime("last year December 31st"));

        // Bar Chart code started
        $barChartArr = [];
        $brands = Brand::get()->toArray();
        if (!empty($brands) && count($brands) > 0) {
            foreach ($brands as $key => $value) {
                $getProductArr = Product::where('brand_id', $value['id'])->pluck('id')->toArray();

                $lastYearCount = OrderItem::whereBetween('created_at', [$lastYearFirstDay, $lastYearLastDay]);
                $lastYearCount = $lastYearCount->whereIn('product_id', $getProductArr);
                $lastYearCount = $lastYearCount->sum('qty');
                // dd($lastYearCount);

                $firstYearCount = OrderItem::whereIn('product_id', $getProductArr);
                $firstYearCount = $firstYearCount->whereBetween('created_at', [$currentYearFirstDay, $currentDay]);
                $firstYearCount = $firstYearCount->sum('qty');
                //dd($firstYearCount);

                $barChartArr[$key]['y'] = $value['name'];
                $barChartArr[$key]['a'] = $firstYearCount;
                $barChartArr[$key]['b'] = $lastYearCount;
            }
        }
        $barChart = json_encode($barChartArr);
        // dd($barChart);
        // Bar Chart code Ended

        //Top 10 Kiosks Started
        $topTenKioskArr = [];
        $Kiosks = Kiosk::with('single_city_name', 'outlet_location_single')->get()->toArray();
        if (!empty($Kiosks) && count($Kiosks) > 0) {
            foreach ($Kiosks as $key => $value) {
                $topTenKioskArr[$key]['name'] = trim($value['kiosk_name']);
                if ($value['single_city_name']) {
                    $topTenKioskArr[$key]['city'] = trim($value['single_city_name']['name']);
                }
                if ($value['outlet_location_single']) {
                    $topTenKioskArr[$key]['terminal'] = trim($value['outlet_location_single']['name']);
                }
                $orderCount = Order::where('kiosk_id', $value['id'])->count();
                $topTenKioskArr[$key]['order_count'] = $orderCount;
            }

            $sortArr = array_column($topTenKioskArr, 'order_count');
            array_multisort($sortArr, SORT_DESC, $topTenKioskArr);

            $topTenKioskArr = array_slice($topTenKioskArr, 0, 10);
        }
        //Top 10 Kiosks Ended

        //Quarterly graph started   
        
        $kioskDetails = Kiosk::where('airport', $request->kiosk_airport)->pluck('id');

        $orderDetails = Order::whereIn('kiosk_id', $kioskDetails)->pluck('id'); 

        $fQStartDate = date('Y-m-d', strtotime(date('Y-01-01')));
        $fQEndDate = date('Y-m-d', strtotime(date('Y-03-31')));

        $sQStartDate = date('Y-m-d', strtotime(date('Y-04-01')));
        $sQEndDate = date('Y-m-d', strtotime(date('Y-06-30')));

        $tQStartDate = date('Y-m-d', strtotime(date('Y-07-01')));
        $tQEndDate = date('Y-m-d', strtotime(date('Y-09-30')));

        $ftQStartDate = date('Y-m-d', strtotime(date('Y-10-01')));
        $ftQEndDate = date('Y-m-d', strtotime(date('Y-12-31')));

        $fQSale = OrderItem::whereBetween('created_at', [$fQStartDate, $fQEndDate])->sum('total_amount');
        $sQSale = OrderItem::whereBetween('created_at', [$sQStartDate, $sQEndDate])->sum('total_amount');
        $tQSale = OrderItem::whereBetween('created_at', [$tQStartDate, $tQEndDate])->sum('total_amount');
        $ftQSale = OrderItem::whereBetween('created_at', [$ftQStartDate, $ftQEndDate])->sum('total_amount');

        $totalYearPrice = $fQSale + $sQSale + $tQSale + $ftQSale;

        $quarterArr = ['first' => $fQSale, 'second' => $sQSale, 'third' => $tQSale, 'fourth' => $ftQSale, 'totalYearPrice' => $totalYearPrice];


        $totalHours = [
            '00:00:00 - 02:00:00',
            '02:00:01 - 04:00:00',
            '04:00:01 - 06:00:00',
            '06:00:01 - 08:00:00',
            '08:00:01 - 10:00:00',
            '10:00:01 - 12:00:00',
            '12:00:01 - 14:00:00',
            '14:00:01 - 16:00:00',
            '16:00:01 - 18:00:00',
            '18:00:01 - 20:00:00',
            '20:00:01 - 22:00:00',
            '22:00:01 - 24:00:00',
        ];

        $today = date('Y-m-d');
        // $today = '2022-09-28';

        $barChartNewArr = [];
        foreach ($totalHours as $h => $hour) {
            $explodeHours = explode('-', $hour);
            $startHour = trim($explodeHours[0]);
            $EndHour = trim($explodeHours[1]);

            $startDateTime = $today . ' ' . $startHour;
            $startDateTime = date('Y-m-d H:i:s', strtotime($startDateTime));

            $EndDateTime = $today . ' ' . $EndHour;
            $EndDateTime = date('Y-m-d H:i:s', strtotime($EndDateTime));

            $totalSum = OrderItem::whereBetween('created_at', [$startDateTime, $EndDateTime])->sum('qty');
            $totalOrder = OrderItem::whereBetween('created_at', [$startDateTime, $EndDateTime])->count();

            $barChartNewArr[$h]['y'] = date('h:i A', strtotime($startHour)) . ' - ' . date('h:i A', strtotime($EndHour));
            $barChartNewArr[$h]['a'] = $totalOrder;
            $barChartNewArr[$h]['b'] = $totalSum;
        }

        $barChartNewJson = json_encode($barChartNewArr);

        return view('admin.dashboard', compact('barChart', 'topTenKioskArr', 'quarterArr', 'greeting_message', 'user_detail', 'cityList', 'ProductList', 'barChartNewJson', 'Kiosks'));
    }

    public function ajax_top_ten_kiosk_export(Request $request)
    {
        return Excel::download(new TopTenKioskExport(), 'top_ten_kiosk.csv');
    }

    public function sales_by_time_interval(Request $request)
    {
        $totalHours = [
            '00:00:00 - 02:00:00',
            '02:00:01 - 04:00:00',
            '04:00:01 - 06:00:00',
            '06:00:01 - 08:00:00',
            '08:00:01 - 10:00:00',
            '10:00:01 - 12:00:00',
            '12:00:01 - 14:00:00',
            '14:00:01 - 16:00:00',
            '16:00:01 - 18:00:00',
            '18:00:01 - 20:00:00',
            '20:00:01 - 22:00:00',
            '22:00:01 - 24:00:00',
        ];

        $today = date('Y-m-d');
        if (isset($request->sIDate) && $request->sIDate != "") {
            $today = date('Y-m-d', strtotime($request->sIDate));
        }


        $orderIds = [];
        if (isset($request->sIKiosk) && $request->sIKiosk != "") {
            $orderIds = Order::where('kiosk_id', $request->sIKiosk)->pluck('id')->toArray();
        }

        $barChartNewArr = [];
        foreach ($totalHours as $h => $hour) {
            $explodeHours = explode('-', $hour);
            $startHour = trim($explodeHours[0]);
            $EndHour = trim($explodeHours[1]);

            $startDateTime = $today . ' ' . $startHour;
            $startDateTime = date('Y-m-d H:i:s', strtotime($startDateTime));

            $EndDateTime = $today . ' ' . $EndHour;
            $EndDateTime = date('Y-m-d H:i:s', strtotime($EndDateTime));

            $totalSum = new OrderItem;
            if (isset($request->sICity) && $request->sICity != "") {
                $totalSum = $totalSum->where('city_id', (int)$request->sICity);
            }
            if (!empty($orderIds) && count($orderIds) > 0) {
                $totalSum = $totalSum->whereIn('order_id', $orderIds);
            }
            $totalSum = $totalSum->whereBetween('created_at', [$startDateTime, $EndDateTime])->sum('qty');
            $totalOrder = new OrderItem;
            if (isset($request->sICity) && $request->sICity != "") {
                $totalOrder = $totalOrder->where('city_id', (int)$request->sICity);
            }
            if (!empty($orderIds) && count($orderIds) > 0) {
                $totalOrder = $totalOrder->whereIn('order_id', $orderIds);
            }
            $totalOrder = $totalOrder->whereBetween('created_at', [$startDateTime, $EndDateTime])->count();

            $barChartNewArr[$h]['y'] = date('h:i A', strtotime($startHour)) . ' - ' . date('h:i A', strtotime($EndHour));
            $barChartNewArr[$h]['a'] = $totalOrder;
            $barChartNewArr[$h]['b'] = $totalSum;
        }

        $barChartNewJson = json_encode($barChartNewArr);

        return view('admin.sales_by_time_interval', compact('barChartNewJson'));
    }

    public function sales_by_time_interval_kiosk(Request $request)
    {
        $city_id = $request->city_id;

        $kiosks = Kiosk::where('city_id', $city_id)->get()->toArray();

        return view('admin.kiosk_list', compact('kiosks'));
    }

    public function ajax_sales_payment_mode(Request $request)
    {
        $newDate = date('Y-m-d', strtotime($request->start_date));

        $endDate = date('Y-m-d', strtotime($request->end_date));
        $city_id = $request->city_id;
        $startNewDate = $newDate . ' ' . '00:00:00';
        $endNewDate = $endDate . ' ' . '23:59:59';

        $payment_city = Kiosk::get();
        if (isset($request->city_id) && $request->city_id != "") {
            $payment_city = $payment_city->where('city_id', $request->city_id);
        }
        $payment_city = $payment_city->pluck('id');
        //dd($payment_city);
        if ($request->city_id == '') {
            $payment_mode_cash =  Order::where('payment_mode', '=', 'Cash')->whereBetween('orders.created_at', [$startNewDate, $endNewDate])->sum('total_amount');
            $payment_mode_card =  Order::where('payment_mode', '=', 'Card')->whereBetween('orders.created_at', [$startNewDate, $endNewDate])->sum('total_amount');
            $payment_mode_upi =  Order::where('payment_mode', '=', 'UPI')->whereBetween('orders.created_at', [$startNewDate, $endNewDate])->sum('total_amount');
        } else {
            $payment_mode_cash =  Order::whereIn('kiosk_id', $payment_city)->where('payment_mode', '=', 'Cash')->whereBetween('orders.created_at', [$startNewDate, $endNewDate])->sum('total_amount');          
            $payment_mode_card =  Order::whereIn('kiosk_id', $payment_city)->where('payment_mode', '=', 'Card')->whereBetween('orders.created_at', [$startNewDate, $endNewDate])->sum('total_amount');
            $payment_mode_upi =  Order::whereIn('kiosk_id', $payment_city)->where('payment_mode', '=', 'UPI')->whereBetween('orders.created_at', [$startNewDate, $endNewDate])->sum('total_amount');
        }
       
        $payment_total = $payment_mode_cash + $payment_mode_card + $payment_mode_upi;
        if ($payment_total > 0) {
            $payment_cash = ($payment_mode_cash * 100) / $payment_total;
            $payment_card = ($payment_mode_card * 100) / $payment_total;
            $payment_upi = ($payment_mode_upi * 100) / $payment_total;
        } else {
            $payment_cash = 0;
            $payment_card = 0;
            $payment_upi = 0;
        }

        $order_payment_modeArr = ['cash' => $payment_mode_cash, 'card' => $payment_mode_card, 'upi' => $payment_mode_upi];
        $payment_modeArr = ['cash_per' => number_format($payment_cash, 2), 'card_per' => number_format($payment_card, 2), 'upi_per' => number_format($payment_upi, 2)];
        return view('admin.sales_payment_mode', compact('order_payment_modeArr', 'payment_modeArr'));
    }

    public function dashboard_ajax(Request $request)
    {
        // dd('jsdghdsg');
        $startDate = date('Y-m-d', strtotime($request->start_date));
        $endDate = date('Y-m-d', strtotime($request->end_date));
        // dd($startDate, $endDate);
        $totalUsersCount = User::whereNotIn('role', [TRUE, FALSE])->get()->count();
        $totalrequestedQuentity = OrderItem::sum('qty');
        $totalrequestedStock = Stock::where('qty', '<=', 20)->select('kiosk_id')->groupBy('kiosk_id')->get();
        $testotalrequestedStockt_qty = count($totalrequestedStock);

        $startNewDate = $startDate . ' ' . '00:00:00';
        $endNewDate = $endDate . ' ' . '23:59:59';

        // dd($startNewDate);
        $activatedUserCount = User::where('login_logout_status', 1);
        $activatedUserCount = $activatedUserCount->whereBetween('updated_at', [$startNewDate, $endNewDate]);
        $activatedUserCount = $activatedUserCount->count();


        $requestedQuentity = new OrderItem;
        $requestedQuentity = $requestedQuentity->whereBetween('created_at', [$startNewDate, $endNewDate]);
        $requestedQuentity = $requestedQuentity->sum('qty');

        // dd($requestedQuentity);

        $requestedStock = Stock::where('qty', '<=', 20);
        $requestedStock = $requestedStock->whereBetween('created_at', [$startNewDate, $endNewDate]);
        $requestedStock = $requestedStock->count();



        return view('admin.dashboard_ajax', compact('totalUsersCount', 'activatedUserCount', 'requestedQuentity', 'requestedStock', 'totalrequestedQuentity', 'testotalrequestedStockt_qty'));
    }

    public function ajax_sales_by_brand_city(Request $request)
    {
        $city_id = $request->city_id;

       // $currentYearFirstDay = date('Y-m-d H:i:s', strtotime(date('Y-01-01')));
        //$currentDay = date('Y-m-d H:i:s');
        //$lastYearFirstDay = date("Y-m-d 00:00:00", strtotime("January 1st"));   //("Y-m-d 00:00:00",strtotime("last year January 1st"));
        //$lastYearLastDay = date("Y-m-d 23:59:59", strtotime("December 31st")); //("Y-m-d 23:59:59",strtotime("last year December 31st"));

        $currentYearFirstDay = date('Y-m-d H:i:s', strtotime(date('Y-01-01')));
        $currentDay = date('Y-m-d H:i:s');
        $lastYearFirstDay = date("Y-m-d 00:00:00", strtotime("last year January 1st"));
        $lastYearLastDay = date("Y-m-d 23:59:59", strtotime("last year December 31st"));
        // Bar Chart code started
        $barChartArr = [];
        $brands = Brand::get()->toArray();
        if (!empty($brands) && count($brands) > 0) {
            foreach ($brands as $key => $value) {
                $orders = Order::select('orders.id AS order_id', 'orders.kiosk_id', 'kiosk.city_id AS city_id')->leftJoin('kiosk', 'kiosk.id', '=', 'orders.kiosk_id');
                if (isset($request->city_id) && $request->city_id != "" && $request->city_id != 0) {
                    $orders = $orders->where('kiosk.city_id', $request->city_id);
                }
                $orders = $orders->get();

                $orderIdArr = [];
                if (!empty($orders) && count($orders) > 0) {
                    foreach ($orders as $k => $v) {
                        if (!in_array($v->order_id, $orderIdArr)) {
                            $orderIdArr[] = $v->order_id;
                        }
                    }
                }

                $getProductArr = Product::where('brand_id', $value['id'])->pluck('id')->toArray();

                // $lastYearCount = OrderItem::whereBetween('created_at', [$lastYearFirstDay, $lastYearLastDay])->whereIn('order_id', $orderIdArr)->whereIn('product_id', $getProductArr)->sum('qty');
                $lastYearCount = OrderItem::whereBetween('created_at', [$lastYearFirstDay, $lastYearLastDay]);
                $lastYearCount = $lastYearCount->whereIn('product_id', $getProductArr);
                $lastYearCount = $lastYearCount->sum('qty');

                $firstYearCount = OrderItem::whereIn('product_id', $getProductArr);
                $firstYearCount = $firstYearCount->whereIn('order_id', $orderIdArr)->whereBetween('created_at', [$currentYearFirstDay, $currentDay]);
                $firstYearCount = $firstYearCount->sum('qty');
                //dd($firstYearCount);

                $barChartArr[$key]['y'] = $value['name'];
                $barChartArr[$key]['b'] = $firstYearCount;
                $barChartArr[$key]['a'] = $lastYearCount;
            }
        }
        $barChart = json_encode($barChartArr);
       //dd($barChart);
        return view('admin.sales_by_brand', compact('barChart'));
    }

    public function ajax_sales_by_region(Request $request)
    {

        $salesRegionArr = [];
        $cities = City::orderBy('name', 'ASC')->get()->toArray();
        if (!empty($cities) && count($cities) > 0) {
            foreach ($cities as $key => $value) {
                $Kiosks = Kiosk::where('city_id', $value['id'])->pluck('id')->toArray();
                $orders = Order::whereIn('kiosk_id', $Kiosks)->pluck('id')->toArray();

                $todayordersitem = OrderItem::whereIn('order_id', $orders)->whereDate('created_at', date("Y-m-d"))->get();                
                $salesRegionArr[$key]['name'] = trim($value['name']);
                $salesRegionArr[$key]['unit'] = 0;
                $salesRegionArr[$key]['percentage'] = 0;
                foreach ($todayordersitem as $k => $v) {
                    $todayCount = OrderItem::whereIn('order_id', $orders)->whereDate('created_at', date("Y-m-d"))->sum('qty');
                    
                    $yesterDayDate = date("Y-m-d",strtotime("-1 days")); 
                    $yesterdayCount = OrderItem::whereIn('order_id', $orders)->whereDate('created_at', $yesterDayDate)->sum('qty');
                    $salesRegionArr[$key]['unit'] = $todayCount;

                    if ($yesterdayCount > 0) {
                        $count_sum = $todayCount - $yesterdayCount;
                        $per = ($count_sum * 100) / $yesterdayCount;
                        $salesRegionArr[$key]['percentage'] = number_format($per, 2);
                    } else {
                        $salesRegionArr[$key]['percentage'] = $todayCount;
                    }
                }
            }
        }
        //Total Sales by region End

        return view('admin.sales_by_region', compact('salesRegionArr'));
    }

    public function ajax_purchase_behaviour(Request $request)
    {
        $startDate = date('Y-m-d', strtotime($request->start_date));
        $endDate = date('Y-m-d', strtotime($request->end_date));

        $startNewDate = $startDate . ' ' . '00:00:00';
        $endNewDate = $endDate . ' ' . '23:59:59';

        $singleTransactions = OrderItem::where('qty', 1)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('qty');
        $singlePackUnit = OrderItem::where('qty', 1)->whereBetween('created_at', [$startNewDate, $endNewDate])->count();
        $singlePackTotal = OrderItem::where('qty', 1)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('total_amount');

        $towTransactions = OrderItem::whereBetween('qty', [2, 4])->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('qty');
        $towPackUnit = OrderItem::whereBetween('qty', [2, 4])->whereBetween('created_at', [$startNewDate, $endNewDate])->count();
        $towPackTotal = OrderItem::whereBetween('qty', [2, 4])->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('total_amount');

        $fiveTransactions = OrderItem::whereBetween('qty', [5, 7])->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('qty');
        $fivePackUnit = OrderItem::whereBetween('qty', [5, 7])->whereBetween('created_at', [$startNewDate, $endNewDate])->count();
        $fivePackTotal = OrderItem::whereBetween('qty', [5, 7])->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('total_amount');

        $eightTransactions = OrderItem::whereBetween('qty', [8, 10])->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('qty');
        $eightPackUnit = OrderItem::whereBetween('qty', [8, 10])->whereBetween('created_at', [$startNewDate, $endNewDate])->count();
        $eightPackTotal = OrderItem::whereBetween('qty', [8, 10])->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('total_amount');

        $tenTransactions = OrderItem::where('qty', '>', 10)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('qty');
        $tenPackUnit = OrderItem::where('qty', '>', 10)->whereBetween('created_at', [$startNewDate, $endNewDate])->count();
        $tenPackTotal = OrderItem::where('qty', '>', 10)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('total_amount');

        $packageArr = [
            'singlePackUnit' => $singlePackUnit, 'singlePackTotal' => $singlePackTotal, 'towPackUnit' => $towPackUnit, 'towPackTotal' => $towPackTotal, 'fivePackUnit' => $fivePackUnit, 'fivePackTotal' => $fivePackTotal, 'eightPackUnit' => $eightPackUnit, 'eightPackTotal' => $eightPackTotal,
            'tenPackUnit' => $tenPackUnit, 'tenPackTotal' => $tenPackTotal, 'towTransactions' => $towTransactions, 'singleTransactions' => $singleTransactions, 'fiveTransactions' => $fiveTransactions, 'eightTransactions' => $eightTransactions, 'tenTransactions' => $tenTransactions
        ];
        //Package wise graph End

        return view('admin.purchase_behaviour', compact('packageArr', 'startNewDate', 'endNewDate'));
    }

    public function ajax_purchase_behaviour_export(Request $request)
    {
        $startDate = $request->startDate;
        $endDate = $request->endDate;
        return Excel::download(new purchase_behaviour_export($startDate, $endDate), 'purchase_behaviour.csv');
    }
    public function ajax_sold_brand(Request $request)
    {
        $newDate = date('Y-m-d', strtotime($request->start_date));
        $endDate1 = date('Y-m-d', strtotime($request->end_date));

        $startNewDate = $newDate . ' ' . '00:00:00';
        $endNewDate = $endDate1 . ' ' . '23:59:59';


        $SoldBrands = Brand::select('id', 'name')->get()->toArray();
        if (!empty($SoldBrands) && count($SoldBrands) > 0) {
            foreach ($SoldBrands as $key => $value) {
                $orders = Order::select('orders.id AS order_id', 'orders.kiosk_id', 'kiosk.city_id AS city_id')->leftJoin('kiosk', 'kiosk.id', '=', 'orders.kiosk_id');
                if (isset($request->city_id) && $request->city_id != "") {
                    $orders = $orders->where('kiosk.city_id', $request->city_id);
                }
                $orders = $orders->get();

                $orderIdArr = [];
                if (!empty($orders) && count($orders) > 0) {
                    foreach ($orders as $k => $v) {
                        if (!in_array($v->order_id, $orderIdArr)) {
                            $orderIdArr[] = $v->order_id;
                        }
                    }
                }

                $getProductArr = Product::where('brand_id', $value['id'])->pluck('id')->toArray();
                $soldItems = OrderItem::whereIn('product_id', $getProductArr);
                $soldItems = $soldItems->whereIn('order_id', $orderIdArr);
                $soldItems = $soldItems->whereBetween('created_at', [$startNewDate, $endNewDate]);
                $soldItems = $soldItems->sum('qty');

                $soldItem = OrderItem::whereIn('product_id', $getProductArr);
                $soldItem = $soldItem->whereIn('order_id', $orderIdArr);
                $soldItem = $soldItem->whereBetween('created_at', [$startNewDate, $endNewDate]);
                $soldItem = $soldItem->sum('total_amount');

                $SoldBrands[$key]['sold_items'] = $soldItems;
                $SoldBrands[$key]['total_amount'] = $soldItem;
                $SoldBrands[$key]['percentage'] = rand(2, 15);
                if ($soldItems == 0) {
                    $SoldBrands[$key]['percentage'] = 0;
                }
            }

            $sortArr = array_column($SoldBrands, 'sold_items');
            array_multisort($sortArr, SORT_DESC, $SoldBrands);

            // $SoldBrands = array_slice($SoldBrands, 0, 4);

            // dd($SoldBrands);
        }

        return view('admin.sold_brand', compact('SoldBrands'));
    }

    public function ajax_sales_by_location(Request $request)
    {
        // dd('dgshd');
        $startDate = date('Y-m-d', strtotime($request->start_date));
        $endDate = date('Y-m-d', strtotime($request->end_date));

        $startNewDate = $startDate . ' ' . '00:00:00';
        $endNewDate = $endDate . ' ' . '23:59:59';
        $city_id = $request->city_id;

        $OutletLocation = Kiosk::get();
        if (isset($request->city_id) && $request->city_id != "") {
            $OutletLocation = $OutletLocation->where('city_id', $request->city_id);
        }
        $OutletLocation = $OutletLocation->toArray();
        foreach ($OutletLocation as $key => $value) {

            $priceArr = [];
            $qtyArr = [];
            $transactionsArr = [];
            if (!empty($OutletLocation) && count($OutletLocation) > 0) {

                $orders = Order::where('kiosk_id', $value['id'])->pluck('id')->toArray();

                $ordersPrice = OrderItem::whereIn('order_id', $orders)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('total_amount');
                $transactionsorders = OrderItem::whereIn('order_id', $orders)->whereBetween('created_at', [$startNewDate, $endNewDate])->count('qty');
                $ordersQuentity = OrderItem::whereIn('order_id', $orders)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('qty');
                $priceArr[] = $ordersPrice;
                $qtyArr[] = $ordersQuentity;
                $transactionsArr[] = $transactionsorders;
            }

            $OutletLocation[$key]['ATV'] = 0;
            if ($ordersQuentity != 0) {
                $OutletLocation[$key]['ATV'] = numberFormat(($ordersQuentity) / ($transactionsorders));
            }
            // dd($OutletLocation);
            // dd($ordersQuentity, $transactionsorders, $OutletLocation);
            $OutletLocation[$key]['total_transactions'] = array_sum($transactionsArr);
            $OutletLocation[$key]['total_amount'] = array_sum($priceArr);
            $OutletLocation[$key]['total_qty'] = array_sum($qtyArr);
        }
        ($OutletLocation);

        return view('admin.sales_by_location', compact('OutletLocation', 'startNewDate', 'endNewDate', 'city_id'));
    }

    public function ajax_sales_by_loction_export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $city_id = $request->city_id;

        return Excel::download(new sales_by_loction_export($startDate, $endDate, $city_id), 'sales_by_loction.csv');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('message', 'Your are logout successfully');
    }

    public function salesDashboard(Request $request)
    {
        $cities = City::orderBy('name', 'ASC')->get();
        $products = Product::orderBy('name', 'ASC')->get();

        return view('admin.sales', compact('cities', 'products'));
    }

    public function salesDashboardPost(Request $request)
    {
        $startDate = date('Y-m-d', strtotime($request->start_date));
        $endDate = date('Y-m-d', strtotime($request->end_date));

        $startNewDate = $startDate . ' ' . '00:00:00';
        $endNewDate = $endDate . ' ' . '23:59:59';

        $city_id = $request->city_id;
        $product_id = $request->product_id;


        // dd($startDate, $endDate);

        $orderIds = Order::whereBetween('created_at', [$startNewDate, $endNewDate]);
        if ($request->city_id != "") {
            $KiosksList = Kiosk::where('city_id', $city_id)->pluck('id')->toArray();
            $orderIds = $orderIds->whereIn('kiosk_id', $KiosksList);
        }
        $orderIds = $orderIds->pluck('id')->toArray();

        $totalSale = OrderItem::whereIn('order_id', $orderIds);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalSale = $totalSale->where('product_id', $request->product_id);
        }
        $totalSale = $totalSale->sum('total_amount');

        $totalTrns = OrderItem::whereIn('order_id', $orderIds);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalTrns = $totalTrns->where('product_id', $request->product_id);
        }
        $totalTrns = $totalTrns->count();

        $soldPacks = OrderItem::whereIn('order_id', $orderIds);
        if (isset($request->product_id) && $request->product_id != "") {
            $soldPacks = $soldPacks->where('product_id', $request->product_id);
        }
        $soldPacks = $soldPacks->sum('qty');

        // $totalKiosk = Order::whereBetween('created_at',[$startDate,$endDate]);
        // $totalKiosk = $totalKiosk->groupBy('kiosk_id')->count();
        $totalKiosk = Kiosk::count();
        // print_r($totalKiosk);
        //print_r($totalSale);
        $averageKioskSale =  $totalSale / $totalKiosk;

        $averageKioskSale = number_format($averageKioskSale, 2);
        $totalSale = number_format($totalSale, 2);

        $query = "SELECT sum(`qty`) AS qty, DAY(`created_at`) AS day, MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        $query .= " where `created_at` between '" . $startNewDate . "' AND '" . $endNewDate . "'";
        if (isset($request->product_id) && $request->product_id != "") {
            $query .= " AND product_id = " . $request->product_id;
        }
        $query .= " GROUP BY DAY(`created_at`), MONTH(`created_at`), YEAR(`created_at`)";

        // echo $query;

        // Sales Chart started
        $SalesChart = DB::Select($query);

        $timePeriodArr = [];
        $qtyArr = [];
        if (!empty($SalesChart) && count($SalesChart) > 0) {
            foreach ($SalesChart as $key => $v) {
                $qtyArr[] = $v->qty;

                $day  = $v->day;
                $monthNum  = $v->month;
                $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
                $timePeriodArr[] = $day . " " . $monthName;
            }
        }

        $categories = json_encode($timePeriodArr);
        $qtyData = json_encode($qtyArr);

        // Sales Chart Ended

        // Sales History Started

        $sql = "SELECT MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        $sql .= " where `created_at` between '" . $startDate . "' AND '" . $endDate . "'";
        if (isset($request->product_id) && $request->product_id != "") {
            $sql .= " AND product_id = " . $request->product_id;
        }
        $sql .= " GROUP BY MONTH(`created_at`), YEAR(`created_at`)";

        $SalesHistory = DB::Select($sql);

        $historyArr = [];
        if (!empty($SalesHistory) && count($SalesHistory) > 0) {
            foreach ($SalesHistory as $key => $value) {
                $monthNum  = $value->month;
                $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
                $MonthYear = $monthName . "-" . $value->year;
                $Converted = date('m-Y', strtotime($MonthYear));

                $totalOrders = OrderItem::whereMonth('created_at', $monthNum);
                $totalOrders = $totalOrders->whereYear('created_at', $value->year);
                $totalOrders = $totalOrders->whereIn('order_id', $orderIds);
                if (isset($request->product_id) && $request->product_id != "") {
                    $totalOrders = $totalOrders->where('product_id', $request->product_id);
                }
                $totalOrders = $totalOrders->groupBy('order_id');
                $totalOrders = $totalOrders->count();

                $grossSales = OrderItem::whereMonth('created_at', $monthNum);
                $grossSales = $grossSales->whereYear('created_at', $value->year);
                $grossSales = $grossSales->whereIn('order_id', $orderIds);
                if (isset($request->product_id) && $request->product_id != "") {
                    $grossSales = $grossSales->where('product_id', $request->product_id);
                }
                $grossSales = $grossSales->sum('total_amount');

                $historyArr[$key]['period'] = date('F Y', strtotime($MonthYear));
                $historyArr[$key]['total_orders'] = $totalOrders;
                $historyArr[$key]['gross_sales'] = number_format($grossSales, 2);
                $historyArr[$key]['total_sales'] = number_format($grossSales, 2);
            }
        }

        return view('admin.sales_ajax', compact('totalSale', 'averageKioskSale', 'totalTrns', 'soldPacks', 'qtyData', 'categories', 'historyArr'));
    }
    public function salesDashboardmonth(Request $request, $date)
    {


        $newDate = date("Y-m-01", strtotime($date));
        $endDate1 = date("Y-m-t", strtotime($date));

        $startDate = $newDate . ' ' . '00:00:00';
        $endDate = $endDate1 . ' ' . '23:59:59';

        // $startDate = date('Y-m-d H:i:s', strtotime($newDate));
        // $endDate = date('Y-m-d H:i:s', strtotime($endDate1));


        $orderIds = OrderItem::whereBetween('created_at', [$startDate, $endDate]);
        // ->leftjoin("products", "OrderItem.product_id", "=", "products.id");
        $orderIds = $orderIds->get()->toArray();
        $sql = "SELECT MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        $sql .= " where `created_at` between '" . $startDate . "' AND '" . $endDate . "'";
        if (isset($request->product_id) && $request->product_id != "") {
            $sql .= " AND product_id = " . $request->product_id;
        }
        $sql .= " GROUP BY MONTH(`created_at`), YEAR(`created_at`)";
        $SalesHistory = DB::Select($sql);
        $historyArr = [];

        // if (!empty($SalesHistory) && count($SalesHistory) > 0) {
        //     foreach ($SalesHistory as $key => $value) {
        //         $monthNum  = $value->month;
        //         $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
        //         $MonthYear = $monthName . "-" . $value->year;
        //         $Converted = date('m-Y', strtotime($MonthYear));
        //         $totalOrders = OrderItem::whereMonth('created_at', $monthNum);
        //         $totalOrders = $totalOrders->whereYear('created_at', $value->year);
        //         $totalOrders = $totalOrders->whereIn('order_id', $orderIds);


                $orser_itme = Db::table('order_items')
                    ->leftjoin('products','order_items.product_id','=','products.id')
                    ->leftjoin('brand','products.brand_id','=','brand.id')
                    ->leftjoin('city','order_items.city_id','=','city.id')
                    ->leftjoin('orders','order_items.order_id','=','orders.id')
                    ->leftjoin('kiosk','orders.kiosk_id','=','kiosk.id')
                    // ->groupBy('order_items.order_date')
                    // ->groupBy('order_items.product_id')
                    ->whereBetween('order_items.created_at', [$startDate, $endDate])
                    ->select('products.name','brand.name as brand_name','city.name as city_name','order_items.qty','kiosk.kiosk_name','order_items.total_amount','order_items.created_at')
                    ->get();
                $orser_itme  = $orser_itme->toArray();
                //dd($orser_itme);
            // }
            // DB::raw("COUNT(*) as Transactions"), DB::raw("sum(qty) as qty"), DB::raw("sum(total_amount) as total_amount")

            $historyArr = $orser_itme;


            //dd($historyArr);
        // }

        return view('admin.sales_month', compact('historyArr', 'date'));
    }
    public function salesDashboardmonthexport(Request $request)
    {
        $date = $request->date;
        //return Excel::download(new sales_month_export($date), 'sales_month_export.xlsx');
        return Excel::download(new sales_month_export($date), 'sales_month_export.csv');
    }
    public function salesDashboardday($date)
    {
        $order_items = Db::table('orders')
            ->leftjoin('order_items', 'order_items.order_id', '=', 'orders.id')
            // ->select('order_id',DB::raw("sum(qty) as qty"),DB::raw("sum(orders.total_amount) as total_amount"))
            ->where('order_items.order_date', '=', $date)
            ->get()->toArray();
        //dd($order_items);
        return view('admin.sales_day', compact('order_items', 'date'));
    }

    public function salesDashboarddayexport(Request $request)
    {
        $date = $request->date;
        return Excel::download(new sales_day_export($date), 'sales_day_export.csv');
    }
    public function export_sales_history(Request $request)
    {

        $file_name = 'month_sales_history_' . date('Y_m_d_H_i_s') . '.csv';
        return Excel::download(new SalesHistoryExport, $file_name);
    }

    public function total_sales_by_region_export(Request $request)
    {

        $file_name = 'total_sales_by_region_' . date('Y_m_d_H_i_s') . '.csv';
        return Excel::download(new TotalSalesByRegion, $file_name);
    }

    public function kioskDashboard()
    {
        $requestedStock = Stock::where('qty', '<=', 20)
            ->groupBy('kiosk_id')
            ->pluck('kiosk_id')->toarray();
        // dd($requestedStock);


        $kiosk = Db::table('kiosk')
            ->leftJoin("city", "kiosk.city_id", "=", "city.id")
            ->leftjoin("outlet_location", "kiosk.outlet_location_id", "=", "outlet_location.id")
            ->whereIn('kiosk.id', $requestedStock)
            ->select('kiosk.id', 'kiosk.kiosk_id', 'kiosk.kiosk_name', 'city.name as city_name', 'outlet_location.name as outlet_location_name')
            ->get()
            ->toarray();

        //  dd($kiosk);
        return view('admin.kios', compact('kiosk'));
    }
    public function kiosk_qty(Request $request, $id)
    {
        // $qty = Stock::where('Stock.kiosk_id','=',$id)
        // ->leftJoin("products","Stock.product_id","=","products.id")
        $qty = Db::table('stocks')
            ->leftJoin("products", "stocks.product_id", "=", "products.id")
            ->where('stocks.kiosk_id', '=', $id)
            ->get()
            ->toarray();

        $startDate = date('Y-m-d', strtotime($request->start_date));
        $endDate = date('Y-m-d', strtotime($request->end_date));
        $products = Product::where('brand_id', '=', $id)->pluck('id')->toArray();
        $startNewDate = $startDate . ' ' . '00:00:00';
        $endNewDate = $endDate . ' ' . '23:59:59';
        $city_id = $request->city_id;
        $product_id = $request->product_id;
        $kiosk_id = $request->kiosk_id;

        $orderfillter = Order::where('kiosk_id', $request->kiosk_id)->first();
        // dd($orderfillter);

        $totalpack_sold = OrderItem::whereIn('product_id', $products)->whereBetween('created_at', [$startNewDate, $endNewDate]);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalpack_sold = $totalpack_sold->where('product_id', $request->product_id);
        }
        if (isset($request->city_id) && $request->city_id != "") {
            $totalpack_sold = $totalpack_sold->where('city_id', $request->city_id);
        }
        if (isset($orderfillter) && $orderfillter != "") {
            $totalpack_sold = $totalpack_sold->whereIn('order_id', $orderfillter);
        }
        $totalpack_sold = $totalpack_sold->sum('qty');

        $totalpack_Sale = OrderItem::wherein('product_id', $products)->whereBetween('created_at', [$startNewDate, $endNewDate]);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalpack_Sale = $totalpack_Sale->where('product_id', $request->product_id);
        }
        if (isset($request->city_id) && $request->city_id != "") {
            $totalpack_Sale = $totalpack_Sale->where('city_id', $request->city_id);
        }
        if (isset($orderfillter) && $orderfillter != "") {
            $totalpack_Sale = $totalpack_Sale->whereIn('order_id', $orderfillter);
        }
        $totalpack_Sale = $totalpack_Sale->sum('total_amount');

        $totalproduct = Product::where('brand_id', $id);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalproduct = $totalproduct->where('id', $request->product_id);
        }
        $totalproduct = $totalproduct->count('id');

        $barChartArr = [];

        $brands = Product::where('brand_id', $id)->get()->toArray();
        if (!empty($brands) && count($brands) > 0) {
            foreach ($brands as $key => $value) {
                $getProductArr = OrderItem::where('product_id', $value['id'])
                    ->whereBetween('order_date', [$startNewDate, $endNewDate])
                    ->groupBy('product_id')->sum('qty');
                $barChartArr[$key]['y'] = $value['name'];
                $barChartArr[$key]['b'] = $getProductArr;
            }
        }
        $barChart = json_encode($barChartArr);
        $sql = "SELECT DAY(`created_at`) AS day,MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        $sql .= " where `created_at` between '" . $startNewDate . "' AND '" . $endNewDate . "'";
        if (isset($request->product_id) && $request->product_id != "") {
            $sql .= " AND product_id = " . $request->product_id;
        }
        if (isset($request->city_id) && $request->city_id != "") {
            $sql .= "AND id = " . $request->city_id;
        }
        // if (isset($orderfillter) && $orderfillter != "") {
        //     $sql .= "AND order_id = " . $orderfillter;
        // }
        $sql .= " GROUP BY DAY(`created_at`), MONTH(`created_at`), YEAR(`created_at`)";
        $SalesHistory = DB::Select($sql);

        $historyArr = [];
        $OutletLocation = [];
        if (!empty($SalesHistory) && count($SalesHistory) > 0) {
            foreach ($SalesHistory as $key => $value) {
                $monthNum  = $value->month;
                $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
                $MonthYear = $monthName . "-" . $value->year;
                $Converted = date('m-Y', strtotime($MonthYear));
                // $orderfillter = Order::where('kiosk_id', $request->kiosk_id)->first();
                $OutletLocation = Product::where('brand_id', $id)->get()->toArray();
                if (!empty($OutletLocation) && count($OutletLocation) > 0) {
                    foreach ($OutletLocation as $key => $value) {
                        $priceArr = [];
                        $qtyArr = [];
                        if (!empty($OutletLocation) && count($OutletLocation) > 0) {
                            $ordersPrice = OrderItem::where('product_id', $value['id'])->whereIn('order_id', $orderfillter)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('total_amount');
                            $ordersQuentity = OrderItem::where('product_id', $value['id'])->whereIn('order_id', $orderfillter)->whereBetween('created_at', [$startNewDate, $endNewDate])->sum('qty');
                            $priceArr[] = $ordersPrice;
                            $qtyArr[] = $ordersQuentity;
                        }
                        $OutletLocation[$key]['total_amount'] = array_sum($priceArr);
                        $OutletLocation[$key]['total_qty'] = array_sum($qtyArr);
                    }
                }
                // dd($OutletLocation);
            }
        }



        // dd($qty);
        return view('admin.kiosk_qty', compact('qty'));
    }
    public function ajax_brand_dashboard($id)
    {

        $brand = $id;
        $brand_id = Brand::where('id', $id)->get();
        $products = Product::where('brand_id', '=', $id)->orderBy('name', 'ASC')->get();
        $cities = City::orderBy('name', 'ASC')->get();
        $kiosk = Kiosk::orderBy('kiosk_name', 'ASC')->get();


        return view('admin.brand_dashboard', compact('products', 'cities', 'brand_id', 'brand', 'kiosk'));
    }
    public function ajax_brand_dashboard_post(Request $request, $id)
    {
        $startDate = date('Y-m-d', strtotime($request->start_date));
        $endDate = date('Y-m-d', strtotime($request->end_date));
        $products = Product::where('brand_id', '=', $id)->pluck('id')->toArray();
        $startNewDate = $startDate . ' ' . '00:00:00';
        $endNewDate = $endDate . ' ' . '23:59:59';
        $city_id = $request->city_id;
        $product_id = $request->product_id;
        $kiosk_id = $request->kiosk_id;

        $orderfillter = Order::where('kiosk_id', $request->kiosk_id)->first();
        // dd($orderfillter);

        $totalpack_sold = OrderItem::whereIn('product_id', $products)->whereBetween('created_at', [$startNewDate, $endNewDate]);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalpack_sold = $totalpack_sold->where('product_id', $request->product_id);
        }
        if (isset($request->city_id) && $request->city_id != "") {
            $totalpack_sold = $totalpack_sold->where('city_id', $request->city_id);
        }
        if (isset($orderfillter) && $orderfillter != "") {
            $totalpack_sold = $totalpack_sold->whereIn('order_id', $orderfillter);
        }
        $totalpack_sold = $totalpack_sold->sum('qty');

        $totalpack_Sale = OrderItem::wherein('product_id', $products)->whereBetween('created_at', [$startNewDate, $endNewDate]);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalpack_Sale = $totalpack_Sale->where('product_id', $request->product_id);
        }
        if (isset($request->city_id) && $request->city_id != "") {
            $totalpack_Sale = $totalpack_Sale->where('city_id', $request->city_id);
        }
        if (isset($orderfillter) && $orderfillter != "") {
            $totalpack_Sale = $totalpack_Sale->whereIn('order_id', $orderfillter);
        }
        $totalpack_Sale = $totalpack_Sale->sum('total_amount');

        $totalproduct = Product::where('brand_id', $id);
        if (isset($request->product_id) && $request->product_id != "") {
            $totalproduct = $totalproduct->where('id', $request->product_id);
        }
        $totalproduct = $totalproduct->count('id');

        $barChartArr = [];

        $brands = Product::where('brand_id', $id)->get()->toArray();
        if (!empty($brands) && count($brands) > 0) {
            foreach ($brands as $key => $value) {
                $getProductArr = OrderItem::where('product_id', $value['id'])
                    ->whereBetween('order_date', [$startNewDate, $endNewDate])
                    ->groupBy('product_id')->sum('qty');
                $barChartArr[$key]['y'] = $value['name'];
                $barChartArr[$key]['b'] = $getProductArr;
            }
        }
        $barChart = json_encode($barChartArr);
        // dd($barChart);
        $sql = "SELECT DAY(`created_at`) AS day,MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        $sql .= " where `created_at` between '" . $startNewDate . "' AND '" . $endNewDate . "'";
        if (isset($request->product_id) && $request->product_id != "") {
            $sql .= " AND product_id = " . $request->product_id;
        }
        if (isset($request->city_id) && $request->city_id != "") {
            $sql .= "AND id = " . $request->city_id;
        }
        $sql .= " GROUP BY DAY(`created_at`), MONTH(`created_at`), YEAR(`created_at`)";
        $SalesHistory = DB::Select($sql);

        $historyArr = [];
        $OutletLocation = [];
        if (!empty($SalesHistory) && count($SalesHistory) > 0) {
            foreach ($SalesHistory as $key => $value) {
                $monthNum  = $value->month;
                $monthName = date('M', mktime(0, 0, 0, $monthNum, 10));
                $MonthYear = $monthName . "-" . $value->year;
                $Converted = date('m-Y', strtotime($MonthYear));
                $orderfillter = Order::where('kiosk_id', $request->kiosk_id)->first();
                $OutletLocation = Product::where('brand_id', $id)->get()->toArray();
                if (!empty($OutletLocation) && count($OutletLocation) > 0) {
                    foreach ($OutletLocation as $key => $value) {
                        $priceArr = [];
                        $qtyArr = [];
                        if (!empty($OutletLocation) && count($OutletLocation) > 0) {
                            $ordersPrice = OrderItem::where('product_id', $value['id'])->whereBetween('created_at', [$startNewDate, $endNewDate]);
                            if (isset($orderfillter) && $orderfillter != "") {
                                $ordersPrice = $ordersPrice->whereIn('order_id', $orderfillter);
                            }
                            $ordersPrice = $ordersPrice->sum('total_amount');
                            $ordersQuentity = OrderItem::where('product_id', $value['id'])->whereBetween('created_at', [$startNewDate, $endNewDate]);
                            if (isset($orderfillter) && $orderfillter != "") {
                                $ordersQuentity = $ordersQuentity->whereIn('order_id', $orderfillter);
                            }
                            $ordersQuentity = $ordersQuentity->sum('qty');
                            $priceArr[] = $ordersPrice;
                            $qtyArr[] = $ordersQuentity;
                        }
                        $OutletLocation[$key]['total_amount'] = array_sum($priceArr);
                        $OutletLocation[$key]['total_qty'] = array_sum($qtyArr);
                    }
                }
                
            }
        }
        return view('admin.brand_dashboard_ajax', compact('totalpack_sold', 'totalpack_Sale', 'totalproduct', 'OutletLocation', 'barChart'));
    }
    public function ajax_brand_sales_export(Request $request, $id)
    {
        return Excel::download(new sales_history(), 'sales_history.csv');
    }
    public function oss_alert()
    {
        $cities = City::orderBy('name', 'ASC')->get()->toArray();
        $kiosk = Kiosk::orderBy('kiosk_name', 'ASC')->get()->toArray();
        $oos = Db::table('stocks')
            ->where('qty', '<=', 5)
            ->leftjoin("kiosk", "stocks.kiosk_id", "=", "kiosk.id")
            ->leftjoin("city", "kiosk.city_id", "=", "city.id")
            ->leftjoin("products", "stocks.product_id", "=", "products.id")
            ->leftjoin("brand", "products.brand_id", "=", "brand.id")
            ->select('products.sku', 'products.name as product_name', 'kiosk.kiosk_name', 'city.name as city_name', 'brand.name as brand_name', 'stocks.qty')
            ->get()->toArray();

        // dd($oos);      
        return view('admin.oos_alert', compact('cities', 'kiosk', 'oos'));
    }
    public function oss_alert_kiosk(Request $request)
    {
        $kiosk_list = Kiosk::where('city_id', $request->city_id)->get();
        return view('admin.ajax_oss_alert_kiosk', compact('kiosk_list'));
    }
    public function oss_alert_post(Request $request)
    {
        $cities = $request->city_id;
        $Kiosks = $request->kiosk_id;
        $kiosk = Kiosk::orderBy('kiosk_name', 'ASC')->get()->toArray();
        if ($Kiosks == '') {

            $oos_alert = Kiosk::where('city_id', $cities)->get();
            $test = [];
            if (!empty($oos_alert) && count($oos_alert) > 0) {
                foreach ($oos_alert as $key => $value) {
                    $oos = Db::table('stocks')
                        ->where('kiosk_id', $value->id)
                        ->where('qty', '<=', 5)
                        ->leftjoin("products", "stocks.product_id", "=", "products.id")
                        ->leftjoin("brand", "products.brand_id", "=", "brand.id")
                        ->select('products.sku', 'products.name as product_name', 'brand.name as brand_name', 'stocks.qty')
                        ->get();
                    foreach ($oos as $k => $v) {
                        if (!empty($v)) {
                            $cityId = City::where('id', $cities)->first();
                            $v->kiosk_name =  $value->kiosk_name;
                            $v->city_name = $cityId->name;
                            $test[] = $v;
                        }
                    }
                }
            } else {
                $test = Db::table('stocks')
                    ->where('qty', '<=', 5)
                    ->leftjoin("kiosk", "stocks.kiosk_id", "=", "kiosk.id")
                    ->leftjoin("city", "kiosk.city_id", "=", "city.id")
                    ->leftjoin("products", "stocks.product_id", "=", "products.id")
                    ->leftjoin("brand", "products.brand_id", "=", "brand.id")
                    ->select('products.sku', 'products.name as product_name', 'kiosk.kiosk_name', 'city.name as city_name', 'brand.name as brand_name', 'stocks.qty')
                    ->get()->toArray();
            }
        } else {
            $oos_alert = Kiosk::where('city_id', $cities)->where('id', $Kiosks)->get();
            $test = [];
            if (!empty($oos_alert) && count($oos_alert) > 0) {
                foreach ($oos_alert as $key => $value) {
                    $oos = Db::table('stocks')
                        ->where('kiosk_id', $value->id)
                        ->where('qty', '<=', 5)
                        ->leftjoin("products", "stocks.product_id", "=", "products.id")
                        ->leftjoin("brand", "products.brand_id", "=", "brand.id")
                        ->select('products.sku', 'products.name as product_name', 'brand.name as brand_name', 'stocks.qty')
                        ->get();
                    foreach ($oos as $k => $v) {
                        if (!empty($v)) {
                            $cityId = City::where('id', $cities)->first();
                            $v->kiosk_name =  $value->kiosk_name;
                            $v->city_name = $cityId->name;
                            $test[] = $v;
                        }
                    }
                }
            } else {
                $test = Db::table('stocks')
                    ->where('qty', '<=', 5)
                    ->leftjoin("kiosk", "stocks.kiosk_id", "=", "kiosk.id")
                    ->leftjoin("city", "kiosk.city_id", "=", "city.id")
                    ->leftjoin("products", "stocks.product_id", "=", "products.id")
                    ->leftjoin("brand", "products.brand_id", "=", "brand.id")
                    ->select('products.sku', 'products.name as product_name', 'kiosk.kiosk_name', 'city.name as city_name', 'brand.name as brand_name', 'stocks.qty')
                    ->get()->toArray();
            }
        }
        return view('admin.ajax_oss_alert', compact('test', 'cities', 'kiosk', 'Kiosks'));
    }
    public function export_listing_data()
    {
        return Excel::download(new oss_alert, 'Oos_export.csv');
    }
    public function export_listing_data_post(Request $request)
    {
        $city = $request->city_id;
        $kiosk = $request->kiosk_id;
        // dd($city);
        return Excel::download(new Export_oss($city), 'Oos_export.csv');
        // return Excel::download(new Export_oss(), 'Oos_export.csv');
    }
    public function ajax_product_comparison_1(Request $request)
    {
        $start_date = $request->start_date;
        $product_id = $request->product_id;
        $test = [];
        $comparison = Db::table('products')
            ->where('products.id', $product_id)
            ->leftjoin('brand', 'products.brand_id', '=', 'brand.id')
            ->select('products.sku', 'products.price', 'products.packge_size', 'brand.name as brand_name', 'products.created_at')
            ->get();
        foreach ($comparison as $k => $v) {
            if (!empty($v)) {
                $qty = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('qty');
                $total_amount = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('total_amount');
                $v->qty = $qty;
                $v->total_amount = $total_amount;
                $test[] = $v;
            }
        }
        // dd($test);
        return view('admin.product_comparison_1', compact('test'));
    }

    public function ajax_product_comparison_2(Request $request)
    {
        $product_id = $request->product_id;
        $test = [];
        $comparison = Db::table('products')
            ->where('products.id', $product_id)
            ->leftjoin('brand', 'products.brand_id', '=', 'brand.id')
            ->select('products.sku', 'products.price', 'products.packge_size', 'brand.name as brand_name')
            ->get();
        foreach ($comparison as $k => $v) {
            if (!empty($v)) {
                $qty = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('qty');
                $total_amount = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('total_amount');
                $v->qty = $qty;
                $v->total_amount = $total_amount;
                $test[] = $v;
            }
        }
        // dd($comparison);
        return view('admin.product_comparison_2', compact('test'));
    }

    public function ajax_product_comparison_3(Request $request)
    {
        $product_id = $request->product_id;
        $test = [];
        $comparison = Db::table('products')
            ->where('products.id', $product_id)
            ->leftjoin('brand', 'products.brand_id', '=', 'brand.id')
            ->select('products.sku', 'products.price', 'products.packge_size', 'brand.name as brand_name')
            ->get();
        foreach ($comparison as $k => $v) {
            if (!empty($v)) {
                $qty = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('qty');
                $total_amount = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('total_amount');
                $v->qty = $qty;
                $v->total_amount = $total_amount;
                $test[] = $v;
            }
        }
        // dd($comparison);
        return view('admin.product_comparison_2', compact('test'));
    }

    public function ajax_product_comparison_4(Request $request)
    {
        $product_id = $request->product_id;
        $test = [];
        $comparison = Db::table('products')
            ->where('products.id', $product_id)
            ->leftjoin('brand', 'products.brand_id', '=', 'brand.id')
            ->select('products.sku', 'products.price', 'products.packge_size', 'brand.name as brand_name')
            ->get();
        foreach ($comparison as $k => $v) {
            if (!empty($v)) {
                $qty = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('qty');
                $total_amount = OrderItem::where('product_id', $product_id)->groupBy('product_id')->sum('total_amount');
                $v->qty = $qty;
                $v->total_amount = $total_amount;
                $test[] = $v;
            }
        }
        // dd($comparison);
        return view('admin.product_comparison_2', compact('test'));
    }

    public function airportChange(Request $request)
    {

        $fQStartDate = date('Y-m-d', strtotime(date('Y-01-01')));
        $fQEndDate = date('Y-m-d', strtotime(date('Y-03-31')));
        $sQStartDate = date('Y-m-d', strtotime(date('Y-04-01')));   
        $sQEndDate = date('Y-m-d', strtotime(date('Y-06-30')));
        
        $tQStartDate = date('Y-m-d', strtotime(date('Y-07-01')));
        $tQEndDate = date('Y-m-d', strtotime(date('Y-09-30')));

        $ftQStartDate = date('Y-m-d', strtotime(date('Y-10-01')));
        $ftQEndDate = date('Y-m-d', strtotime(date('Y-12-31')));
        
        if(!empty($request->kiosk_airport))
        {
            $kioskDetails = Kiosk::where('airport', $request->kiosk_airport)->pluck('id');
            
            $orderDetails = Order::whereIn('kiosk_id', $kioskDetails)->pluck('id');         
            //Quarterly graph started
            $fQSale = OrderItem::whereIn('order_id',$orderDetails)->whereBetween('created_at', [$fQStartDate, $fQEndDate])->sum('total_amount');
            $sQSale = OrderItem::whereIn('order_id',$orderDetails)->whereBetween('created_at', [$sQStartDate, $sQEndDate])->sum('total_amount');
            $tQSale = OrderItem::whereIn('order_id',$orderDetails)->whereBetween('created_at', [$tQStartDate, $tQEndDate])->sum('total_amount');
            $ftQSale = OrderItem::whereIn('order_id',$orderDetails)->whereBetween('created_at', [$ftQStartDate, $ftQEndDate])->sum('total_amount');
            
            $totalYearPrice = $fQSale + $sQSale + $tQSale + $ftQSale;
            
            $quarterArr = ['first' => $fQSale, 'second' => $sQSale, 'third' => $tQSale, 'fourth' => $ftQSale, 'totalYearPrice' => $totalYearPrice];                      
        }else{            
            $fQSale = OrderItem::whereBetween('created_at', [$fQStartDate, $fQEndDate])->sum('total_amount');
            $sQSale = OrderItem::whereBetween('created_at', [$sQStartDate, $sQEndDate])->sum('total_amount');
            $tQSale = OrderItem::whereBetween('created_at', [$tQStartDate, $tQEndDate])->sum('total_amount');
            $ftQSale = OrderItem::whereBetween('created_at', [$ftQStartDate, $ftQEndDate])->sum('total_amount');

            $totalYearPrice = $fQSale + $sQSale + $tQSale + $ftQSale;
            
            $quarterArr = ['first' => $fQSale, 'second' => $sQSale, 'third' => $tQSale, 'fourth' => $ftQSale, 'totalYearPrice' => $totalYearPrice];                      
        }
       
        
        return view('admin.airportChange', compact('quarterArr'));
    }
}
