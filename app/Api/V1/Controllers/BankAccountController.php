<?php

namespace App\Api\V1\Controllers;

use App\BankAccount;
use Illuminate\Http\Request;
use Auth;
use App\Http\Resources\BankAccountResource;
class BankAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bankAccount = BankAccount::where('user_id',Auth::user()->id)->get();
        return BankAccountResource::collection($bankAccount);
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
        $bankAccount = new BankAccount();
        $bankAccount->bank_id = $request->bank_id;
        $bankAccount->user_id = Auth::user()->id;
        $bankAccount->account_number = $request->account_number;
        $bankAccount->holder_full_name = $request->holder_full_name;
        if($bankAccount->save()){
            return response()->json(['status'=>true,'message'=>'Account is setted successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function show(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $bankAccount = BankAccount::find($id);
        $bankAccount->user_id = Auth::user()->id;
        $bankAccount->account_number = $request->account_number;
        $bankAccount->holder_full_name = $request->holder_full_name;
        if($bankAccount->save()){
            return response()->json(['status'=>true,'message'=>'Account is updated successfully']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        //
    }
}
