<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    // use AuthenticatesUsers;

    protected $redirectTo = 'admin/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function submit(Request $request)
    {

        $email = $request->email;
        $password = $request->password;
        
        $user = User::where('email',$email)->first();
       

        if(!empty($user))
        {    
            $check_password = Hash::check($password, $user->password);
            
            if($check_password)
            {
                
                if($user->role == ADMIN_ROLE)
                {
                    Auth::attempt(array('email' => $email, 'password' => $password));
                    return redirect()->route('admin.dashboard')->with('message','Your are login successfully');


                }elseif($user->role == AIRPORT_MANAGER){

                    Auth::attempt(array('email' => $email, 'password' => $password));
                    return redirect()->route('airport_manager.dashboard.index')->with('message','Your are login successfully');

                }elseif($user->role == SALESMAN){

                    Auth::attempt(array('email' => $email, 'password' => $password));
                    return redirect()->route('salesman.dashboard.index')->with('message','Your are login successfully');

                }else 
                {
                    return redirect()->route('login')->with('error','Please enter valid credentials');

                }
            } 
            else 
            {
                return redirect()->route('login')->with('error','Please enter valid credentials');

            }
        }else 
        {
            return redirect()->route('login')->with('error','Entered details not found');

        }
    }
}
