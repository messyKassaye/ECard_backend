<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\User;
use App\PaymentType;
use App\CardType;
class SellAndBuyResource extends JsonResource
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
            'requester'=>User::where('id',$this->requester_id)->select(['id','first_name'])->get(),
            'card_type'=>CardType::find($this->card_type_id),
            'sold_date'=>$this->created_at->diffForHumans(),
            'amount'=>$this->amount,
            'payment_type'=>PaymentType::where('id',$this->payment_type_id)->select(['id','name'])->get(),
            'payment'=>new PaymentResource($this->payment),
            'approval'=>User::where('id',$this->approval[0]->user_id)->select(['id','first_name'])->get()
        ];
    }
}
