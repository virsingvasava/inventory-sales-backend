<?php

namespace App\Http\Controllers\AirportManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Stock;
use App\Models\Product;
use Auth;

class PendingRequestController extends Controller
{
    public function index() 
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $requestArray = User::with('city_name')
        ->where('city_id', $user->city_id)
        ->whereIn('role', [SALESMAN])->get();

        return view('airport_manager.pending_request.index',compact('requestArray', 'user_detail'));
    }

    public function user_status_update(Request $request)
    {
        // p($request->all());
        if($request->req_status == 0){
            $status = TRUE;
        }else if($request->req_status == 1){
            $status = FALSE;
        }
        $status_update = User::where('id',$request->req_userId)->first();
        $status_update->status = $status;
        $status_update->save();
        return redirect()->route('airport_manager.pending_request.index')->with('message','User status updated Successfully');
    }

}
