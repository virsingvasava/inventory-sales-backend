<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PasswordReset;
use Auth;
use Mail;

class ForgotpasswordController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('auth.forgot_password');
    }

    public function submit(Request $request)
    {
        
        $email = $request->email;
        $user = User::where('email',$email)->first();

        if(!empty($user))
        {
            if($user->role == [1,4,5])
            {
                PasswordReset::where('email',$email)->delete();

                $token = generateRandomToken(40);
                $reset = new PasswordReset;
                $reset->email = $email;
                $reset->token = $token;
                $reset->save();

                $from_address = env('MAIL_FROM_ADDRESS');
                $from_name = env('MAIL_FROM_NAME'); 

                $url = route('auth.reset_password',$token);
                $data = array('name'=> $user->name, 'url' => $url);

                try {
                    
                    Mail::send('mails.reset_link', $data, function($message) use($user,$from_address,$from_name) {
                        $message->to($user->email, $user->name);
                        $message->subject('Password reset request');
                        $message->from($from_address,$from_name);
                    });
                } 
                catch (Exception $e) 
                {
                    Log::Info('mail_failed_reset_link',['error' => $e]);
                }
                // return redirect()->back()->with('success','Check your mailbox for reset password link');
                return redirect()->route('forgot_password')->with('message','Check your mailbox for reset password link');

            } 
            else 
            {
                // return redirect()->back()->with('danger','Please enter valid credentials');
                return redirect()->route('forgot_password')->with('message','Please enter valid credentials');

            }
        } 
        else 
        {
            // return redirect()->back()->with('danger','Entered datails not found');
            return redirect()->route('forgot_password')->with('message','Entered datails not found');

        }
    }

    public function reset_password($token)
    {
        $check_token = PasswordReset::where('token',$token)->first();
        if(!empty($check_token))
        {
            $user = User::where('email',$check_token->email)->first();
            if(!empty($user))
            {
                return view('auth.reset_password',compact('user'));
            } 
            else 
            {
                return redirect()->route('login')->with('danger','User not found');
            }
        } 
        else 
        {
            return redirect()->route('login')->with('danger','Reset password token expired!');
        }
    }

    public function password_submit(Request $request)
    {
        $user = User::where('_id',$request->user_id)->first();
        if(!empty($user))
        {
            $user->password = Hash::make($request->password);
            $user->save();
            PasswordReset::where('email',$user->email)->delete();
            return redirect()->route('login')->with('success','Password updated successfully!');
        } 
        else 
        {
            return redirect()->route('login')->with('danger','User not found');
        }
    }
}
