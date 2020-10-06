<?php

namespace App\Api\V1\Controllers;

use App\AgentPartnerRetailer;
use Illuminate\Http\Request;
use App\Http\Resources\AgentPartnersResource;
use Auth;
class AgentPartnerRetailerController extends Controller
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
        $agentPartneRetailer = new AgentPartnerRetailer();
        $agentPartneRetailer->company_user_id = $request->company_user_id;
        $agentPartneRetailer->agent_partner_retailer_id = Auth::user()->id;
        $agentPartneRetailer->save();
        return response()->json(['status'=>true,'message'=>'Your requested has been sent successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AgentPartnerRetailer  $agentPartnerRetailer
     * @return \Illuminate\Http\Response
     */
    public function show($status)
    {
        //
        if(Auth::user()->role[0]->id==2){
            $followRequest = AgentPartnerRetailer::where('status',$status)->where('company_user_id',Auth::user()->company->id)->get();
            return AgentPartnersResource::collection($followRequest);
        }else{
            $followRequest = AgentPartnerRetailer::where('status',$status)->where('company_user_id',Auth::user()->id)->get();
            return AgentPartnersResource::collection($followRequest);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AgentPartnerRetailer  $agentPartnerRetailer
     * @return \Illuminate\Http\Response
     */
    public function edit(AgentPartnerRetailer $agentPartnerRetailer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AgentPartnerRetailer  $agentPartnerRetailer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $agentPartneRetailer = AgentPartnerRetailer::find($id);
        $agentPartneRetailer->status = $request->status;
        $agentPartneRetailer->save();
        return response()->json(['status'=>true,'message'=>'Agent request is accepted successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AgentPartnerRetailer  $agentPartnerRetailer
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgentPartnerRetailer $agentPartnerRetailer)
    {
        //
    }
}