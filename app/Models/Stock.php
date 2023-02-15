<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;


    public function requested_qty_product_details(){
        
        return $this->hasMany('App\Models\Product','id','product_id');
    }

    public function stocks_filter(){
        
        return $this->hasMany('App\Models\Product','id','product_id');
    }

}
