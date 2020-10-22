<?php

namespace App\Api\V1\Controllers;

use App\CardRequestApproval;
use Illuminate\Http\Request;
use Auth;
use App\CardRequest;
use App\CardType;
use App\Card;
use App\Api\V1\Services\CardService;
class CardRequestApprovalController extends Controller
{

    public $cardService;
    public function __construct(CardService $cardService) {
        $this->cardService = $cardService;
    }
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
        $cardRequest= CardRequest::find($request->request_id);
        $checkResult= $this->cardService->checkPartnersCardAmount($cardRequest->card_type_id,Auth::user()->id,$cardRequest->amount);
        if($checkResult==0){
            $cardType = CardType::find($cardRequest->card_type_id);
            return response()->json([
                'status'=>false,
                'message'=>'You do not have enough '.$cardType->value.' Birr card to sell. get card from your card provider']);
        }else{
            $cardRequest->status = $request->status;
            $cardRequest->payment_type_id = $request->payment_type_id;
            $cardRequest->save();
            return response()->json(['status'=>true,'message'=>'Your card request is updated successfully']);
        }
        /*$cardRequestApproval = new CardRequestApproval();
        $cardRequestApproval->card_request_id=$request->request_id;
        $cardRequestApproval->user_id=Auth::user()->id;
        if($cardRequestApproval->save()){
            return response()->json(['status'=>true,'message'=>'Request is approved successfully']);
        }*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CardRequestApproval  $cardRequestApproval
     * @return \Illuminate\Http\Response
     */
    public function show(CardRequestApproval $cardRequestApproval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardRequestApproval  $cardRequestApproval
     * @return \Illuminate\Http\Response
     */
    public function edit(CardRequestApproval $cardRequestApproval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardRequestApproval  $cardRequestApproval
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardRequestApproval $cardRequestApproval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardRequestApproval  $cardRequestApproval
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardRequestApproval $cardRequestApproval)
    {
        //
    }
}
