<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\OrderItem;
use Auth;
use DB;

class SalesHistoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $date = $_POST['date'];
        $newDate = date("Y-m-01", strtotime($date));
        $endDate1 = date("Y-m-t", strtotime($date));

        $startDate = date('Y-m-d H:i:s',strtotime($newDate));
        $endDate = date('Y-m-d H:i:s',strtotime($endDate1));
        
        

        $orderIds = OrderItem::whereBetween('created_at',[$startDate,$endDate]);
        // ->leftjoin("products", "OrderItem.product_id", "=", "products.id");
        $orderIds = $orderIds->get()->toArray();
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
                
                $orser_itme = Db::table('order_items')
                ->leftJoin("products", "order_items.product_id", "=", "products.id")
                ->leftJoin("orders", "order_items.order_id", "=", "orders.id")
                ->leftJoin("kiosk", "orders.kiosk_id", "=", "kiosk.id")
                ->leftjoin("city","kiosk.city_id","=","city.id")
                ->whereBetween('order_items.created_at',[$startDate,$endDate])
                ->select('products.name as product_name','city.name as city_name','order_items.qty','kiosk.kiosk_name','order_items.total_amount')
                ->get();
                $orser_itme = $orser_itme->toArray();
            }
            $historyArr = $orser_itme;
            return collect($historyArr);

        }
    }
    public function headings(): array
    {
       return [
         'product Name',
         'City',
         'Qty',
         'Kios Name',
         'Total Sale',
       ];
    }

}
