<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class BrandController extends Controller
{ 
    /* 
    *   Brand List API 
    *   Check brand status 
    *   If 1 then it will be consider as active brand other wise in-active
    */
    public function brand_list(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'kiosk_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message, 101);
        }

        $brand_list1 = Brand::with('products')->where('status', '=', TRUE)->get();

        $brand_list = Brand::where('status', '=', TRUE)->with(['products' => function($data) 
            use($request){ 
                $data->with(['products_stock' => function($stock) 
                use($request){ 
                    $stock->where('kiosk_id' , $request->kiosk_id)
                    ->where('qty', '!=', 0);
                }
            ]);
            },
        ])->get();

        if(empty($brand_list)){
            $message = "Brand not found";
            return InvalidResponse($message,101);
        }
        $message = 'Fetch brand listing successfully.';
        return SuccessResponse($message,200,$brand_list);
    }

}
