<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Kiosk;
use Auth;
use DB;

class ExportKioskData implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $kiosk_obj = Db::table('kiosk')
        ->leftJoin("outlet_location", "kiosk.outlet_location_id", "=", "outlet_location.id")
        ->leftJoin("city", "kiosk.city_id", "=", "city.id")
        ->select('kiosk.kiosk_id','kiosk.kiosk_name','outlet_location.name as location','kiosk.airport','city.name as City')
        ->get();

        return collect($kiosk_obj);

    }

    public function headings(): array
    {
       return [
         'Kiosk ID',
         'Kiosk Name',
         'Location',
         'Airport',
         'City',
       ];
    }
}
