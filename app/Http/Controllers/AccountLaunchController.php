<?php

namespace App\Http\Controllers;

use App\AccountLaunch;
use Illuminate\Http\Request;
use Validator;

class AccountLaunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('launch.index');
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
        // dump($request->all());
        // dump(gettype($request->all()));
        // dd();
        // $req = json_decode($request->all());
        // dump($req);
        if(empty($request['accountlaunch_type']) || empty($request['accountlaunch_name'])) {
            return response( ['status' => 'error', 'message' => 'Todos os campos são obrigatórios'], 422 );
        }
        try {
            //dump($request->all());
            $account = AccountLaunch::create($request->all());
            return response( ['status' => 'success', 'message' => 'Conta cadastrada com sucesso'], 200 );
        } catch (\Throwable $th) {
            //throw ;
            dump($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccountLaunch  $accountLaunch
     * @return \Illuminate\Http\Response
     */
    public function show(AccountLaunch $accountLaunch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccountLaunch  $accountLaunch
     * @return \Illuminate\Http\Response
     */
    public function edit(AccountLaunch $accountLaunch)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccountLaunch  $accountLaunch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccountLaunch $accountLaunch)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccountLaunch  $accountLaunch
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccountLaunch $accountLaunch)
    {
        //
    }
}
