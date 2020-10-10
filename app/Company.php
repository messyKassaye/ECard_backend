<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Address;
use App\CompanyUserVerification;
class Company extends Model
{
    //

    public function address(){
        return $this->hasOne(Address::class,'company_id');
    }

    public function verified(){
        return $this->hasOne(CompanyUserVerification::class,'company_id');
    }

    public function agents(){
       return $this->hasMany(AgentPartnerRetailer::class,'company_user_id');
    }
}
