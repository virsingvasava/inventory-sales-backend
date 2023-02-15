<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\CustomerFeedBack;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class CustomerFeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function customer_feedback(Request $request){

        $inputData  = $request->all();

       //dd($inputData);


        $user_token = $request->header('authorization');
        $jwt_user = JWTAuth::parseToken()->authenticate($user_token);
        $userId   = $jwt_user->id;

        /*
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
            'feedback_question_id[0]' => 'required',
            'liked_votes[0]' => 'required',
            'unliked_votes[0]' => 'required',

            'feedback_question_id[1]' => 'required',
            'liked_votes[1]' => 'required',
            'unliked_votes[1]' => 'required',

            'feedback_question_id[2]' => 'required',
            'liked_votes[2]' => 'required',
            'unliked_votes[2]' => 'required',
        ]);

        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }
        */
        
        $feedBack = [];
        foreach($request['feedback'] as $key => $q){

            $create_feedback = new CustomerFeedBack;
            $create_feedback->user_id = $userId;
            $create_feedback->feedback_question_id = $q['feedback_question_id'];
            $create_feedback->order_id = $request['order_id'];
            $create_feedback->liked_votes = $q['liked_votes'];
            $create_feedback->unliked_votes = $q['unliked_votes'];
            $create_feedback->save();
        }

        $message = 'Feedback send successfully.';
        return SuccessResponse($message,200, $feedBack);
    }
}

