<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class CityController extends Controller
{
    /* 
    *   City List API 
    *   Check City status 
    *   If 1 then it will be consider as active City other wise in-active
    */
    public function city_list(Request $request)
    {
        $city_list = City::where(['status' =>TRUE])->get();

        if(empty($city_list)){
            $message = "City not found";
            return InvalidResponse($message,101);
        }

        $message = 'Fetch cities listing successfully.';
        return SuccessResponse($message,200,$city_list);
    }
}
