<?php

namespace App\Exports;

use App\Models\City;
use App\Models\Kiosk;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class Export_oss implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct(String $city_id = null, String $kiosk_id = null)
    {
        $this->city_id = $city_id;
        $this->$kiosk_id = $kiosk_id;
        // dd($this->$kiosk_id);
    }

    public function collection()
    {
        $oos_alert = Kiosk::where('city_id', $this->city_id)->get();
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
                        $cityId = City::where('id', $this->city_id)->first();
                        $v->kiosk_name =  $value->kiosk_name;
                        $v->city_name = $cityId->name;
                        $test[] = $v;
                    }
                }
            }
        }
        return $test;
        
    }

    public function headings(): array
    {
        return [
            'Sku',
            'Product Name',
            'Brand',
            'Quantity',
            'Kiosk Name',
            'City',
        ];
    }
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
            },
        ];
    }
}
