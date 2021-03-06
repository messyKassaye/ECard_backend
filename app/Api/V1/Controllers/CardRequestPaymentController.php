<?php

namespace App\Api\V1\Controllers;

use App\CardRequestPayment;
use Illuminate\Http\Request;

class CardRequestPaymentController extends Controller
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
        $cardRequestPayment = new CardRequestPayment();
        $cardRequestPayment->card_request_id = $request->card_request_id;
        $cardRequestPayment->bank_id = $request->bank_id;
        $cardRequestPayment->transaction_ref_number = $request->reference_number;
        if($cardRequestPayment->save()){
            return response()->json(['status'=>true,'index'=>$request->index+1,'message'=>'Payment is done']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CardRequestPayment  $cardRequestPayment
     * @return \Illuminate\Http\Response
     */
    public function show(CardRequestPayment $cardRequestPayment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardRequestPayment  $cardRequestPayment
     * @return \Illuminate\Http\Response
     */
    public function edit(CardRequestPayment $cardRequestPayment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardRequestPayment  $cardRequestPayment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardRequestPayment $cardRequestPayment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardRequestPayment  $cardRequestPayment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardRequestPayment $cardRequestPayment)
    {
        //
    }
}
