<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CardRequestPaymentResource extends JsonResource
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
            'card_request_id'=>$this->card_request_id,
            'bank'=>$this->bank,
            'transaction_ref_number'=>$this->transaction_ref_number
        ];
    }
}
