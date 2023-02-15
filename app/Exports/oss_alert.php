<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

class oss_alert implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        
        // $city = $this->city_id;
        $data_oos = DB::table('stocks')
            ->where('qty', '<=', 5)
            ->leftjoin("kiosk", "stocks.kiosk_id", "=", "kiosk.id")
            ->leftjoin("city", "kiosk.city_id", "=", "city.id")
            ->leftjoin("products", "stocks.product_id", "=", "products.id")
            ->leftjoin("brand", "products.brand_id", "=", "brand.id")
            ->select('products.sku', 'products.name as product_name','brand.name as brand_name', 'stocks.qty', 'kiosk.kiosk_name', 'city.name as city_name')
            ->get();
        // dd($data_oos);
        return $data_oos;
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
