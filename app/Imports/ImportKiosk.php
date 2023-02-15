<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Kiosk;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;
use Auth;


class ImportKiosk implements ToCollection
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

        // $store = new Kiosk;
        // $store->kiosk_name = $request->kisok_name;
        // $store->kiosk_id = $request->kiosk_id;
        // $store->outlet_location_id = $request->location_id;
        // $store->city_id = $request->city_id;
        // $store->status = $request->status;
        // $store->save();

        return new Kiosk([
            'kiosk_name' => $row[1],
            'kiosk_id'  => $row[1],
            'outlet_location_id' => $row[2],
            'city_id' => $row[3],
            'status' => TRUE,
        ]);
    }
}
