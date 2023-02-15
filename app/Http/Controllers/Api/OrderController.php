<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\Kiosk;
use App\Models\Stock;
use App\Models\Notification;
use App\Models\Attendance;
use App\Models\UserDeviceToken;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function create_order(Request $request){

        $inputData  = $request->all();

        $user_token = $request->header('authorization');
        $jwt_user = JWTAuth::parseToken()->authenticate($user_token);
        $userId   = $jwt_user->id;

        $validator = Validator::make($request->all(), [
            'kiosk_id' => 'required',
            'total_amount' => 'required',
            'payment_mode' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }

        $kioskDetails = Kiosk::where('id',$request->kiosk_id)->first();

        $create_order = new Order;
        $create_order->sale_by_user_id = $userId;
        $create_order->kiosk_id = $request->kiosk_id;
        $create_order->total_amount = $request->total_amount;
        $create_order->payment_mode = $request->payment_mode;
        $create_order->save();

        $cart_items_details =  Cart::where(['user_id' => $userId])->get();

        $packSold = 0;
        $orderCount = 0;

        foreach($cart_items_details as $key => $value){

            $products =  Product::where('id', $value->product_id)->first();
            $orders =  Order::where('sale_by_user_id', $value->user_id)->first();

            $orderItems = new OrderItem();
            $orderItems->user_id  = $value->user_id;
            $orderItems->order_id  =  $create_order->id;
            $orderItems->product_id  = $products->id;
            if(!empty($kioskDetails))
            {
                $orderItems->city_id  = $kioskDetails->city_id;
            }
            $orderItems->qty = $value->qty;
            $orderItems->price = $products->price;
            $orderItems->order_date = $orders->created_at;
            $orderItems->total_amount = (int)$products->price * (int)$value->qty;
            $orderItems->save();

            $stack_update = Stock::where(['product_id' => $value->product_id, 'kiosk_id' => $request->kiosk_id])->first();
            
            if (!empty($stack_update)) {
                $stack_update->qty = $stack_update->qty - $orderItems->qty;
                $stack_update->save();
                $packSold += $value->qty;
                $orderCount += 1;    
            }
          
        }

        $orderItemListing = OrderItem::where('order_id', $create_order->id)->get();
        
        $total_amount = OrderItem::where('user_id', $userId)->sum('total_amount');

        $data['orders_info'] = $create_order;
        $data['order_single_item_details'] = $orderItemListing;
        $data['total_amount'] = $total_amount;

        $data = [];
        $data = ['order_id' => $create_order->id];
        $message = 'Order place successfully';

        /* attendance */
        $attendance = Attendance::where('user_id', $userId)->orderBy('id','desc')->first();
        if (!empty($attendance)) {
            $attendance->pack_sold += $packSold;           
            $attendance->transaction_order_count = $orderCount;
            $attendance->total_sale = $total_amount;
            $attendance->save();
        } 
    
        $device_token = UserDeviceToken::where('user_id',$jwt_user->id)->first();
        if(!empty($device_token))
        {
            $title = ucfirst($jwt_user->name)." is Order Create successfully.";
            $message = ucfirst($jwt_user->name)." is Order Create successfully.";
            $token = $device_token->token;
            sendPushNotification($title,$message,$token);
        }

        $notification = new Notification;
        $notification->created_by_id = $jwt_user->id;         
        $notification->kiosk_id = $request->kiosk_id;                 
        $notification->message = ucfirst($jwt_user->name)." is Order Create successfully.";
        $notification->status = 0;
        $notification->save();

        /* Delete Cart Items */
        $delete_cart_items =  Cart::where(['user_id' => $userId])->get();
        if(!empty($delete_cart_items)){
            foreach($delete_cart_items as $key => $val){
                $result = Cart::findOrFail($val->id);
                $result->delete();
            }
        }
        return SuccessResponse($message,200,$data);
    }

    public function upload_order_receipt(Request $request){

        $inputData  = $request->all();

        $user_token = $request->header('authorization');
        $jwt_user = JWTAuth::parseToken()->authenticate($user_token);
        $userId   = $jwt_user->id;

        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'upload_order_receipt' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }

        $upload_order_receipt = Order::where(['id' => $request->order_id, 'sale_by_user_id' => $userId])->first();

        $orderReceipt = $request->upload_order_receipt;

        if ($request->upload_order_receipt) {
          
            $destination = public_path("assets/order_receipt");

            if(!is_dir($destination)){
                mkdir($destination, 0777, true);
            }
            $name = 'order_receipt_' . time();
            $orderReceiptName = $name . '.' . $orderReceipt->getClientOriginalExtension();
            $orderReceipt->move($destination, $orderReceiptName);

        } else {

            $orderReceiptName = null;
        }            

        if(!empty($orderReceiptName)){

            $upload_order_receipt->order_receipt = $orderReceiptName;
            $upload_order_receipt->update();

            $receipt_data = [];
            $message = 'Upload order receipt successfully';
            return SuccessResponse($message,200,$receipt_data);

        }else{

            $receipt_data = [];
            $message = 'Order receipt not upload';
            return SuccessResponse($message,200,$receipt_data);
        }
        
    }
}

