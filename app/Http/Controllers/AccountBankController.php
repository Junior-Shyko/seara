<?php

namespace Seara\Http\Controllers;

use Seara\AccountBank;
use Illuminate\Http\Request;

class AccountBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accountBank.index');
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
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function show(AccountBank $accountBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountBank $accountBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountBank $accountBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\AccountBank  $accountBank
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountBank $accountBank)
    {
        //
    }
}
