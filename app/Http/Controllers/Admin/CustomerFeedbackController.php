<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerFeedBack;
use App\Models\OutletLocation;
use App\Models\Kiosk;

class CustomerFeedbackController extends Controller
{
    public function index() 
    {
        $customerFeedBack = CustomerFeedBack::where(['user_id' => 2, 'feedback_question_id' => 1])->get();

        $feedbackArray[] = "";

        foreach($customerFeedBack as $key  => $value){

            $liked_votes = CustomerFeedBack::where(['user_id' => $value->user_id, 'feedback_question_id' => $value->feedback_question_id])->get()->sum('liked_votes');

            $feedbackArray['liked_votes'] = $liked_votes;

            $unliked_votes = CustomerFeedBack::where(['user_id' => $value->user_id, 'feedback_question_id' => $value->feedback_question_id])->get()->sum('unliked_votes');

            $feedbackArray['unliked_votes'] = $unliked_votes;
        }
        return view('admin.customer_feedback.index',compact('feedbackArray'));
    }
}
