<?php

namespace App\Api\V1\Services;

use App\User;
use App\CardType;
use App\Card;
use App\TotalCardNumber;
class CardSummerService{


    public function sumCards(){
        $users = User::where('id','!=',1)->get();
        $cardTypes = CardType::all();
        foreach($users as $user){
            foreach($cardTypes as $cardType){
                $cards = Card::where('card_type_id',$cardType->id)
                ->where('owner_id',$user->id)
                ->where('status','not_sold')->get();
                $this->storeCard($user->id,$cardType->id,count($cards));
            }
        }
    }

    public function storeCard($userId,$cardTypeId,$amount){
        $checkUser = TotalCardNumber::where('user_id',$userId)->where('card_type_id',$cardTypeId)->get();
        if(count($checkUser)>0){
            $totalCard = TotalCardNumber::find($checkUser[0]->id);
            $totalCard->amount = $amount;
            $totalCard->save();
        }else{
            $totalCard = new TotalCardNumber();
            $totalCard->user_id = $userId;
            $totalCard->card_type_id=$cardTypeId;
            $totalCard->amount = $amount;
            $totalCard->save();
        }
    }

}