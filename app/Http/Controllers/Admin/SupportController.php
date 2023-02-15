<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\SupportDetail;

class SupportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $support_contact_data = SupportDetail::where('type','support_contact')->first();

        $support_contact = '';
        $support_mail = '';
        $support_radius = '';
        if(!empty($support_contact_data))
        {
            $support_contact = $support_contact_data->name;            
        }

        $support_mail_data = SupportDetail::where('type','support_mail')->first();
        if(!empty($support_mail_data))
        {
            $support_mail = $support_mail_data->name;            
        }

        $support_radius_data = SupportDetail::where('type','support_radius')->first();
        if(!empty($support_radius_data))
        {
            $support_radius = $support_radius_data->name;            
        }
        return view('admin.support.settings',compact('support_mail','support_contact','support_radius'));
    }

    public function support_update(Request $request)
    {
        $support_contact = SupportDetail::where('type','support_contact')->first();
        if(empty($support_contact))
        {
            $support_contact = new SupportDetail;
            $support_contact->type = "support_contact";
            $support_contact->name = $request->support_contact;
            $support_contact->save();
        } 
        else 
        {
            $support_contact->type = "support_contact";
            $support_contact->name = $request->support_contact;
            $support_contact->save();
        }

        $support_mail = SupportDetail::where('type','support_mail')->first();
        if(empty($support_mail))
        {
            $support_mail = new SupportDetail;
            $support_mail->name = $request->support_mail;
            $support_mail->type = "support_mail";
            $support_mail->save();
        } 
        else 
        {
            $support_mail->type = "support_mail";
            $support_mail->name = $request->support_mail;
            $support_mail->save();
        }

        $support_radius = SupportDetail::where('type','support_radius')->first();
        if(empty($support_radius))
        {
            $support_radius = new SupportDetail;
            $support_radius->name = $request->support_radius;
            $support_radius->type = "support_radius";
            $support_radius->save();
        } 
        else 
        {
            $support_radius->type = "support_radius";
            $support_radius->name = $request->support_radius;
            $support_radius->save();
        }
        return redirect()->route('admin.dashboard')->with('success','Settings updated successfully.');
    }
}
