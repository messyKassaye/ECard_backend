<?php

namespace App\Api\V1\Controllers;

use App\Finance;
use Illuminate\Http\Request;
use Auth;
use App\Api\V1\Services\CardService;
class FinanceController extends Controller
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
        $finance;
        if(Auth::user()->role[0]->id==2){
            $finance = Finance::where('company_user_id',Auth::user()->company->id)->get();
            return response()->json(['status'=>true,
        'finance'=>$finance,
        'current_goal'=>$this->cardService->currentGoal(Auth::user()->company->id)]);
        }else{
            $finance = Finance::where('company_user_id',Auth::user()->id)->get();
            return response()->json(['status'=>true,
            'finance'=>$finance,
            'current_goal'=>$this->cardService->currentGoal(Auth::user()->id)]);
        }
        
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
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return $this->cardService->currentGoal($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function edit(Finance $finance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Finance $finance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Finance  $finance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Finance $finance)
    {
        //
    }
}
