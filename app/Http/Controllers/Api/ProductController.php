<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Kiosk;
use App\Models\Stock;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;


class ProductController extends Controller
{
    /* 
    *   Product List API 
    *   Check product status 
    *   If 1 then it will be consider as active product other wise in-active
    */
    public function product_list(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }
        
        $brand_id = $request->brand_id;
        
        $product_list = Product::with('brands_details')->where(['brand_id' => $brand_id, 'status' =>TRUE])->get();

        if(empty($product_list)){
            $message = "Product not found";
            return InvalidResponse($message,101);
        }
        $message = 'Fetch product listing successfully.';
        return SuccessResponse($message,200,$product_list);
    }


    public function product_details(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'kiosk_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }
        
        $kioskId = $request->kiosk_id;

        $stock_list = Kiosk::with('stock_details')->where(['kiosk_id' => $kioskId, 'status' =>TRUE])->get();

        if(empty($stock_list)){
            $message = "Product not found";
            return InvalidResponse($message,101);
        }
        $message = 'Fetch product listing successfully.';
        
        return SuccessResponse($message,200,$stock_list);
    }



}


