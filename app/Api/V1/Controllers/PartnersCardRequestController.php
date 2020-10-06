<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\CardRequest;
use Auth;
use App\Events\NewCardRequest;

class PartnersCardRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $cardRequest = CardRequest::where(function ($q) {
            $q->where('requested_to', Auth::user()->company->id)->orWhere('requested_to', Auth::user()->id);
        })->get();
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
            if($request->amount!=''){
            $cardRequest = new CardRequest();
            $cardRequest->requester_id =Auth::user()->id;
            $cardRequest->card_type_id = $request->card_type_id;
            $cardRequest->amount = $request->amount;
            $cardRequest->requested_to = Auth::user()->company->id;
            if($cardRequest->save()){
               event(new NewCardRequest($cardRequest));
              return response()->json(['status'=>true,'message'=>'Card request addedd successfully']);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($status)
    {
        //
        $cardRequest = CardRequest::where(function ($q) {
            $q->where('requested_to', Auth::user()->company->id)->orWhere('requested_to', Auth::user()->id);
        })->where('status',$status)->get();
    
        return CardRequestResource::collection($cardRequest);
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
