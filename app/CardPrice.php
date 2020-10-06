<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CardType;
class CardPrice extends Model
{
    //

    public function cardType(){
        return $this->belongsTo(CardType::class);
    }
}
