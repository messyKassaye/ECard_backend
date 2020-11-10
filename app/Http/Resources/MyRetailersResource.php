<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Auth;
use App\User;
class MyRetailersResource extends JsonResource
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
            'user'=>Auth::user()->role[0]->id==3
            ?User::where('id',$this->retailer_id)->with('bankAccount')->with('cardPrice')->get()
            :User::where('id',$this->agent_id)->with('bankAccount')->with('cardPrice')->get()
        ];
    }
}
