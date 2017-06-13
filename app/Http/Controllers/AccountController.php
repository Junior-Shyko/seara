<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Box;
use DB, Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return "CConta";
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
        //Create 2017-06-08 by Excellence Soft
        if($request->ajax()){
            try {
                $account = Account::create($request->all());
                return response()->json(['message' , 'success']);
            } catch (Exception $e) {
                return response()->json(['message' , 'error'.$e->getMessege()]);
            }

        }
        //dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$desc_account = Account::where('accounts_id' , $id)->get();
           // DB::enableQueryLog();
        $desc_account = DB::table('accounts')
                ->join('type_accounts', 'accounts.accounts_id_type_account' , '=' , 'type_accounts.type_accounts_id' )
                ->where('accounts.accounts_id', '=', $id)
                ->get();
               
        //return DB::getQueryLog();
    return response()->json([$desc_account]);
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
