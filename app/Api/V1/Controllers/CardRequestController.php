<?php

namespace App\Api\V1\Controllers;

use App\CardRequest;
use Illuminate\Http\Request;
use Auth;
use App\Events\NewCardRequest;
use App\Http\Resources\CardRequestResource;
use App\Api\V1\Services\NotificationService;
use App\CardType;
class CardRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $notificationService;

    public function __construct(NotificationService $notificationService){
        $this->notificationService = $notificationService;
    }
    public function index()
    {
        //
        $cardRequest='';
        if(Auth::user()->role[0]->id==2){
            $cardRequest = CardRequest::where(function ($q) {
                $q->where('requested_to', Auth::user()->company->id)->orWhere('requested_to', Auth::user()->id);
            })->get();
        }else{
            $cardRequest = CardRequest::where('requested_to', Auth::user()->id)->get();
        }
    
        return CardRequestResource::collection($cardRequest);
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
        $cardRequest = new CardRequest();
        $cardRequest->requester_id =Auth::user()->id;
        $cardRequest->card_type_id = $request->card_type_id;
        $cardRequest->amount = $request->amount;
        $cardRequest->requested_to = $request->company_agent_id;
        $cardRequest->payment_type_id = $request->payment_type_id;
        if($cardRequest->save()){
           //event(new NewCardRequest($cardRequest));
           $message = Auth::user()->first_name.' needs '.$request->amount.' of '.CardType::find($request->card_type_id)->value.' Birr cards from you.';
           $this->notificationService->notify(2,Auth::user()->id,$request->company_agent_id,$message,'card_request/'.$cardRequest->id,$cardRequest->id);
          return response()->json(['status'=>true,'card_request'=>$cardRequest,
          'index'=>$request->index+1,'message'=>'Your card is send successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CardRequest  $cardRequest
     * @return \Illuminate\Http\Response
     */
    public function show($status)
    {
        //
        //
        if(Auth::user()->role[0]->id==2){
            $cardRequest = CardRequest::where(function ($q) {
                $q->where('requested_to', Auth::user()->company->id)->orWhere('requested_to', Auth::user()->id);
            })->where('status',$status)->get();
            return CardRequestResource::collection($cardRequest);
        }else{

            $cardRequest = CardRequest::where('requested_to', Auth::user()->id)->where('status',$status)->get();
            return CardRequestResource::collection($cardRequest);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardRequest  $cardRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(CardRequest $cardRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardRequest  $cardRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cardRequest = CardRequest::find($id);
        $cardRequest->status = $request->status;
        if($cardRequest->requested_to==Auth::user()->id){
            $cardRequest->save();
             return response()->json(['status'=>true,'message'=>'Your request is done successfully']);
        }else{
            return response()->json(['status'=>false,'message'=>'You do not have the right to update this data']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardRequest  $cardRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardRequest $cardRequest)
    {
        //
    }
}
