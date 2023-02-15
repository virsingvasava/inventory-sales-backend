<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    
    /* 
    *   User List API 
    *   Check user status 
    *   If 1 then it will be consider as active user other wise in-active
    */
    public function user_list(Request $request)
    {
        $user_list = User::where('status', '=', TRUE)->get();

        if(empty($user_list)){
            $message = "User not found";
            return InvalidResponse($message,101);
        }
        $message = 'Fetch users listing successfully.';
        return SuccessResponse($message,200,$user_list);
    }
}
