<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Brand extends Model
{
    use HasFactory;
    protected $table = 'brand';
    
    public function products(){
        
        return $this->hasMany('App\Models\Product','brand_id','id');
    }

    public static function getBrands($search_keyword){
        //$brand = DB::table('brand');
        $brand = DB::table('brand')->select('name')->get();
        if($search_keyword && !empty($search_keyword)){
            // p($search_keyword);
            $brand = DB::table('brand')->where('name','like', '%'.$search_keyword.'%')->first();           
            //p($searchBrand);

            // $brand->where(function($q) use ($search_keyword){
            //     $q->where('brand.name','like',"%{$search_keyword}%");
            // });
        }
     
        // dd($searchBrand);
        return $brand;
    }
}
