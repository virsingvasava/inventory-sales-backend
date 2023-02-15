<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\City;
use App\Models\Kiosk;
use App\Models\Notification;
use App\Models\UserDeviceToken;
use Validator;
use JWTAuth;
use Response;
use JWTFactory;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    
    /* 
    *   Login API 
    *   Check user status 
    *   If 1 then it will be consider as active user other wise in-active
    */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => "required",
            'city_id' => "required",
        ]);
        
        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }

        $username = $request->username;
        $city_id = $request->city_id;

        $check_credential = User::where('email', $username)->orWhere('mobile',$username)->first();
        $check_cityId = Kiosk::where('city_id', $city_id)->first();

        if(!empty($check_credential)){

            $check_status = $check_credential->status;
            
            if($check_status == TRUE){

                if($check_credential['city_id'] == $city_id){

                    if(isset($request->device_token) && $request->device_token != "")
                    {
                        $this->addDeviceToken($check_credential->id,$request->device_token,$request->device_type);
                    }

                    $device_token = UserDeviceToken::where('user_id',$check_credential->user_id)->first();
                    if(!empty($device_token))
                    {
                        $title = ucfirst($check_credential->name)." is login successfully.";
                        $message = ucfirst($check_credential->name)." is login successfully.";
                        $token = $device_token->token;
                        sendPushNotification($title,$message,$token);
                    }

                    $notification = new Notification;
                    $notification->created_by_id = $check_credential->id;                 
                    $notification->message = ucfirst($check_credential->name)." is login successfully.";
                    $notification->status = 0;
                    $notification->save();
            
                    $userStatusCheck = User::where('id', $check_credential->id)->first();
                    if (!empty($userStatusCheck)) {
                        $userStatusCheck->login_logout_status =1;
                        $userStatusCheck->save();
                    }

                    $token = JWTAuth::fromUser($check_credential);
                    $check_credential['token'] = $token;

                    $message = 'Login successfully';
                    return SuccessResponse($message,200,$check_credential);
                } else {
                    $message = 'User can not login outside registered city';
                    return InvalidResponse($message,101);
                }
                /*
                $attendance = new Attendance;
                $attendance->user_id = $check_credential->id;                
                $attendance->login_at = date('Y-m-d H:i:s');
                $attendance->kiosk_id = $check_cityId->id;
                $attendance->save();
                */
            } else {

                $message = 'User is In active';
                return InvalidResponse($message,101);
            }

        } else {

            $message = "Please enter valid credentials";
            return InvalidResponse($message,101);
        }
    }

    public function logout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_token' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails())
        {   
            $message = $validator->errors()->first();
            return InvalidResponse($message, 101);
        }

        $jwt_user = User::where('id',$request->user_id)->first();
        $user_id = $jwt_user->id;
 
        $device_token = UserDeviceToken::where('user_id',$request->user_id)->first();
        if(!empty($device_token))
        {
            $title = ucfirst($jwt_user->name)." is logout successfully.";
            $message = ucfirst($jwt_user->name)." is logout successfully.";
            $token = $device_token->token;
            sendPushNotification($title,$message,$token);
        }
            
        UserDeviceToken::where('user_id',$user_id)->where('token',$request->device_token)->delete();

        $notification = new Notification;
        $notification->created_by_id = $jwt_user->id;                 
        $notification->message = ucfirst($jwt_user->name)." is logout successfully.";
        $notification->status = 0;
        $notification->save();
      
        $attendance = Attendance::where(['user_id' => $user_id, 'logout_at' => NULL])->orderBy('id','desc')->first(); // where logout == null
        if (!empty($attendance)) {

            $attendance->user_id =  $jwt_user->id;           
            $attendance->logout_at = local_timezone();
            $attendance->save();
        }

        $user_status_update = User::where('id', $user_id)->first();
        if (!empty($user_status_update)) {
            $user_status_update->login_logout_status = FALSE;
            $user_status_update->save();
        }
        
        $message = 'User logout successfully';
        return SuccessResponse($message,200,[]);
    }

    public function addDeviceToken($user_id,$device_token,$device_type)
    {
        UserDeviceToken::where('user_id',$user_id)->delete();

        $addDeviceToken = new UserDeviceToken;
        $addDeviceToken->user_id = $user_id;
        $addDeviceToken->token = $device_token;
        $addDeviceToken->device_type = $device_type;
        $addDeviceToken->save();

        return true;
    }

    public function login_verified(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => "required",
            'kiosk_id' => "required",
        ]);
        
        if ($validator->fails()) {
            $message = $validator->messages()->first();
            return InvalidResponse($message,101);
        }
      
        $attendance = new Attendance;
        $attendance->user_id = $request->user_id;                
        $attendance->login_at = local_timezone();
        $attendance->kiosk_id = $request->kiosk_id; 
        $attendance->save();

        $message = 'Login verified Successfully.';

        return SuccessResponse($message, 200, $attendance);

    }
}
