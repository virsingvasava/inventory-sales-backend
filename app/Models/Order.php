<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    public function order_item_details(){

        return $this->hasMany('App\Models\OrderItem','order_id','id');
    }


    public function attendance_details(){

        return $this->hasMany('App\Models\Attendance','kiosk_id','kiosk_id');
    }

    public function kiosk_details()
    {
        return $this->hasOne('App\Models\Kiosk','id','kiosk_id');
    }

    public function sales_person()
    {
        return $this->hasOne('App\Models\User','id','sale_by_user_id');
    }

    public function order_items()
    {
        return $this->hasMany('App\Models\OrderItem','order_id','id');
    }

}
