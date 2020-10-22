<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyUserVerification extends Model
{
    //

    public function verifier()
    {
        return $this->belongsTo(User::class,'verified_by');
    }
}
