<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BankAccount;

class Bank extends Model
{
    //
    
    public function accounts(){
        return $this->hasMany(BankAccount::class);
    }
}
