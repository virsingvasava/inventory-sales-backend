<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;

use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;
use Auth;

class ImportProduct implements ToModel, WithStartRow

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
        $brand = Brand::where('name',$row[0])->first();
        $id = $brand->id;

        
        if (empty($brand)) {
          
            return null;
        }
        return new Product([
            'brand_id' => $id,
            'sku'    => $row[1],
            'name' => $row[2],
            'packge_size' => $row[3],
            'price' => $row[4],
            'status' => TRUE,
        ]);
    }
}
