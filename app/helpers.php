<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Models\User as UserModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

CONST ADMIN_ROLE = 1;
CONST AIRPORT_MANAGER = 2;
CONST BRANCH_MANAGER = 3;
CONST HO = 4;
CONST SALESMAN = 5;


function veriftyAPITokenData($header) 
{
    try 
    {
        $authorization_cred = Crypt::decrypt($header);
        $expcred = explode('|', $authorization_cred);
        $apiuser = $expcred[0];
        $apipassword = $expcred[1];
    } 

    catch(\Exception $e) 
    {
        $message = "Invalid User Authentication";
        return InvalidResponse($message,101);
    }

    $user = UserModel::where('email', $apiuser)->where('role',API_ROLE)->first();
    if ($user && Hash::check($apipassword, $user->password)) 
    {
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Token valid',
            'data' => array(),
        ]);
    } 
    else 
    {
        $message = 'Invalid Token';
        return InvalidResponse($message,101);
    }
}

function SuccessResponse($message,$status_code,$data)
{
    return response()->json(['success' => true,
		'status_code' => $status_code,
		'message' => $message,
		'data' => $data
    ]);
}

function numberFormat($number)
{
    $number_data = number_format((float)$number, 2, '.', '');
    return $number_data;
}

function InvalidResponse($message,$status_code)
{
    return response()->json(['success' => false,
		'status_code' => $status_code,
		'message' => $message,
		'data' => array()
    ]);
}

function generateRandomString($length)
{
	$randomString = '';
	$characters = '123456789';
	$characterLengths = strlen($characters);
	for($i=0; $i<$length;$i++)
	{
		$randomString .= $characters[rand(0,$characterLengths - 1)];
	}
	return $randomString;
}

function generateRandomToken($length)
{
	$randomString = '';
	$characters = 'ABCDEFGHIJKLMNOPQRSTUVWZY';
	$characterLengths = strlen($characters);
	for($i=0; $i<$length;$i++)
	{
		$randomString .= $characters[rand(0,$characterLengths - 1)];
	}
	return $randomString;
}


function change_timezone_local($value,$timezone) {
    if($timezone == ''){
        $timezone = 'UTC';
    }
    return Carbon::createFromTimestamp(strtotime($value))->timezone($timezone)->toDateTimeString();
}

function get_current_timezone()
{
    //$ip = "189.240.194.147";  //$_SERVER['REMOTE_ADDR'];

    $ip = $_SERVER['REMOTE_ADDR'];
    $ipInfo = file_get_contents('http://ip-api.com/json/' . $ip);
    $ipInfo = json_decode($ipInfo);

    if($ipInfo->status == 'fail'){
        $timezone = 'UTC';
    } else {
        $timezone = $ipInfo->timezone;  
    }
    return $timezone;
    //return 'Asia/Kolkata';
}
function local_timezone(){
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("Y-m-d h:i A");
    return $timestamp;
}

function utcToLocal($value) {

    $timezone = 'Asia/Kolkata';
    return Carbon::parse($value, 'UTC')->setTimezone($timezone)->format('Y-m-d H:i:s');
}

function localToUtc($value) {

    $timezone = 'UTC';
    return Carbon::parse($value, 'Asia/Kolkata')->setTimezone($timezone)->format('Y-m-d H:i:s');
}

 function greeting_message()
 {
    date_default_timezone_set('Asia/Calcutta');

    $Hour = date('G');

    if ( $Hour >= 5 && $Hour <= 11 ) {
        $greetings = "Good Morning";
    } else if ( $Hour >= 12 && $Hour <= 18 ) {
        $greetings = "Good Afternoon";
    } else if ( $Hour >= 19 || $Hour <= 4 ) {
        $greetings = "Good Evening";
    }

    return $greetings;
}

// function sendPushNotification1($title,$message)
// {
//     $url = 'https://fcm.googleapis.com/fcm/send';

//     $notification = ['title' =>$title, 'body' => $message ];

//     $server_key = '';
//     $topic = '';
   
//     $extraNotificationData = ["message" => $notification,"moredata" =>'dd'];
//     $fcmNotification = [
//         'to'  => $topic,
//         'notification' => $notification,
//         'data' => $extraNotificationData
//     ];

//     $fields = json_encode ( $fcmNotification );

//     $headers = array (
//         'Authorization: key=' .$server_key,
//         'Content-Type: application/json'
//     );

//     $ch = curl_init ();
//     curl_setopt ( $ch, CURLOPT_URL, $url );
//     curl_setopt ( $ch, CURLOPT_POST, true );
//     curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
//     curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
//     curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

//     $result = curl_exec ( $ch );
//     echo $result;
//     curl_close ( $ch );
// }

function sendPushNotification($title,$message,$token, $data = [])
{
    $url = 'https://fcm.googleapis.com/fcm/send';

    $notification = ['title' =>$title, 'body' => $message ];

    $server_key = 'AAAAz6jPnHY:APA91bEguS6p9RsOrXF4W6J6ukUvOlJV7tDiOVQFAGj74G6uHeobbuX6710YLO41zghNYNmxhQnI2Bz4AGgK-bK8UsjLS0iIVx8TeGvQA80aLLINtF_KkguvRRjjePUo0mg7MvyAQuQc';

    $extraNotificationData = ["message" => $notification];

    $fcmNotification = [
        'to'  => $token,
        'notification' => $notification,
        'data' => $extraNotificationData
    ];

    $fields = json_encode ( $fcmNotification );

    $headers = array (
        'Authorization: key=' .$server_key, 
        'Content-Type: application/json'
    );

    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $url );
    curl_setopt ( $ch, CURLOPT_POST, true );
    curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

    $result = curl_exec ( $ch );
    curl_close ( $ch );
}
?>

