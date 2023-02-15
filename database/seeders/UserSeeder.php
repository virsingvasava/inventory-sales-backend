<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Brand;
use App\Models\City;
use App\Models\OutletLocation;
use App\Models\Kiosk;
use App\Models\FeedBackQuestion;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User;
        $admin->name = 'Super Admin';
        $admin->phone_code = 91;
        $admin->mobile = '9999988888'; 
        $admin->email = 'admin@itcsales.com';
        $admin->password = Hash::make('itc@123');
        $admin->role = ADMIN_ROLE;
        $admin->user_id = 'Admin_1';
        $admin->role_id = ADMIN_ROLE;
        $admin->city_id = 1;
        $admin->date_of_joining = "2022-08-03";
        $admin->status = TRUE;
        $admin->save();

        $user0 = new User;
        $user0->name = 'AIRPORT_MANAGER of Department';
        $user0->email = 'airport_manager@gmail.com';
        $user0->password = Hash::make('airport_manager@123');
        $user0->phone_code = '+91'; 
        $user0->mobile = '9999977777'; 
        $user0->profile_img = 'profile.jpg';
        $user0->user_id = 'User_2';
        $user0->role_id = AIRPORT_MANAGER;
        $user0->city_id = 21;
        $user0->date_of_joining = "2022-08-03";
        $user0->logged_in_kiosk_id = 1;
        $user0->remember_token = null;
        $user0->role = AIRPORT_MANAGER;
        $user0->status = TRUE;
        $user0->save();


        $user1 = new User;
        $user1->name = 'Nikunj';
        $user1->email = 'salesman@gmail.com';
        $user1->password = Hash::make('salesman@123');
        $user1->phone_code = '+91'; 
        $user1->mobile = '9999966666'; 
        $user1->profile_img = 'profile.jpg';
        $user1->user_id = 'User_3';
        $user1->role_id = SALESMAN;
        $user1->city_id = 3;
        $user1->date_of_joining = "2022-08-03";
        $user1->logged_in_kiosk_id = TRUE;
        $user1->remember_token = NULL;
        $user1->role = SALESMAN;
        $user1->status = TRUE;
        $user1->save();

        $kiosk = new Kiosk;
        $kiosk->kiosk_id = 'KOS_1';
        $kiosk->city_id = '1';
        $kiosk->kiosk_name = 'Kiosk Name';
        $kiosk->outlet_location_id = 1; 
        $kiosk->status = 1;
        $kiosk->save();
      
        $product1 = new Product;
        $product1->brand_id = '1';
        $product1->sku = 'SKU 1';
        $product1->name = 'Classic 1';
        $product1->packge_size = 10; 
        $product1->price = 100;
        $product1->discount = null;
        $product1->text = null;
        $product1->status = 1;
        $product1->save();

        $product2 = new Product;
        $product2->brand_id = '1';
        $product2->sku = 'SKU 2';
        $product2->name = 'Classic 2';
        $product2->packge_size = 20; 
        $product2->price = 200;
        $product2->discount = null;
        $product2->text = null;
        $product2->status = 1;
        $product2->save();

        $stocks = new Stock;
        $stocks->kiosk_id = 1;
        $stocks->product_id = 1;
        $stocks->qty = 100;
        $stocks->requested_qty = 10; 
        $stocks->status = FALSE;
        $stocks->save();
      

        /* Brands */
        
        $brands= config('setting.brands');
        foreach ($brands as $key => $val) {
          Brand::create([
            'name' => $val, 
            'status' => 1
          ]); 
        }
        

         /* Cities */
        $city= config('setting.city');
        foreach ($city as $key => $val) {
          City::create([
            'name' => $val, 
            'status' => 1
          ]); 
        }

         /* outlet_location */
         $outlet_location= config('setting.outlet_location');
         foreach ($outlet_location as $key => $val) {
          OutletLocation::create([
             'name' => $val, 
             'status' => 1
           ]); 
         }

          /* FAQ */
          $faq= config('setting.faq');
          foreach ($faq as $key => $val) {
            FeedBackQuestion::create([
              'questions' => $val, 
              'status' => 1
            ]); 
          }

    }

     
}
