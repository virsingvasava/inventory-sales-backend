<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Kiosk;
use App\Models\Order;
use Auth;
use DB;

class TopTenKioskExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
    }

    public function collection()
    {
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
        // dd($topTenKioskArr);
        return $topTenKioskArr;
    }

    public function headings(): array
    {
        return [
            'Kiosk',
            'City',
            'Terminal',
            'Total Order Count'
        ];
    }
}
