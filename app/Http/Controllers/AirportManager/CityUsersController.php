<?php

namespace App\Http\Controllers\AirportManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Order;
use App\Models\City;

use App\Http\Requests\StoreInventoryRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Imports\UsersImport;
use App\Exports\UsersExport;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Auth;
use App\Models\Kiosk;

class CityUsersController extends Controller
{
    public function index(Request $request) 
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $total_users_check = User::whereNotIn('role',[TRUE ,FALSE, AIRPORT_MANAGER])
        ->where('city_id', $user->city_id)
        ->get();

        $total_users = count($total_users_check);

        $active_user_check = User::whereNotIn('role',[TRUE ,FALSE, AIRPORT_MANAGER])
        ->where('city_id', $user->city_id)
        ->where('status', TRUE)
        ->get();

        $active_user = count($active_user_check);

        $pending_requests = 0;
        $not_logged_in_since_last_week = 0;


        $user_obj = User::with('city_name')
        ->where('city_id', $user->city_id)
        ->whereNotIn('role', [TRUE ,FALSE, AIRPORT_MANAGER])->get();

        return view('airport_manager.city_users.index',compact('user_obj', 'total_users', 'active_user', 'pending_requests', 'not_logged_in_since_last_week'));
    }

    public function create()
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        $user = User::get()->count();
        $userId = $user+true;
        $genrateId = 'User_'.$userId;

        $cityArray = City::where(['status' => TRUE])->get();
        return view('airport_manager.city_users.create',compact('genrateId', 'cityArray', 'user_detail'));
    }

    public function store(Request $request)
    { 
        $validatedRequestData = $request->validate([
            'profile_picture' => 'required',
            'user_name' => 'required',
            'mobile' => 'required|unique:users',
            'city_id' => 'required',
            'email' => 'required|email|unique:users',
            'date_of_joining' => 'required',
            // 'password' => 'required|confirmed|min:6',
            'status' => 'required',

        ], [
            'profile_picture.required' => 'Please choose profile picture',
            'user_name.required' => 'Please enter the name',
            'mobile.required' => 'Please enter phone number',
            'city_id.required' => 'Please select your city',
            'email.required' => 'Please enter email address',
            'date_of_joining.required' => 'Please select your Date of joining',
            // 'password.required' => 'Please enter password',
            'status.required' => 'Please select your city',
        ]);
        
        $store = new User;
        if ($request->profile_picture) {
            $profile_picture = $request->profile_picture;
            $destination = public_path("assets/profile_picture");
            if(!is_dir($destination)){
                mkdir($destination, 0777, true);
            }
            $name = 'profile_picture_' . time();
            $profile_pictureName = $name . '.' . $profile_picture->getClientOriginalExtension();
            $profile_picture->move($destination, $profile_pictureName);
        } 
        $store->profile_img = $profile_pictureName;
        $store->name = $request->user_name;
        $store->user_id = $request->user_id;
        $store->mobile = $request->mobile;
        $store->email = $request->email;
        $store->password = Hash::make($request->password);
        $store->role_id = $request->role_id;
        $store->role = $request->role_id;
        $store->date_of_joining = $request->date_of_joining;
        $store->city_id = $request->city_id;
        $store->status = $request->status;
        $store->save();
        return redirect()->route('airport_manager.city_users.index')->with('message','User added Successfully');
    }

    public function view($id)
    {
        
        $view = User::where('id',$id)->first();
        $total_sale_obj = '';
        $sales_history = Order::where(['sale_by_user_id' => $id])
        ->with(['order_item_details'])->get();
        $total_sale = Order::where(['sale_by_user_id' => $id])->get()->sum('total_amount');
        $average_monthly_sale = '00';
        $total_login_session = '00';
        $pack_sold = '00';


        $dateFrom = Carbon::now()->subDays(30);
        $dateTo = Carbon::now();
        $monthly = Order::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount');

        $previousDateFrom = Carbon::now()->subDays(60);
        $previousDateTo = Carbon::now()->subDays(31);
        $previousMonthly = Order::whereBetween('created_at', [$dateFrom,$dateTo])->sum('total_amount');

        if($previousMonthly < $monthly){
            if($previousMonthly >0){
                $percent_from = $monthly - $previousMonthly;
                $percent = $percent_from / $previousMonthly * 100; //increase percent
            }else{
                $percent = 100; //increase percent
            }
        }else{

            $percent_from =  200 - 100; ///$previousMonthly -$monthly;

            $percent = $percent_from / 200 * 100; //decrease percent
        }

        return view('airport_manager.city_users.view',compact('view', 'total_sale', 'sales_history', 'average_monthly_sale', 'total_login_session', 'pack_sold', 'percent_from', 'percent'));
    }

    public function edit($id)
    {
        $edit = User::where('id',$id)->first();

        $cityArray = City::where('status', TRUE)->get();
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        return view('airport_manager.city_users.edit',compact('edit', 'cityArray', 'user_detail'));
    }

    public function update(Request $request)
    {
        $update = User::where('id', $request->userId)->first();
        if ($request->profile_picture) {
            $profile_picture = $request->profile_picture;
            $destination = public_path("assets/profile_picture");
            if(!is_dir($destination)){
                mkdir($destination, 0777, true);
            }
            $name = 'profile_picture_' . time();
            $profile_pictureName = $name . '.' . $profile_picture->getClientOriginalExtension();
            $profile_picture->move($destination, $profile_pictureName);
        }else{
            $profile_pictureName = $update->profile_img;
        } 
        $update->profile_img = $profile_pictureName;
        $update->name = $request->user_name;
        $update->user_id = $request->user_id;
        $update->mobile = $request->mobile;
        $update->email = $request->email;
        $update->role_id = $request->role_id;
        $update->role = $request->role_id;
        $update->date_of_joining = $request->date_of_joining;
        $update->city_id = $request->city_id;
        $update->status = $request->status;
        $update->save();

        return redirect()->route('airport_manager.city_users.index')->with('message','User update Successfully');
    }

    public function destroy(Request $request)
    {   
        $id = $request->userId;
        User::where('id',$id)->delete();
        return redirect()->route('airport_manager.city_users.index')->with('message','User deleted Successfully');

    }

    public function user_status_update(Request $request)
    {
        $status_update = User::where('id',$request->brand_id)->first();
        $status_update->status = $request->status;
        $status_update->save();
        return redirect()->route('airport_manager.city_users.index')->with('message','User status updated Successfully');
    }

    public function status_filter(Request $request)
    {
       $total_users_check = User::whereNotIn('role',[1 ,0])->get();
       $total_users = count($total_users_check);

       $active_user_check = User::whereNotIn('role',[1 ,0])
       ->where('status', TRUE)
       ->get();
       $active_user = count($active_user_check);

       $pending_requests = 0;
       $not_logged_in_since_last_week = 0;

       $user_obj = User::where('status', $request->status)->get();
       return view('airport_manager.city_users.index',compact('user_obj', 'total_users', 'active_user', 'pending_requests', 'not_logged_in_since_last_week'));
    }

    public function usersImport(Request $request)
    {   
       Excel::import(new UsersImport, $request->file('users_import')->store('temp'));
       return redirect()->route('airport_manager.city_users.index')->with('message','Users Import Successfully');

    }

    public function usersExport(Request $request) 
    {
        return Excel::download(new UsersExport(), 'sample_import_users.xls');
    }
    
}
