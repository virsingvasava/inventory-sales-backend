<?php

namespace App\Exports;

use App\Models\Kiosk;
use App\Models\Order;
use App\Models\OrderItem;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

class sales_by_loction_export implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $startDate = null, String $endDate = null, String $city_id = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->city_id = $city_id;
    }
    public function collection()
    {
        $sales_by_loction_export = Kiosk ::select('id','city_id','kiosk_name')->get();
        if (isset($this->city_id) && $this->city_id != "") {
            $sales_by_loction_export = $sales_by_loction_export->where('city_id', $this->city_id);
        }
        $sales_by_loction_export = $sales_by_loction_export->toArray();
        foreach ($sales_by_loction_export as $key => $value) {

            $priceArr = [];
            $qtyArr = [];
            $transactionsArr = [];
            if (!empty($sales_by_loction_export) && count($sales_by_loction_export) > 0) {
                $orders = Order::where('kiosk_id', $value['id'])->pluck('id')->toArray();

                $ordersPrice = OrderItem::whereIn('order_id', $orders)->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total_amount');
                $transactionsorders = OrderItem::whereIn('order_id', $orders)->whereBetween('created_at', [$this->startDate, $this->endDate])->count('qty');
                $ordersQuentity = OrderItem::whereIn('order_id', $orders)->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('qty');
                $priceArr[] = $ordersPrice;
                $qtyArr[] = $ordersQuentity;
                $transactionsArr[] = $transactionsorders;
            }
            
            $sales_by_loction_export[$key]['total_qty'] = array_sum($qtyArr);
            $sales_by_loction_export[$key]['total_transactions'] = array_sum($transactionsArr);
            $sales_by_loction_export[$key]['total_amount'] = array_sum($priceArr);
            $sales_by_loction_export[$key]['ATV'] = 0;
            if ($ordersQuentity != 0) {
                $sales_by_loction_export[$key]['ATV'] = numberFormat(($ordersQuentity) / ($transactionsorders));
            }
        }

        // dd($sales_by_loction_export);
        return collect($sales_by_loction_export);
    }

    public function headings(): array
    {
        return [
            'id',
            'city_id',
            'kiosk_name',
            'Units',
            'Transactions',
            'Amount (in INR)',
            'ATV',
        ];
    }
}
