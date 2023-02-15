<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kiosk;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;


class KioskController extends Controller
{
    /* 
    *   Kiosk List API 
    *   Check Kiosk status 
    *   If 1 then it will be consider as active Kiosk other wise in-active
    */
    public function kiosk_list(Request $request)
    {
        $kiosk_list = Kiosk::where(['status' =>TRUE])->get();

        if(empty($kiosk_list)){
            $message = "Kiosk not found";
            return InvalidResponse($message,101);
        }

        $message = 'Fetch Kiosk listing successfully.';
        return SuccessResponse($message,200,$kiosk_list);
    }

    /* 
    *   Kiosk List API 
    *   Check Kiosk status 
    *   If 1 then it will be consider as active Kiosk other wise in-active
    */
    public function kiosk_list_by_city(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'city_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }
        
        $city_id = $request->city_id;
        
        $kiosk_list_city = Kiosk::where(['city_id' => $city_id, 'status' =>TRUE])->get();

        if(empty($kiosk_list_city)){
            $message = "Kiosk not found";
            return InvalidResponse($message,101);
        }
        $message = 'Fetch Kiosk listing successfully.';
        return SuccessResponse($message,200,$kiosk_list_city);
    }
}
