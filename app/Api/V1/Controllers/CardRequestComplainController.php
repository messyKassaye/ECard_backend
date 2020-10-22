<?php

namespace App\Api\V1\Controllers;

use App\CardRequestComplain;
use Illuminate\Http\Request;

class CardRequestComplainController extends Controller
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
        $cardRequestComplain = new CardRequestComplain();
        $cardRequestComplain->card_request_id = $request->card_request_id;
        $cardRequestComplain->complain = $request->complain;
        if($cardRequestComplain->save()){
            return response()->json(['status'=>true,'message'=>'Your complain is submitted successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CardRequestComplain  $cardRequestComplain
     * @return \Illuminate\Http\Response
     */
    public function show(CardRequestComplain $cardRequestComplain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardRequestComplain  $cardRequestComplain
     * @return \Illuminate\Http\Response
     */
    public function edit(CardRequestComplain $cardRequestComplain)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardRequestComplain  $cardRequestComplain
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CardRequestComplain $cardRequestComplain)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardRequestComplain  $cardRequestComplain
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardRequestComplain $cardRequestComplain)
    {
        //
    }
}
