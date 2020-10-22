<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
class RoleResource extends JsonResource
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
            'role'=>$this->name,
            'user'=>DB::table('users')->join('role_user',function($join){
                $join->on('users.id','role_user.role_id');
            })->join('addresses',function($join){
                $join->on('users.id','addresses.user_id');
            })->join('region_cities',function($join){
                $join->on('region_cities.id','addresses.region_id');
            })->where('role_user.role_id',$this->id)
            ->select(['users.id','users.first_name','users.last_name','users.email','users.phone','region_cities.name as region_name'])
            ->get()
        ];
    }

    public function cityName(){
        return 'city';
    }
}
