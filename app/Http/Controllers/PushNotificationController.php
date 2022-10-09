<?php

namespace App\Http\Controllers;

use App\Http\Requests\NotificationRequest;
use App\Models\PushNotification;
class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = PushNotification::latest()->paginate(5);
        return view('backend.notifications.index', compact('notifications'));
    }
    public function store(NotificationRequest $req){    
        $requestData = $req->validated();
        if ($req->img) {
    
            $imageName = $req->img->hashName();

            // Public Folder
            $req->img->move(public_path('images/notification/'), $imageName);

            $requestData['img'] = $imageName;

        }//end of if 
        else{
            $requestData['img'] = "notification.png";
        }
        $notification = PushNotification::create($requestData);
        
        $url = 'https://fcm.googleapis.com/fcm/send';
        $dataArr = array('click_action' => 'FLUTTER_NOTIFICATION_CLICK', 'id' => $req->id,'status'=>"done");
        $notification = array('title' =>$req->title, 'text' => $req->body, 'image'=> $req->img, 'sound' => 'default', 'badge' => '1',);
        $arrayToSend = array('to' => "/topics/all", 'notification' => $notification, 'data' => $dataArr, 'priority'=>'high');
        $fields = json_encode ($arrayToSend);
        $headers = array (
            'Authorization: key=' . "BBunpIOzjbEojM3pEIlAwtvspcrrJfSyYbYwEjkXpGdT6bLHfa-PCKP3qEST8JLewy9FkF_1YEPlnzDFfds9sIM",
            'Content-Type: application/json'
        );        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );    
        $result = curl_exec ( $ch );
        //var_dump($result);
        curl_close ( $ch );
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('notification.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.notifications.create');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PushNotification  $pushNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(PushNotification $notification)
    {
        $notification->delete();

        return back();
    }
}
