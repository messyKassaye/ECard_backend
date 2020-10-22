<?php
namespace App\Api\V1\Services;
use App\CardRequest;
use App\Api\V1\Services\CardService;
use Auth;
class ProccessCardRequest{

    protected $cardService;
    public function __construct(CardService $cardService){
            $this->cardService = $cardService;
    }

    public function proccessRequest(){
        $cardRequest = CardRequest::where('status','Sold')->get();
        foreach($cardRequest as $request){
          $this->cardService->partnersCardTransaction($request,$request->requested_to);
        }
    }
}