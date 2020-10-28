<?php

namespace App\Api\V1\Controllers;

use App\MyAgent;
use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\MyAgentsResource;
use App\Http\Resources\MyPartnersResource;
use App\Api\V1\Services\NotificationService;
class MyAgentController extends Controller
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
        if(Auth::user()->role[0]->id==2){
            return MyAgentsResource::collection(Auth::user()->myAgents);
        }else{
            return MyAgentsResource::collection(Auth::user()->myPartners);
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
        $myAgent = new MyAgent();
        if(Auth::user()->role[0]->id==2){
            $checkOut = MyAgent::where('partner_id',Auth::user()->id)
                                ->where('agent_id',$request->partner_id)
                                ->get();

            if(count($checkOut)<=0){
                $myAgent->partner_id = Auth::user()->id;
                $myAgent->agent_id = $request->partner_id;
                $myAgent->save();
                $message = Auth::user()->first_name." sents you let's work together request. do you need to work with ".Auth::user()->first_name;
                $this->notificationService->notify(1,Auth::user()->id,$request->partner_id,$message,'notification/',$myAgent->id);
                return response()->json(['status'=>true,'message'=>"your let's work together request has been sent"]);        
            }else{
                return response()->json(['status'=>true,'message'=>"your let's work together request has been sent"]);        
            }

        }else{
            $myAgent->agent_id = Auth::user()->id;
            $myAgent->partner_id = $request->partner_id;
        }

     }

    /**
     * Display the specified resource.
     *
     * @param  \App\MyAgent  $myAgent
     * @return \Illuminate\Http\Response
     */
    public function show($status)
    {
        //
        $agents;
        if(Auth::user()->role[0]->id==2){
            $agents = MyAgent::where('partner_id',Auth::user()->id)->where('status',$status)->get();
            return MyAgentsResource::collection($agents);
        }else{
            $agents = MyAgent::where('agent_id',Auth::user()->id)->where('status',$status)->get();
            return MyAgentsResource::collection($agents);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MyAgent  $myAgent
     * @return \Illuminate\Http\Response
     */
    public function edit(MyAgent $myAgent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MyAgent  $myAgent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
        $myAgent = MyAgent::find($id);
        $myAgent->status = $request->status;
        $myAgent->save();
        return response()->json(['status'=>true,'message'=>'Update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MyAgent  $myAgent
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyAgent $myAgent)
    {
        //
    }
}
