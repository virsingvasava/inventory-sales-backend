<?php

namespace App\Exports;

use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

class sales_month_export implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $date = null)
    {
        $this->date = $date;
        // dd($this->startDate);
    }
    public function collection()
    {
        $newDate = date("Y-m-01", strtotime($this->date));
        $endDate1 = date("Y-m-t", strtotime($this->date));
        //dd($endDate1);
        // $startDate = date('Y-m-d H:i:s', strtotime($newDate));
        // $endDate = date('Y-m-d H:i:s', strtotime($endDate1));

        $startDate = $newDate . ' ' . '00:00:00';
        $endDate = $endDate1 . ' ' . '23:59:59';
         //dd($endDate);
        // $orderIds = OrderItem::whereBetween('created_at', [$startDate, $endDate]);
        // $orderIds = $orderIds->get()->toArray();
        // $sql = "SELECT MONTH(`created_at`) AS month, YEAR(`created_at`) AS year FROM `order_items`";
        // $sql .= " where `created_at` between '" . $startDate . "' AND '" . $endDate . "'";
        // $sql .= " GROUP BY MONTH(`created_at`), YEAR(`created_at`)";
        // $SalesHistory = DB::Select($sql);
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
            // }

            $historyArr = $orser_itme;
            //dd($historyArr);
            return $historyArr;
        // }
    }

    public function headings(): array
    {
       return [
         'product Name',
         'Brand',
         'City',
         'Qty',
         'Kios Name',
         'Total Sale',
         'Date'
       ];
    }
}
