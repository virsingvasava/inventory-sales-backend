<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kiosk extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $table = 'kiosk';
    
    protected $fillable = [
        'id', 
        'kiosk_id', 
        'city_id', 
        'kiosk_name', 
        'outlet_location_id', 
        'status' 
    ];

    public function stock_details(){
        
        return $this->hasMany('App\Models\Stock','kiosk_id','kiosk_id');
    }

    public function city_name(){
        
        return $this->hasMany('App\Models\City','id','city_id');
    }

    public function single_city_name(){
        
        return $this->hasOne('App\Models\City','id','city_id');
    }

    public function outlet_location(){
        
        return $this->hasMany('App\Models\OutletLocation','id','outlet_location_id');
    }

    public function outlet_location_single(){
        
        return $this->hasOne('App\Models\OutletLocation','id','outlet_location_id');
    }
}
