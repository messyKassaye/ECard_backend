<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\RegionCity;
use App\User;
use App\Company;
class AddressResource extends JsonResource
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
            'region_name'=>RegionCity::find($this->region_id)->name,
            'city_name'=>RegionCity::find($this->city_id)->name,
            'user'=>User::where('id',$this->user->id)
            ->with('role')->with('verification')
            ->with('company')->with('connection')->get()
            
        ];
    }
}
