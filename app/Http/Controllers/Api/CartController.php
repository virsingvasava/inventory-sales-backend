<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function addToCart(Request $request)
    {
        $inputData  = $request->all();
        $user_token = $request->header('authorization');
        $jwt_user   = JWTAuth::parseToken()->authenticate($user_token);
        $userId     = $jwt_user->id;

        $validator  = Validator::make($request->all(), [
            'product_id'    => 'required',
            'qty'           => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message, 101);
        }

        $productId = $request->product_id;
        $get_price = Product::where('id', $productId)->first();
        $itemIdCheck = Cart::where(['user_id' => $userId, 'product_id' => $productId])->count();


        if ($itemIdCheck == 0) {

            $addToCart = new Cart;
            $addToCart->user_id   = $userId;
            $addToCart->product_id = $request->product_id;
            $addToCart->qty  = $request->qty;
            $addToCart->price  = $get_price->price;
            $addToCart->sub_total_amount  = (int)$get_price->price * (int)$request->qty;
            $addToCart->save();

            $message = 'Item add to cart Successfully.';

        } else {

            $inputData  = $request->all();
            $user_token = $request->header('authorization');
            $jwt_user   = JWTAuth::parseToken()->authenticate($user_token);
            $userId     = $jwt_user->id;

            $qtyCheck = $request->qty;

            if ($qtyCheck == 0) {

                $getItem = Cart::where(['user_id' => $userId, 'product_id' => $productId])->first();
                $res = Cart::findOrFail($getItem->id);
                $res->delete();

            } else {

                $cartItemUpdate = Cart::where(['user_id' => $userId, 'product_id' => $productId])->first();
                $cartItemUpdate->user_id = $userId;
                $cartItemUpdate->product_id = $request->product_id;
                $cartItemUpdate->qty  = $request->qty;
                $cartItemUpdate->price  = $get_price->price;
                $cartItemUpdate->sub_total_amount = (int)$get_price->price * (int)$request->qty;
                $cartItemUpdate->update();
            }
        }

        $cart_items_list = Cart::with('products')->where('user_id', $userId)->get()->toArray();
        $cart_items_count_check = Cart::where('user_id', $userId)->count();

        $subTotal = Cart::where('user_id', $userId)->sum('sub_total_amount');
        $total_quantity = Cart::where('user_id', $userId)->sum('qty');

        if (empty($cart_items_count_check) && $cart_items_count_check == 0) {

            return response()->json(['message' => 'Cart Item Not Found'], 404);

        } else {

            $message = 'Cart listing Successfully.';

            $data['cart_items_details'] = $cart_items_list;

            $data['total_quantity'] = $total_quantity;
            $data['total_amount'] = $subTotal;

            return SuccessResponse($message, 200, $data);
        }
    }

    public function getCartList(Request $request)
    {
        $inputData  = $request->all();
        $user_token = $request->header('authorization');
        $jwt_user   = JWTAuth::parseToken()->authenticate($user_token);
        $userId     = $jwt_user->id;

        // $items_Listing111 = Cart::with('products', 'products_stock_qty')->where('user_id', $userId)->get();

        $items_Listing = Cart::where('user_id', $userId)->with(['products' => function($data) 
            use($request){ 
                $data->with(['products_stock' => function($stock) 
                use($request){ 
                    $stock->where('kiosk_id' , $request->kiosk_id)
                    ->where('qty', '!=', 0);
                }
            ]);
            },
        ])->get();


        $get_cartListing = Cart::where('user_id', $userId)->count();

        $total_amount = Cart::where('user_id', $userId)->sum('sub_total_amount');
        $total_quantity = Cart::where('user_id', $userId)->sum('qty');


        if (empty($get_cartListing) && $get_cartListing == 0) {

            $message = "Cart not found";
            return InvalidResponse($message,101);

        } else {

            $message = 'Cart listing Successfully.';

            $data['cart_items_details'] = $items_Listing;
            $data['total_quantity'] = $total_quantity;
            $data['total_amount'] = $total_amount;

            return SuccessResponse($message, 200, $data);
        }
    }

    public function removeItem(Request $request)
    {
        $inputData = $request->all();

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message, 101);
        }

        $user_token = $request->header('authorization');
        $jwt_user   = JWTAuth::parseToken()->authenticate($user_token);
        $userId     = $jwt_user->id;

        $itemIdCheck = Cart::where(['user_id' => $userId, 'product_id' => $request->product_id])->count();

        if ($itemIdCheck == 0) {

            $message = 'Item Not Found';
            return InvalidResponse($message, 101);
        } else {

            $cart = Cart::where(['user_id' => $userId, 'product_id' => $request->product_id])->first();
            $cart->delete();
            $message = 'Cart Item Delete Successfully.';
            return SuccessResponse($message, 200, null);
        }
    }
}
