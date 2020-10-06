<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\AgentPartnersResource;
class UserResource extends JsonResource
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
            'type' => ['User data'],
            'attribute' => [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone,
                'avator'=>$this->avator
            ],
            'relations' => [
                'role' => $this->role,
                'company'=>new CompanyResource($this->company),
            ]

        ];
    }
}
