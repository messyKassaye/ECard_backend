<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $fillable = ['owner_id','card_type_id','card_number'];
}
