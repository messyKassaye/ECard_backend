<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\CardType;
use App\Http\Resources\CardRequestPaymentResource;
class MyCardRequestResource extends JsonResource
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
            'user'=>User::where('id',$this->requested_to)->with('cardPrice')->get(),
            'card_type'=>CardType::find($this->card_type_id),
            'status'=>$this->status,
            'amount'=>$this->amount,
            'payment'=>new CardRequestPaymentResource($this->payment)
        ];
    }
}
