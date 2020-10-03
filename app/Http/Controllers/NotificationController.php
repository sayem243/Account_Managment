<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead(){
        auth()->user()->unreadNotifications->markAsRead();
       return redirect()->back();
    }
    public function markAsReadById($id){
        $notification = auth()->user()->notifications()->find($id);
        if($notification) {
            $notification->markAsRead();
        }
        return new JsonResponse(array(
            'status'=>200,
            'message'=>"success"
        ));
    }
}
