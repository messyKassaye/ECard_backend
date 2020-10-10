<?php

namespace App\Api\V1\Controllers;

use Illuminate\Http\Request;
use App\Address;
use App\Http\Resources\AddressResource;
use Auth;
use App\AgentPartnerRetailer;
class NearByPartnerAndAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(Auth::user()->address==null){
            return response()->json(
                ['status'=>false,
                'message'=>'address is not setted. Please set your address',
                'data'=>[]]);
        }else{
            
            $address = Address::where('region_id',Auth::user()->address->region_id)
                                ->where('user_id','!=',Auth::user()->id)->get();
            return response()->json(
                ['status'=>true,
                'message'=>'Partners near by you',
                'data'=>AddressResource::collection($address)]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $address = Address::where('region_id',$id)->get();
        return AddressResource::collection($address);
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
