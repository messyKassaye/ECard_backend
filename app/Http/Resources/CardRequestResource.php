<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\CardPrice;
use Auth;
use App\Http\Resources\CardRequestPaymentResource;
class CardRequestResource extends JsonResource
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
            'card_type'=>$this->cardType,
            'amount'=>$this->amount,
            'user'=>User::where('id',$this->requester_id)->with('role')->get(),
            'price'=>CardPrice::where('company_user_id',Auth::user()->role[0]->id==2?Auth::user()->company->id:Auth::user()->id)->get(),
            'payment'=>new CardRequestPaymentResource($this->payment)
        ];
    }
}
