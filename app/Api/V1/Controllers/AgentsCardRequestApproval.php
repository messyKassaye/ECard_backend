<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\CardRequest;
use App\Api\V1\Services\CardService;
use Auth;
use App\Cardtype;
class AgentsCardRequestApproval extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $cardService;

    public function __construct(CardService $cardService){
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
        $cardRequest = CardRequest::find($id);
        if($request->status=='Sold'){
                $chechResult = $this->cardService->checkPartnersCardAmount($cardRequest->card_type_id,Auth::user()->id,$cardRequest->amount);
                if($chechResult==0){
                    $cardType = CardType::find($cardRequest->card_type_id);
                    return response()->json([
                        'status'=>false,
                        'message'=>'You do not have enough '.$cardType->value.' Birr card to sell. get card from your card provider']);
                }else{
                    $cardRequest->status = $request->status;
                    $cardRequest->save();
                    return response()->json([
                        'status'=>true,
                        'message'=>'Your card request updated successfully'
                    ]);
                }
        }else{
            $cardRequest->status = $request->status;
            $cardRequest->save();
            return response()->json([
                'status'=>true,
                'message'=>'Your card request updated successfully'
            ]);
        }
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
