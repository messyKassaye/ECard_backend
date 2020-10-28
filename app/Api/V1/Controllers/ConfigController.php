<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Role;
use App\User;
use App\Bank;
use App\RegionCity;
use App\CardType;
use App\Entity;
use Illuminate\Support\Facades\DB;
use App\PaymentType;
class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $paymentTypes = explode(',',Config::get('paymentType.payment_types'));
        $paymentTypesDescription = explode(',',Config::get('paymentType.description'));
        for($p=0;$p<count($paymentTypes);$p++){
            $paymentType = new PaymentType();
            $paymentType->name = $paymentTypes[$p];
            $paymentType->description = $paymentTypesDescription[$p];
            $paymentType->save();
        }

        $entitites = explode(',',Config::get('entity.entities'));
        $messages = explode(',',Config::get('entity.messages'));
        for($en=0;$en<count($entitites);$en++){
            $entity = new Entity();
            $entity->name = $entitites[$en];
            $entity->message = $messages[$en];
            $entity->save();
        }

        $banks = explode(',',Config::get('banks.banks'));
        for($b=0;$b<count($banks);$b++){
            $role = new Bank();
            $role->name = $banks[$b];
            $role->save();
        }

        $cardType = explode(',',Config::get('card_types.types'));
        for($i=0;$i<count($cardType);$i++){
            $cards = explode('_',$cardType[$i]);
            $type = new CardType();
            $type->name = $cards[0];
            $type->value = $cards[1];
            $type->save();
        }

        $roles = explode(',',Config::get('roles.role_types'));
        for($r=0;$r<count($roles);$r++){
            $role = new Role();
            $role->name = $roles[$r];
            $role->save();
        }

        $regions = explode(',',Config::get('regions.region'));
        for($i=0;$i<count($regions);$i++){
            $region = new RegionCity();
            $region->parent_id = 0;
            $region->name = $regions[$i];
            $region->save();
        }
        //add subcity and zones
        for($j=0;$j<count($regions);$j++){
            $parents = DB::table('region_cities')->where('name',$regions[$j])->get();
            foreach($parents as $parent){
               $subcitZone = explode(',',Config::get('regions.city.'.$parent->name));
                for($k=0;$k<count($subcitZone);$k++){
                    $subcity = new RegionCity();
                    $subcity->parent_id = $parent->id;
                    $subcity->name = $subcitZone[$k];
                    $subcity->save();
                }
            }
        }

        $user = new User();
        $user->first_name = 'Meseret';
        $user->phone = '0923644545';
        $user->password = env('ADMIN_PASSWORD');
        $user->save();
        $user->role()->sync(Role::find(1));

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
