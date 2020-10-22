<?php

namespace App\Api\V1\Services;
use App\Entity;
use App\Notification;
class NotificationService{

    public function notify($entity_id,$sender_id,$receiver_id,$message,$path,$path_id){
        $notification = new Notification();
        $notification->entity_id = $entity_id;
        $notification->sender_id = $sender_id;
        $notification->receiver_id = $receiver_id;
        $notification->message = $message;
        $notification->path =$path;
        $notification->path_id = $path_id;
        $notification->save();
    }

}