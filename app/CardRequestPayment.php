<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CardRequest;
use App\Bank;
class CardRequestPayment extends Model
{
    //

    public function cardRequest(){
        return $this->belongsTo(CardRequest::class);
    }

    public function bank(){
        return $this->belongsTo(Bank::class);
    }
}
