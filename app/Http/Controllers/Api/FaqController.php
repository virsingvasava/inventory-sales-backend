<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FeedBackQuestion;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class FaqController extends Controller
{
    /* 
    *   FeedBackQuestion List API 
    *   Check FeedBackQuestion status 
    *   If 1 then it will be consider as active FeedBackQuestion other wise in-active
    */
    public function feedback_question_list(Request $request)
    {
        $feedBackQuestion = FeedBackQuestion::where('status', TRUE)->get();
        $faqCheck = FeedBackQuestion::where('status', TRUE)->get()->count();

        if($faqCheck == 0){
            $message = "Feedback Question not found (Not available in database)";
            return InvalidResponse($message,101);
        }
        
        $message = 'Fetch feedback question listing successfully.';
        return SuccessResponse($message,200,$feedBackQuestion);
    }
} 
