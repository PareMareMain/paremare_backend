<?php

namespace App\Http\Traits;

use Illuminate\Validation\ValidationException;
use App\Models\User;

Trait NotificationTraits
{
    protected $result = null;


    function sendNotification($uid)
    {
        $user =  User::find($uid);
        $data = [
            "registration_ids" => array($user->device_token),
            "notification" => [
                // "title" => $request->title,
                // "body" => $request->body,
                "title" => "Test",
                "body" => "Subscription success",
            ],
            "data" => [
                "user" => $user,
                "type" => 1,
            ],
        ];

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.config('fcm.token')
        );

        $dataString = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
        $response = curl_exec($ch);
        curl_close($ch);
        \Log::info('notification sent'.$response);
        return $response;

    }

}
