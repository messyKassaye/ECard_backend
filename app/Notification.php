<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Entity;
class Notification extends Model
{
    //

    public function entity(){
        return $this->belongsTo(Entity::class);
    }
}
