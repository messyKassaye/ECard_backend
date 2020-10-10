<?php

namespace App\Api\V1\Controllers;

use App\CardPrice;
use Illuminate\Http\Request;
use Auth;
class CardPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $userId = Auth::user()->id;
        $cardPrice = CardPrice::where('user_id',Auth::user()->id)->with('cardType')->get();
        return $cardPrice;
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
        $cardPrice = new CardPrice();
        $cardPrice->percentage = $request->percentage;
        if(Auth::user()->role[0]->id==2){
            $cardPrice->company_id = Auth::user()->company->id;
        }
        $cardPrice->user_id = Auth::user()->id;
        $cardPrice->save();
        return response()->json(['status'=>true,'message'=>'Card price is setted successfully','card_price'=>CardPrice::where('id',$cardPrice->id)->with('cardType')->get()]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CardPrice  $cardPrice
     * @return \Illuminate\Http\Response
     */
    public function show(CardPrice $cardPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CardPrice  $cardPrice
     * @return \Illuminate\Http\Response
     */
    public function edit(CardPrice $cardPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CardPrice  $cardPrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $cardPrice = CardPrice::find($id);
        $cardPrice->percentage = $request->percentage;
        if($cardPrice->save()){
            return response()->json(['status'=>true,'message'=>'Updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CardPrice  $cardPrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(CardPrice $cardPrice)
    {
        //
    }
}
