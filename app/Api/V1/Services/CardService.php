<?php
namespace App\Api\V1\Services;
use App\Card;
use Auth;
use App\Cardrequest;
use App\CardRequestApproval;
use App\Receipt;
use App\CardType;
use App\CardPrice;
use App\Finance;
use App\TotalCardNumber;
class CardService
{
   
    public function checkPartnersCardAmount($cardTypeId,$ownerID,$amount)
    {
        $cards = TotalCardNumber::where('card_type_id',$cardTypeId)
        ->where('user_id',$ownerID)->get();
        if($cards[0]->amount>=$amount){
            return 1;
        }else{
          return 0;
        }
    }

    public function partnersCardTransaction($cardRequest,$ownerID)
    {
        $cards = Card::where('card_type_id',$cardRequest->card_type_id)
        ->where('owner_id',$ownerID)
        ->where('status','not_sold')->take($cardRequest->amount)->get();
        foreach($cards as $card){
            $currentCard = Card::find($card->id);
            $currentCard->owner_id = $cardRequest->requester_id;
            $currentCard->save();
        }
        
        //update card request
        $cardRequests = CardRequest::find($cardRequest->id);
        $cardRequests->status = 'approved';
        $cardRequests->save();

        //approving card request
        $cardRequestApproval = new CardRequestApproval();
        $cardRequestApproval->user_id = $ownerID;
        $cardRequests->approval()->save($cardRequestApproval);

        $unitPrice = $this->calculator($cardRequest->card_type_id,$ownerID);
        $totalPrice = round($this->calculator($cardRequest->card_type_id,$ownerID)*$cardRequest->amount,2);
        $receipet = new Receipt();
        $receipet->service_type = 'Mobile card sells';
        $receipet->card_request_id = $cardRequest->id;
        $receipet->unit_price =$unitPrice;
        $receipet->quantity = $cardRequest->amount;
        $receipet->total_price =$totalPrice;
        $receipet->company_user_id = $ownerID;
        $receipet->proccessed_by = $ownerID;
        $cardRequests->receipt()->save($receipet);

        //update finance
        $finance = Finance::where('company_user_id',$ownerID)->get();
        if(count($finance)<=0){
            $this->saveFinace($ownerID,$totalPrice);
        }else{
            $this->updateFinance($ownerID,$totalPrice);
        }
        return response()->json(['status'=>true,
        'card_request'=>$cardRequests,
        'receipt'=>$receipet]);
        //update card sell

    }

    public function calculator($cardTypeId,$ownerID)
    {
       $cardPrice = CardPrice::where('user_id',$ownerID)->get();
       return CardType::find($cardTypeId)->value*$cardPrice[0]->percentage_value;//*CardPrice::where('company_user_id',Auth::user()->id)->get()[0]['percentage'];

        
    }

    public function saveFinace($userId,$balance)
    {
        
        $finance = new Finance();
        $finance->company_user_id = $userId;
        $finance->total_balance = round($balance,2);
        $finance->save();

    }
    public function updateFinance($userId,$amount)
    {
        $finances = Finance::where('company_user_id',$userId)->get();

        $finance = Finance::find($finances[0]['id']);
        $finance->total_balance +=round($amount,2);
        $finance->save();
    }
    

    public function currentGoal($userId){
        $cards =Card::where('owner_id',$userId)->get();
        
        if(count($cards)>0){

            $currentGoalTotalBalance=0;
        foreach($cards as $card){
            $currentGoalTotalBalance += $this->calculator($card->card_type_id,$userId);
        }

        $finances = Finance::where('company_user_id',$userId)->get();
        if(count($finances)>0){
           
            $finance = Finance::find($finances[0]['id']);
            $finance->total_goal = round($currentGoalTotalBalance,2);
            $finance->save();

        }else{
            $finance = new Finance();
            $finance->company_user_id = $userId;
            $finance->total_goal = $currentGoalTotalBalance;
            $finance->total_balance=0.0;
            $finance->total_goal = round($currentGoalTotalBalance,2);
            $finance->save();
        }

        }
        
    }
}
