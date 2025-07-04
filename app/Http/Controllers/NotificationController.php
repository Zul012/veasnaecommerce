<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Session;
class NotificationController extends Controller
{
    public function index(){
        return view('backend.notification.index');
    }
    public function show(Request $request){
        $notification=Auth()->user()->notifications()->where('id',$request->id)->first();
        if($notification){
            $notification->markAsRead();
            return redirect($notification->data['actionURL']);
        }
    }
    public function delete($id){
        $notification=Notification::find($id);
        if($notification){
            $status=$notification->delete();
            if($status){
                Session::flash('success','Notification deleted successfully');
                return back();
            }
            else{
                Session::flash('error','Error please try again');
                return back();
            }
        }
        else{
            Session::flash('error','Notification not found');
            return back();
        }
    }
}
