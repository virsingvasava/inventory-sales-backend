<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    
    public function brands_details(){
        
        return $this->hasMany('App\Models\Stock','id','brand_id');
    }

    public function one_brand_details(){
        
        return $this->hasOne('App\Models\Stock','id','brand_id');
    }

    public function products_stock(){
        
        return $this->hasMany('App\Models\Stock','product_id','id');
    }


    public function brand_name(){
        
        return $this->hasMany('App\Models\Brand','id','brand_id');
    }

    protected $fillable = ['brand_id','sku','name','packge_size','price'];

}
