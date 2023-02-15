<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerFeedBack;
use App\Models\Notification;

class NotificationsController extends Controller
{
    public function index() 
    {
        $notification = Notification::get();        
        return view('admin.notifications.index',compact('notification'));
    }
}
