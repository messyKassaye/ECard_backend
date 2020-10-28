<?php

namespace App\Api\V1\Controllers;

use App\CompanyUserVerification;
use Illuminate\Http\Request;
use Auth;
use App\User;

class CompanyUserVerificationController extends Controller
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
        $userVerification = User::find(Auth::user()->id)->verification;
        if($userVerification!=null){
            $companyUserVerification = new CompanyUserVerification();
            $companyUserVerification->user_id = $request->user_id;
            $companyUserVerification->verified_by = Auth::user()->id;
            $companyUserVerification->is_verified = true;
            if($companyUserVerification->save()){
                return response()->json(['status'=>true,'message'=>'Verified successfully']);
            }
        }else{
            return response()->json(['status'=>false,'message'=>'You are not verified. So you can not verify others']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CompanyUserVerification  $companyUserVerification
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyUserVerification $companyUserVerification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CompanyUserVerification  $companyUserVerification
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyUserVerification $companyUserVerification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CompanyUserVerification  $companyUserVerification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyUserVerification $companyUserVerification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CompanyUserVerification  $companyUserVerification
     * @return \Illuminate\Http\Response
     */
    public function destroy(CompanyUserVerification $companyUserVerification)
    {
        //
    }
}
