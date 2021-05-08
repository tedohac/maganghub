<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function show($id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();
        if(empty($notification)) return abort(404);

        if ($notification) {
            $notification->markAsRead();
            return redirect($notification->data['url']);
        }
    }
    
    //
    public function list()
    {
        $notifications = auth()->user()->notifications()->get();

    	return view('auth.notification_list', [
            'notifications' => $notifications,
        ]);
    }
}
