<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';

    public function products_details(){

        return $this->hasMany('App\Models\Product','id','product_id');
    }

    public function one_product_details(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }

    public function top_products_details(){
        
        return $this->hasMany('App\Models\Product','id','product_id');
    }

    public function products_detail(){

        return $this->hasOne('App\Models\Product','id','product_id');
    }
}
