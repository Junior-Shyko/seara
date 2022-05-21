<?php

namespace Seara\Http\Controllers;

use Seara\AccountBank;
use Seara\Service\TypeAccountBank\GetTypeAccountBank;
use Illuminate\Http\Request;
use Seara\Bank;

class AccountBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::all();
        $types = GetTypeAccountBank::getTyppeAccountBank();
        return view('accountBank.index', compact('types', 'banks'));
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
        try {
            unset($request['idAccontBank']);
            $request['owner'] = $request['company_id'];
            AccountBank::create($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'Conta bancaria salva com sucesso'
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
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
        dd('update');
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
