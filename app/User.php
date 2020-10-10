<?php

namespace App;

use Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Role;
use App\Company;
use App\Card;
use App\CardPrice;
use App\AgentPartnerRetailer;
use App\Address;
use Auth;
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','phone', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function role(){
        return $this->belongsToMany(Role::class);
    }

    public function company(){
        return $this->hasOne(Company::class);
    }

    public function cardPrice(){
        return $this->hasMany(CardPrice::class);
    }

    public function cards(){
        return $this->hasMany(Card::class);
    }

    public function agents(){
        return $this->hasMany(AgentPartnerRetailer::class,'company_user_id');
    }

    public function address(){
        return $this->hasOne(Address::class,'user_id');
    }

    public function verification(){
        return $this->hasOne(CompanyUserVerification::class,'user_id');
    }

    public function connection()
    {
        return $this->hasOne(AgentPartnerRetailer::class,'company_user_id')
        ->where('agent_partner_retailer_id',Auth::user()->id);
    }

    /**
     * Automatically creates hash for the user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function setFirstNameAttribute($value){
        $this->attributes['first_name'] = ucfirst($value);
   }

   public function setLastNameAttribute($value){
        $this->attributes['last_name'] = ucfirst($value);
   }

   
   
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
