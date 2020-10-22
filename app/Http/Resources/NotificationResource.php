<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'path'=>$this->path,
            'path_id'=>$this->path_id,
            'entity'=>$this->entity,
            'status'=>$this->status,
            'user'=>User::where('id',$this->sender_id)->with('role')->get(),
            'message'=>$this->message
        ];
    }
}
