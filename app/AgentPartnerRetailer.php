<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentPartnerRetailer extends Model
{
    //

    public function user(){
        return $this->belongsTo(User::class,'agent_partner_retailer_id');
    }
}
