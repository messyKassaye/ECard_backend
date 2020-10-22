<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use Auth;
class MyAgentsResource extends JsonResource
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
            'status'=>$this->status,
            'user'=>Auth::user()->role[0]->id==2
            ?User::where('id',$this->agent_id)->with('role')
            ->with('verification')->with('cardPrice')->with('bankAccount')->get()
            :User::where('id',$this->partner_id)->with('role')
            ->with('verification')->with('cardPrice')->with('bankAccount')->get()
        ];
    }
}
