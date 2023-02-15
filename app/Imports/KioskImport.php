<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Kiosk;
use App\Models\OutletLocation;
use App\Models\City;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;
use Auth;


class KioskImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $outlet_location = OutletLocation::where('name',$row[1])->first();

        if (empty($outlet_location)) {

            $outletLocation = new OutletLocation;
            $outletLocation->name = $row[1];
            $outletLocation->status = TRUE;
            $outletLocation->save();
            $outlet_locationId = $outletLocation->id;
        }else{
            $outlet_locationId = $outlet_location->id;

        }

        $city = City::where('name',$row[2])->first();
        
        if (empty($city)) {

            $city = new city;
            $city->name = $row[2];
            $city->status = TRUE;
            $city->save();
            $cityId = $city->id;
        }else{
            $cityId = $city->id;
        }

        $kiosk = Kiosk::get()->count();
        $kiosk_id = $kiosk+true;
        $kiosk_genrateId = 'KOS_'.$kiosk_id;

        return new Kiosk([
            'kiosk_name' => $row[0],
            'kiosk_id'  => $kiosk_genrateId, 
            'outlet_location_id' => $outlet_locationId,
            'city_id' => $cityId,
            'status' => TRUE,
        ]);
    }
}
