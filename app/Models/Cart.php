<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    public function products(){
        
        return $this->hasMany('App\Models\Product','id','product_id');
    }


    public function products_stock_qty(){
        
        return $this->hasMany('App\Models\Stock','product_id','product_id');
    }

}
