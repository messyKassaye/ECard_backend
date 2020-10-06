<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CardPrice;
class CardType extends Model
{
    //

    public function prices(){
        return $this->hasMany(CardPrice::class);
    }
}
