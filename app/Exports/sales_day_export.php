<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

class sales_day_export implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(String $date = null)
    {
        $this->date = $date;
        // dd($this->date);
    }
    public function collection()
    {
        $order_items = DB::table('orders')
            ->leftjoin('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select('orders.id','order_items.qty','orders.total_amount','orders.payment_mode')
            ->where('order_items.order_date', '=', $this->date)
            ->get()->toArray();
            return $order_items;
    }

    public function headings(): array
    {
       return [
         'Order_Id',
         'Items(qty)',
         'Total',
         'Mode',
       ];
    }
}
