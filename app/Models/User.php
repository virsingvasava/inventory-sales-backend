<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    use Notifiable;

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function city_name(){
        
        return $this->hasMany('App\Models\City','id','city_id');
    }

    protected $fillable = ['name','email','name','phone_code','mobile', 'date_of_joining', 'profile_img', 'role', 'role_id', 'user_id', 'city_id', 'status', 'password'];

}


