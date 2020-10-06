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
class CardService
{
   
    public function checkPartnersCardAmount($cardTypeId,$amount)
    {
        $cards = Card::where('card_type_id',$cardTypeId)
        ->where('owner_id',Auth::user()->company->id)
        ->where('status','not_sold')->get();
        if(count($cards)>=$amount){
            return 1;
        }else{
          return 0;
        }
    }

    public function partnersCardTransaction($cardRequest)
    {
        $cards = Card::where('card_type_id',$cardRequest->card_type_id)
        ->where('owner_id',Auth::user()->company->id)
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
        $cardRequestApproval->user_id = Auth::user()->id;
        $cardRequests->approval()->save($cardRequestApproval);

        $unitPrice = $this->calculator($cardRequest->card_type_id);
        $totalPrice = round($this->calculator($cardRequest->card_type_id)*$cardRequest->amount,2);
        $receipet = new Receipt();
        $receipet->service_type = 'Mobile card sells';
        $receipet->card_request_id = $cardRequest->id;
        $receipet->unit_price =$unitPrice;
        $receipet->quantity = $cardRequest->amount;
        $receipet->total_price =$totalPrice;
        $receipet->company_user_id = Auth::user()->company->id;
        $receipet->proccessed_by = Auth::user()->id;
        $cardRequests->receipt()->save($receipet);

        //update finance
        $finance = Finance::where('company_user_id',Auth::user()->company->id)->get();
        if(count($finance)<=0){
            $this->saveFinace(Auth::user()->company->id,$totalPrice);
        }else{
            $this->updateFinance(Auth::user()->company->id,$totalPrice);
        }
        return response()->json(['status'=>true,
        'card_request'=>$cardRequests,
        'receipt'=>$receipet]);
        //update card sell

    }

    public function calculator($cardTypeId)
    {
       $cardPrice = CardPrice::where('company_user_id',Auth::user()->company->id)->get();
       return CardType::find($cardTypeId)->value*$cardPrice[0]->percentage;//*CardPrice::where('company_user_id',Auth::user()->id)->get()[0]['percentage'];

        
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
        $currentGoalTotalBalance=0;
        foreach($cards as $card){
            $currentGoalTotalBalance += $this->calculator($card->card_type_id);
        }
       return round($currentGoalTotalBalance,2);
    }
}
