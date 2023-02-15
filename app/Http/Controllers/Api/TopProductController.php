<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;


class TopProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /* 
    *   Product List API 
    *   Check product status 
    *   If 1 then it will be consider as active product other wise in-active
    */
   
    public function top_products(Request $request)
    {
        $inputData  = $request->all();
        $user_token = $request->header('authorization');
        $jwt_user   = JWTAuth::parseToken()->authenticate($user_token);
        $userId     = $jwt_user->id;

        $top_items = OrderItem::with('top_products_details')
        ->orderBy('qty','DESC')
        ->limit(10)
        ->get(['id', 'order_id', 'user_id', 'qty', 'price', 'product_id', 'total_amount']);
        $topProductArray['top_products'] = $top_items;
        
        if(empty($top_items)){
            $message = "Top product not found";
            return InvalidResponse($message,101);
        }

        $message = 'Fetch top products listing successfully.';
        return SuccessResponse($message,200,$topProductArray);
    }
}
