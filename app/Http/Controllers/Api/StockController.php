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

class StockController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /* 
    *   Stocks List API 
    *   Check Stocks status 
    *   If 1 then it will be consider as active Stocks other wise in-active
    */
    public function stock_list(Request $request)
    {
        $inputData  = $request->all();
        $user_token = $request->header('authorization');
        $jwt_user   = JWTAuth::parseToken()->authenticate($user_token);
        $userId     = $jwt_user->id;

        $validator = Validator::make($request->all(), [
            'kiosk_id' => 'required',
        ]);

        $stock_list = Brand::where('status', '=', TRUE)->with(['products' => function($data) 
            use($request){ 
                $data->with(['products_stock' => function($stock) 
                use($request){ 
                    $stock->where('kiosk_id', $request->kiosk_id);
                }
            ]);
            },
        ])->get();

        if(empty($stock_list)){
            $message = "Stock not found";
            return InvalidResponse($message,101);
        }

        $message = 'Fetch stock listing successfully.';
        return SuccessResponse($message,200,$stock_list);
    }

    public function requested_qty_update(Request $request){

        $inputData  = $request->all();
        $user_token = $request->header('authorization');
        $jwt_user   = JWTAuth::parseToken()->authenticate($user_token);
        $userId     = $jwt_user->id;

        $validator = Validator::make($request->all(), [
            'kiosk_id' => 'required',
            'product_id' => 'required',
            'qty' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message, 101);
        }

        $kioskId = $request->kiosk_id;
        $productId = $request->product_id;
        $qty = $request->qty;

        $qty_update = Stock::where(['kiosk_id' => $kioskId, 'product_id' => $productId])->first();
        
        if(!empty($qty_update)){
            
            $qty_update->kiosk_id = $kioskId;
            $qty_update->product_id = $productId;
            $qty_update->requested_qty = $qty;
            $qty_update->status = FALSE;
            $qty_update->save();

        }else{

            $addToStock = new Stock;
            $addToStock->kiosk_id = $kioskId;
            $addToStock->product_id = $productId;
            $addToStock->qty = isset($addToStock->qty) ? $addToStock->qty : 0;
            $addToStock->requested_qty = $qty;
            $addToStock->status = TRUE;
            $addToStock->save();

            $message = 'Requested qty added Successfully.';
            return SuccessResponse($message, 200, $addToStock);
        }
     
        $message = 'Fetch stock listing successfully.';

        return SuccessResponse($message,200,$qty_update);
    }

}
