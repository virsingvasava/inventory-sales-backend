<?php

namespace App\Http\Controllers\AirportManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;

use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();
        $cityArray = City::where('status', TRUE)->get();
        return view('airport_manager.profile.edit_profile',compact('user_detail', 'cityArray'));
    }

    public function profile()
    {       
        $user = Auth::User();
        $roleCheck = $user->role;

        if($roleCheck == AIRPORT_MANAGER){
            $roleId = AIRPORT_MANAGER;
            $role = AIRPORT_MANAGER;

        }elseif($roleCheck == BRANCH_MANAGER){
            $roleId = BRANCH_MANAGER;
            $role = BRANCH_MANAGER;

        }elseif($roleCheck == BRANCH_MANAGER){
            $roleId = BRANCH_MANAGER;
            $role = BRANCH_MANAGER;

        }elseif($roleCheck == HO){
            $roleId = HO;
            $role = HO;

        }elseif($roleCheck == SALESMAN){
            $roleId = SALESMAN;
            $role = SALESMAN;
            
        }else{
            $roleId = ADMIN_ROLE;
            $role = "Admin";
        }

        $user_detail = User::where('id',$user->id)->first();
        $cityArray = City::where('status', TRUE)->get();        
        return view('airport_manager.profile.edit_profile',compact('cityArray', 'user_detail', 'role', 'roleId'));
    }

    public function profile_update(Request $request)
    {        
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();
        $user_detail->name = $request->name;
        $user_detail->user_id = $request->admin_id;
        $user_detail->mobile = $request->mobile;
        $user_detail->email = $request->email;
        $user_detail->role_id = $request->role_id;
        $user_detail->city_id = $request->city_id;
        $user_detail->date_of_joining = $request->date_of_joining;
        $user_detail->role = $request->role_id;

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

            $profile_pictureName = $user->profile_img;
        } 
        $user_detail->profile_img = $profile_pictureName;
        $user_detail->save();
        return redirect()->route('airport_manager.dashboard.index')->with('message','Profile Updated Successfully.');
    }

    public function change_password()
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        return view('airport_manager.profile.change_password',compact('user_detail'));
    }

    public function change_password_submit(Request $request)
    {
        $user = Auth::User();
        $password = $request->current_password;

        $check_password = Hash::check($password, $user->password);

        if(!$check_password){
            return redirect()->back()->with('danger','Current Password does not match!');
        } else {
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('airport_manager.dashboard.index')->with('success','Password changed Successfully.');
        }
    }
}
