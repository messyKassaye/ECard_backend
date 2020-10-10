<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\User;
class Address extends Model
{
    //

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
