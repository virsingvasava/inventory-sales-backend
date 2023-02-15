<?php

namespace App\Http\Controllers\Salesman;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\City;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        $user = User::get()->count();
        $userId = $user+true;
        $genrateId = 'User_'.$userId;
        $cityArray = City::where('status', TRUE)->get();

        return view('auth.register', compact('genrateId', 'cityArray'));
    }

    public function submit(Request $request)
    {               
            
        $validatedRequestData = $request->validate([
            'profile_picture' => 'required',
            'user_name' => 'required',
            'mobile' => 'required|unique:users',
            'city_id' => 'required',
            'email' => 'required|email|unique:users',
            // 'password' => 'required|confirmed|min:6'

        ], [
            'profile_picture.required' => 'Please choose profile picture',
            'user_name.required' => 'Please enter the name',
            'mobile.required' => 'Please enter phone number',
            'city_id.required' => 'Please select your city',
            // 'password.required' => 'Please enter password',
            'email.required' => 'Please enter email address',
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
        $store->city_id = $request->city_id;
        $store->date_of_joining = $request->date_of_joining;
        $store->status = TRUE;
        $store->save();
        return redirect()->route('login')->with('message','Register successfully');

    }
       
}
