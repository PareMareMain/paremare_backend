<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config;
use App\Models\User;
class Notification extends Model
{
    use HasFactory;
    private $api_key = 'AAAAWWzseWc:APA91bGS5lqMoAQujsX5J7v_dr5PKx26XwimtXAiNJukFQZQNwFIdHWDrCC2Lo7e9L5sHobliSbjY-6h-BkGvpi_2yzivPJLeXiN3oY2ntQJx7gBW39c2KDPvqLvL4zPKUVY31FEJNX3';
  // private $api_key = 'AAAAJRvLv2c:APA91bHVzJOZxb6W9SrIbaZ3TN3LGeat8h05OsP5Ih3b0_mIAKB06L7UdV1eChh0rnj9mOR9FlpEXyJGCzScLMn_M4I73N7ls7InLhCYMJNNM-aGyIe65v6UNy_tnu9REjfo3iBlhUid';
    public function push_notification($user_ids,$data){
      // dd($user_ids);
   		$others = [];
        $ios_types = [];
   		foreach ($user_ids as $key => $user_id) {
   			$user_data = User::find($user_id);
        // dd($user_data);
   			if($user_data && $user_data->device_token){
                if($user_data->device_type=='2'){ // 2= IOS
                    $ios_types[] =  $user_data->device_token;
                }else{
                        $others[] = $user_data->device_token;
                }
   			}
   		}
        $priority = "normal";
        $timeToLive = null;
        $pushTypes = [];
        if(in_array($data['pushType'],$pushTypes)){
            $priority = "high";
        }
        if($data['pushType']=="CALL" || $data['pushType']=="CALL_RINGING" || $data['pushType']=="CALL_ACCEPTED" || $data['pushType']=="CALL_CANCELED"){
            $timeToLive = 20;
        }
      // dd($others,$ios_types);
        $notification = [];
        if(count($others)>0){
            $fields = array (
                'registration_ids' =>$others,
                'data' =>$data,
                'notification'=>null,
                "priority"=>$priority
            );
            if($timeToLive){
                $fields["time_to_live"] = $timeToLive;
            }
            // dd($fields);
            \Log::channel('custom')->info('Android Notification', ['device_ids'=>$others,'fields' => $fields]);
            $this->sendNotification($fields);
        }
        if(count($ios_types)>0){
            if(isset($data['pushType'])){
                $notification = [
                    "title" => $data["pushType"],
                    "body"=> $data["message"],
                    "sound"=> "default",
                    "badge"=>0
                ];
            }
            $fields = array (
                'registration_ids' =>$ios_types,
                'data' =>$data,
                'notification'=>$notification,
                "priority"=>$priority,
            );
            if($timeToLive){
                $fields["time_to_live"] = $timeToLive;
            }


            // \Log::channel('custom')->info('IOS Notification', ['device_ids'=>$ios_types,'fields' => $fields]);
            $this->sendNotification($fields);
        }
        return;


    }
    private function sendNotification($fields){
        $url = 'https://fcm.googleapis.com/fcm/send';
        //header includes Content type and api key
        /*api_key available in:
        Firebase Console -> Project Settings -> CLOUD MESSAGING -> Server key*/
        // $api_key = env('SERVER_KEY_ANDRIOD');
        $headers = array(
            'Content-Type:application/json',
            'Authorization:key='.$this->api_key
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        // dd($result);
        curl_close($ch);
        \Log::info('notification sent'.$result);
        // \Log::channel('custom')->info('sendNotification==========', ['result' => $result]);

        return $result;
    }
    public function push_test_notification($fcm_id,$data,$request){
        $others = [];
        $ios_types = [];
        if($request->device_type=='IOS'){
            $ios_types[] =  $fcm_id;
        }else{
            $others[] = $fcm_id;
        }
        $priority = "normal";
        $timeToLive = null;
        $notification = [];
        if(count($others)>0){
            $fields = array (
                'registration_ids' =>$others,
                'data' =>$data,
                'notification'=>null,
                "priority"=>$priority
            );
            if($timeToLive){
                $fields["time_to_live"] = $timeToLive;
            }
            return $this->sendTestNotification($fields,$request->fcm_server_key);

        }
        if(count($ios_types)>0){
            if(isset($data['pushType'])){
                $notification = [
                    "title" => $data["pushType"],
                    "body"=> $data["message"],
                    "sound"=> "default",
                    "badge"=>0
                ];
            }
            $fields = array (
                'registration_ids' =>$ios_types,
                'data' =>$data,
                'notification'=>$notification,
                "priority"=>$priority,
            );
            if($timeToLive){
                $fields["time_to_live"] = $timeToLive;
            }
            return $this->sendTestNotification($fields,$request->fcm_server_key);
        }

    }

   public function sendTestNotification($fields,$api_key){
   		$url = 'https://fcm.googleapis.com/fcm/send';
      $headers = array(
          'Content-Type:application/json',
          'Authorization:key='.$api_key
      );
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
      $result = curl_exec($ch);
      curl_close($ch);
      return $result;
   }


    public static function markAsRead($receiver_id){
    	self::where(['read_status'=>'unread','receiver_id'=>$receiver_id])->update(['read_status' =>'read']);
    	return true;
    }
}
