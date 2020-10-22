<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\BankAccount;
use Auth;
class BankResource extends JsonResource
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
            'name'=>$this->name,
            'total_user'=>count($this->accounts),
            'me'=>BankAccount::where('user_id',Auth::user()->id)->where('bank_id',$this->id)->get()
            
        ];
    }
}
