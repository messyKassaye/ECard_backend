<?php

namespace App\Api\V1\Controllers;

use App\MyRetailer;
use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\MyRetailersResource;
use App\Api\V1\Services\NotificationService;
class MyRetailerController extends Controller
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
        if(Auth::user()->role[0]->id==3){
            return MyRetailersResource::collection(Auth::user()->myRetailer);
        }else{
            return MyRetailersResource::collection(Auth::user()->retailersAgent);
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
        $myRetailer = new MyRetailer();
        if(Auth::user()->role[0]->id==3){
            $myRetailer->agent_id = Auth::user()->id;
            $myRetailer->retailer_id = $request->agent_id;
        }else{
            $myRetailer->agent_id = $request->agent_id;
            $myRetailer->retailer_id = Auth::user()->id;
        }

        $myRetailer->save();
        $message = Auth::user()->first_name." sents you let's work together request. do you need to work with ".Auth::user()->first_name;
        $this->notificationService->notify(1,Auth::user()->id,$request->agent_id,$message,'notification/',$myRetailer->id);

        return response()->json(['status'=>true,'message'=>"Your let's work together request has been sent successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MyRetailer  $myRetailer
     * @return \Illuminate\Http\Response
     */
    public function show($status)
    {
        //
        $retailer;
        if(Auth::user()->role[0]->id==3){
            $retailer = MyRetailer::where('agent_id',Auth::user()->id)->where('status',$status)->get();
            return MyRetailersResource::collection($retailer);
        }else{
            $retailer = MyRetailer::where('retailer_id',Auth::user()->id)->where('status',$status)->get();
            return MyRetailersResource::collection($retailer);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MyRetailer  $myRetailer
     * @return \Illuminate\Http\Response
     */
    public function edit(MyRetailer $myRetailer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MyRetailer  $myRetailer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $myAgent = MyRetailer::find($id);
        $myAgent->status = $request->status;
        $myAgent->save();
        return response()->json(['status'=>true,'message'=>'Update successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MyRetailer  $myRetailer
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyRetailer $myRetailer)
    {
        //
    }
}
