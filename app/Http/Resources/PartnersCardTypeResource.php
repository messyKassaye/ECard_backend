<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Card;
use Auth;
use App\TotalCardNumber;
class PartnersCardTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $cards = TotalCardNumber::where('card_type_id',$this->id)
        ->where('user_id',Auth::user()->id)->get();
        return [
            'id'=>$this->id,
            'value'=>$this->value,
            'name'=>$this->name,
            'total_amount'=>$cards[0]->amount
        ];
    }
}
