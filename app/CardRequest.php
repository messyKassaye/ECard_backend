<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CardType;
use App\User;
use App\CardRequestPayment;
use App\Receipt;
class CardRequest extends Model
{
    //

    public function cardType(){
        return $this->belongsTo(CardType::class);
    }

    public function user(){
        return $this->belongsTo(User::class,'requester_id');
    }

    public function payment(){
        return $this->hasOne(CardRequestPayment::class);
    }

    public function approval(){
        return $this->hasMany(CardRequestApproval::class,'card_request_id');
    }

    public function receipt(){
        return $this->hasMany(Receipt::class);
    }

    public function paymentType(){
        return $this->belongsTo(PaymentType::class);
    }
}
