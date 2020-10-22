<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Card;
use Auth;
use App\Api\V1\Services\CardService;
use App\CardType;
use App\Http\Resources\DownloadCardResource;
class DownloadCardController extends Controller
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
    public function show($card_type_id,$amount)
    {
        //
        $leftCards = count(Card::where([
            ['card_type_id',$card_type_id],
            ['owner_id',Auth::user()->id],
            ['status','not_sold']
        ])->get());

        $ownerId = Auth::user()->id;
        $cardType = CardType::find($card_type_id);
        $checkResult = $this->cardService->checkPartnersCardAmount($card_type_id,$ownerId,$amount);
        if($checkResult==1){
            $cards = Card::where([
                ['card_type_id',$card_type_id],
                ['owner_id',Auth::user()->id],
                ['status','not_sold']
            ])->take($amount)->get();
            return response()->json([
                'status'=>true,
                'data'=>DownloadCardResource::collection($cards),
                'message'=>'Successfully downloaded'
            ]);
        }else{
            return response()->json([
            'status'=>false,
            'data'=>[],
            'message'=>'You do not have enough '.$cardType->value.' Birr card to download',
            'left_cards'=>$leftCards]);
        }
        
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
