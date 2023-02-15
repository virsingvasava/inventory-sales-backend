<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {        
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();
        return view('admin.settings.edit_profile',compact('user_detail'));
    }

    public function profile_update(Request $request)
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();
        $user_detail->first_name = $request->first_name;
        $user_detail->last_name = $request->last_name;
        $user_detail->name = $request->first_name.' '.$request->last_name;
        $user_detail->phone_number = $request->phone_number;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/users');
            $image->move($destinationPath, $name);
            $user_detail->profile_picture_name = $name;
        }
        $user_detail->save();

        return redirect()->route('admin.dashboard')->with('success','Profile Updated Successfully.');
    }

    public function change_password()
    {
        $user = Auth::User();
        $user_detail = User::where('id',$user->id)->first();

        return view('admin.profile.change_password',compact('user_detail'));
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

            return redirect()->route('admin.dashboard')->with('success','Password changed Successfully.');
        }
    }

}
