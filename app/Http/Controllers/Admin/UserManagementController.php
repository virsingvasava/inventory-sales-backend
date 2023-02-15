<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\City;
use App\Models\Attendance;

use App\Http\Requests\StoreInventoryRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

use App\Imports\UsersImport;
use App\Exports\UsersExport;
use App\Exports\ExportUsersListingData;
use App\Models\OrderItem;
use Attribute;
use DateTime;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\UploadFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class UserManagementController extends Controller
{
    public function index(Request $request) 
    {
        $total_users_check = User::whereNotIn('role',[TRUE ,FALSE])->get();
        $total_users = count($total_users_check);

        $active_user_check = User::whereNotIn('role',[TRUE ,FALSE])
        ->where('login_logout_status', TRUE)
        ->get();
        
        $active_user = count($active_user_check);

        $pending_requests = 0;
        $not_logged_in_since_last_week = 0;

        $user_obj = User::with('city_name')->where('login_logout_status', TRUE)->whereNotIn('role', [TRUE ,FALSE])->get();

        return view('admin.user_management.index',compact('user_obj', 'total_users', 'active_user', 'pending_requests', 'not_logged_in_since_last_week'));
    }

    public function create()
    {
        $user = User::get()->count();
        $userId = $user+true;
        $genrateId = 'User_'.$userId;
        $cityArray = City::where('status', TRUE)->get();

        return view('admin.user_management.create',compact('genrateId', 'cityArray'));
    }

    public function store(Request $request)
    { 
        $validatedRequestData = $request->validate([
            'profile_picture' => 'required',
            'user_name' => 'required',
            'mobile' => 'required|unique:users',
            'city_id' => 'required',
            'role_id' => 'required',
            'email' => 'required|email|unique:users',
            'date_of_joining' => 'required',
            // 'password' => 'required|confirmed|min:6',
            'status' => 'required',

        ], [
            'profile_picture.required' => 'Please choose profile picture',
            'user_name.required' => 'Please enter the name',
            'mobile.required' => 'Please enter phone number',
            'city_id.required' => 'Please select your city',
            'role_id.required' => 'Please select your role',
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

        return redirect()->route('admin.user_management.index')->with('message','User added Successfully');
    }

    public function view($id)
    {   
        // dd($id);
        $view = User::where('id',$id)->first();
        $view_details = User::with('city_name')->where('id',$id)->get();
        // dd($view_details);

        $total_sale_obj = '';

        $sales_history1 = Order::where(['sale_by_user_id' => $id])
        ->with(['order_item_details', 'attendance_details'])->get();

        $sales_history = Attendance::where('user_id', $id)
        ->get();
       // dd($sales_history);
    

        $total_sale = OrderItem::where('user_id', $id)->get()->sum('total_amount');
        $average_monthly_sale = $total_sale/12;
        $total_login_session = Attendance::where('user_id', $id)->count('login_at');
        $pack_sold = OrderItem::where('user_id', $id)->sum('qty');
        
        
        $dateFrom = Carbon::now()->subDays(30);
        // dd($dateFrom);
        $dateTo = Carbon::now();


        $monthly = Order::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount');

        $previousDateFrom = Carbon::now()->subDays(60);
        $previousDateTo = Carbon::now()->subDays(31);
        $previousMonthly = Order::whereBetween('created_at', [$dateFrom,$dateTo])->sum('total_amount');

        $previousMonthly = $previousMonthly == 0 ? 1 : $previousMonthly;

        if($previousMonthly < $monthly){
            if($previousMonthly >0){
                $percent_from = $monthly - $previousMonthly;
                $percent = $percent_from / $previousMonthly * 100; //increase percent
            }else{
                $percent = 100; //increase percent
            }
        }else{
            $percent_from = $previousMonthly -$monthly;
            $percent = $percent_from / $previousMonthly * 100; //decrease percent
        }
        return view('admin.user_management.view',compact('view', 'view_details', 'total_sale', 'sales_history', 'average_monthly_sale', 'total_login_session', 'pack_sold', 'percent_from', 'percent'));
    }

    public function edit($id)
    {
        $edit = User::where('id',$id)->first();

        $cityArray = City::where('status', TRUE)->get();

        return view('admin.user_management.edit',compact('edit', 'cityArray'));
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

        return redirect()->route('admin.user_management.index')->with('message','User update Successfully');
    }

    public function destroy(Request $request)
    {   
        $id = $request->userId;
        User::where('id',$id)->delete();
        return redirect()->route('admin.user_management.index')->with('message','User deleted Successfully');

    }

    public function user_management_total()
    {
        $user_obj = User::with('city_name')->where('status', TRUE)->whereNotIn('role', [TRUE ,FALSE])->get();
        return view('admin.user_management.user_total',compact('user_obj'));
    }

    public function user_status_update(Request $request)
    {
        $status_update = User::where('id',$request->brand_id)->first();
        $status_update->status = $request->status;
        $status_update->save();
        return redirect()->route('admin.user_management.index')->with('message','User status updated Successfully');
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
       return view('admin.user_management.index',compact('user_obj', 'total_users', 'active_user', 'pending_requests', 'not_logged_in_since_last_week'));
    }

    public function usersImport(Request $request)
    {   
       Excel::import(new UsersImport, $request->file('users_import')->store('temp'));
       return redirect()->route('admin.user_management.index')->with('message','Users Import Successfully');

    }

    public function usersExport(Request $request) 
    {
        return Excel::download(new UsersExport(), 'sample_import_users.xls');
    }


    public function export_user_listing_data(Request $request) 
    {
        $file_name = 'export_users'.date('Y_m_d_H_i_s').'.csv'; 
        return Excel::download(new ExportUsersListingData, $file_name);
    }
    
}
