<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\User;
use App\Models\City;

use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Str;
use Auth;

class UsersImport implements ToModel, WithStartRow
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
        $city = City::where('name',$row[6])->first();
        $cityId = $city->id;
        if (empty($city)) {
            return null;
        }
        
        $user = User::get()->count();
        $userId = $user+true;
        $genrateUserId = 'User_'.$userId;

        if($row[3] == 'Airport Manager'){
            $role = 'Airport Manager';
            $roleId = AIRPORT_MANAGER;

        }elseif($row[3] == 'Branch Manager'){
            $role = 'Branch Manager';
            $roleId = BRANCH_MANAGER;

        }elseif($row[3] == 'HO'){
            $role = 'HO';
            $roleId = HO;

        }elseif($row[3] == 'Salesman'){
            $role = 'Salesman';
            $roleId = SALESMAN;

        }elseif($row[3] == 'Admin'){

            $role = 'Admin';
            $roleId = ADMIN_ROLE;
        }

        return new User([
            'name'  => $row[0], 
            'mobile' => $row[1],
            'email' => $row[2],
            'date_of_joining' => $row[4],
            'password' =>  Hash::make($row[5]),
            'profile_img' => NULL,
            'user_id' => $genrateUserId,
            'role_id' => $roleId,
            'role' => $roleId,
            'city_id' => $cityId,
            'status' => TRUE,
        ]);
    }
}
