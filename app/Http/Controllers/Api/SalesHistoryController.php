<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Validator;
use Carbon\Carbon;

class SalesHistoryController extends Controller
{
    public function sales_history(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // 'kiosk_id' => 'required',
            'user_id' => 'required',
            'payment_mode' => 'required',
            'date' => 'required',
        ]);
        
        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }
        
        $kiosk_id = $request->kiosk_id;
        $user_id = $request->user_id;

        $payment_mode = $request->payment_mode;
        $date = $request->date;

        $start = $request->date ." 00:00:00";
        $end = $request->date . " 23:59:59";
    

        $sales_history = Order::where(['sale_by_user_id' => $user_id])
        ->where([
                ['created_at', '>=',$start],
                ['created_at', '<=',$end]    
        ])
        ->with(['order_item_details' => function ($data) 
            use($request){ 
                $data->with('products_details');
            },
        ]);

        if($payment_mode != "All"){
            $sales_history->where('payment_mode', $payment_mode);
        }

        $sales_history = $sales_history->get();
       
        $check = count($sales_history);
        if($check == 0){

            $message = "Sale history not found";
            return InvalidResponse($message,101);

        }else{
            $finalData = [];
            foreach($sales_history as $row){
                if(count($row->order_item_details) > 0){
                    if(count($row->order_item_details[0]->products_details) > 0){
                        $temp = [];
                        $temp['product_name'] = $row->order_item_details[0]->products_details[0]->name;
                        $temp['payment_mode'] = $row->payment_mode;
                        $temp['amount'] = $row->order_item_details[0]->total_amount;
                        $finalData[] = $temp;
                    }
                } 
            }
            $message = 'Fetch Sales history listing successfully.';
            return SuccessResponse($message,200,$finalData);
        }
    }

}
