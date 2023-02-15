<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Validator;
use DB;

class LowInventoryController extends Controller
{
    /* 
    *   Low inventory List API 
    *   Check Low inventory status 
    *   If 1 then it will be consider as active Low inventory other wise in-active
    */
    public function low_inventory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kiosk_id' => 'required',
        ]);
        
        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }

        $low_inventory = DB::select('SELECT IFNULL(stocks.requested_qty, 0) as requested_qty, stocks.qty, brand.name as brand_name, products.name as product_name, products.price, products.packge_size, products.id as productId, "'.$request->kiosk_id.'" as kioskId   
            FROM `brand` 
            LEFT JOIN products on products.brand_id = brand.id
            LEFT JOIN stocks on stocks.product_id = products.id AND stocks.kiosk_id = "'.$request->kiosk_id.'"
            WHERE stocks.qty <= 10 OR stocks.qty IS NULL');
        
        $check = count($low_inventory);
        if($check == 0){
            $message = "Low inventory not found";
            return InvalidResponse($message,101);
        }else{
            $message = 'Fetch low inventory listing successfully.';
            return SuccessResponse($message,200,$low_inventory);
        }
    }
}
