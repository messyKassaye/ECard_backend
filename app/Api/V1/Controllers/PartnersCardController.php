<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Card;
use App\CardType;
use App\Http\Resources\PartnersCardTypeResource;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class PartnersCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cards =CardType::all(); 
        return PartnersCardTypeResource::collection($cards);
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
        $companyId = Auth::user()->company->id;

        for($i=0;$i<=$request->amount;$i++){
            Card::create([
                'owner_id'=>$companyId,
                'card_type_id'=>$request->card_type_id,
                'card_number'=>Str::random(10)
            ]);
        }
        return response()->json(['status'=>true,'message'=>'You got your cards']);
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
        return response()->json(['status'=>true,'message'=>'Your are allowed to acces your cards']);
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
