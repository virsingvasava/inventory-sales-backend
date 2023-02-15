<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

use App\Models\User;
use App\Models\Kiosk;
use App\Models\Order;
use App\Models\City;
use App\Models\OrderItem;
use Auth;
use DB;
use Illuminate\Support\Carbon;

class TotalSalesByRegion implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
    
        $salesRegionArr = [];
        $cities = City::orderBy('name','ASC')->get()->toArray();
        if(!empty($cities) && count($cities) > 0)
        {
            foreach($cities as $key => $value)  
            {
                $Kiosks = Kiosk::where('city_id',$value['id'])->pluck('id')->toArray();
                $orders = Order::whereIn('kiosk_id',$Kiosks)->pluck('id')->toArray();
                
                $todayordersitem = OrderItem::whereIn('order_id',$orders)->whereDate('created_at', Carbon::today())->get();               
                $salesRegionArr[$key]['name'] = trim($value['name']);
                $salesRegionArr[$key]['unit'] = 0;
                $salesRegionArr[$key]['percentage'] = 0;
                foreach($todayordersitem as $k => $v)
                {
                    $todayCount = OrderItem::whereIn('order_id',$orders)->whereDate('created_at', Carbon::today())->sum('qty'); 
                    $yesterdayCount = OrderItem::whereIn('order_id',$orders)->whereDate('created_at', Carbon::yesterday())->sum('qty'); 

                    $salesRegionArr[$key]['unit'] = $todayCount;
                    if($yesterdayCount > 0)
                    {
                        $count_sum = $todayCount-$yesterdayCount;
                        $per = ($count_sum * 100) /$yesterdayCount;
                        $salesRegionArr[$key]['percentage'] = number_format($per,2);
                    }
                    else
                    {
                        $salesRegionArr[$key]['percentage'] = $todayCount;
                    }
                }  
            }
        }

        return collect($salesRegionArr);
    }

    public function headings(): array
    {
       return [
         'City',
         'Unit',
         'Percentage',
       ];
    }
}
