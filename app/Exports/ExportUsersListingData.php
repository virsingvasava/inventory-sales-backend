<?php

namespace App\Exports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\User;
use Auth;
use DB;

class ExportUsersListingData implements  FromCollection, WithHeadings
{
    public function collection()
    {
        $user_obj = Db::table('users')
        ->whereNotIn('role', [TRUE ,FALSE])
        ->select("users.user_id",
                 "users.name as user_name",
                 "users.email",
                 "city.name as City", 
                 \DB::raw('(CASE 
                      WHEN users.role = "1" THEN "Admin" 
                      WHEN users.role = "2" THEN "Airport Manager" 
                      WHEN users.role = "3" THEN "Branch Manager" 
                      WHEN users.role = "4" THEN "HO"
                      WHEN users.role = "5" THEN "Salesman"
                      END) AS role_lable')
                  )
        ->leftJoin("city", "users.city_id", "=", "city.id")
        ->get();
        return collect($user_obj);
    }

    public function headings(): array
    {
       return [
         'User ID',
         'User Name',
         'Email',
         'City',
         'Role',
       ];
    }
}
