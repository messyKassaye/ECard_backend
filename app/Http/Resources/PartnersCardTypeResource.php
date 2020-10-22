<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Card;
use Auth;
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
        return [
            'id'=>$this->id,
            'value'=>$this->value,
            'name'=>$this->name,
            'total_amount'=>count(Card::where('card_type_id',$this->id)
            ->where('owner_id',Auth::user()->role[0]->id==2?Auth::user()->id:Auth::user()->id)
            ->where('status','not_sold')->get())
        ];
    }
}
