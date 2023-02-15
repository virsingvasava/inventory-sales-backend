<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OutletLocation;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;


class OutletLocationController extends Controller
{
    /* 
    *   Outlet Location List API 
    *   Check Outlet Location status 
    *   If 1 then it will be consider as active Outlet Location other wise in-active
    */
    public function outlet_location_list(Request $request)
    {
        $outletLocation_list = OutletLocation::where(['status' =>TRUE])->get();

        if(empty($outletLocation_list)){
            $message = "Outlet location not found";
            return InvalidResponse($message,101);
        }

        $message = 'Fetch Outlet location listing successfully.';
        return SuccessResponse($message,200,$outletLocation_list);
    }
}
