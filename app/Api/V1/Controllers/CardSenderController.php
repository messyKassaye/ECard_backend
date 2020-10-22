<?php

namespace App\Api\V1\Controllers;

use App\CardRequest;
use Illuminate\Http\Request;
use Auth;
use App\Events\NewCardRequest;
use App\Http\Resources\CardRequestResource;
use App\Api\V1\Services\NotificationService;
use App\CardType;
use App\Api\V1\Services\CardService;
class CardSenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $notificationService;
    protected $cardService;
    public function __construct(NotificationService $notificationService,CardService $cardService){
        $this->notificationService = $notificationService;
        $this->cardService = $cardService;
    }
    
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
        $checkResult= $this->cardService->checkPartnersCardAmount($request->card_type_id,Auth::user()->id,$request->amount);

        if($checkResult==0){
            $cardType = CardType::find($request->card_type_id);
            return response()->json([
                'status'=>false,
                'message'=>'You do not have enough '.$cardType->value.' Birr card to send. get card from your card provider']);
        }else{

            $cardRequest = new CardRequest();
            $cardRequest->requester_id =$request->requester_id;
            $cardRequest->card_type_id = $request->card_type_id;
            $cardRequest->amount = $request->amount;
            $cardRequest->requested_to = Auth::user()->id;
            $cardRequest->payment_type_id = $request->payment_type_id;
            $cardRequest->status = $request->status;
            if($cardRequest->save()){
            event(new NewCardRequest($cardRequest));
            $message = Auth::user()->first_name.' Send '.$request->amount.' of '.CardType::find($request->card_type_id)->value.' Birr cards to you.';
            $this->notificationService->notify(3,Auth::user()->id,$request->requester_id,$message,'card_request/'.$cardRequest->id,$cardRequest->id);
            return response()->json(['status'=>true,'card_request'=>$cardRequest,'message'=>'Card is send successfully']);
            }

        }
        
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
