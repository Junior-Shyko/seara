<?php

namespace App\Http\Controllers;

use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;
use Auth, DB;
use Exception;
use App\Models\User;
use App\FunctionGeneral;
use App\Models\Company;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        DB::enableQueryLog();
        $id_profile = Auth::user()->user_id_profile;
        $id_company = Company::where('company_id' , Auth::user()->user_id_company)->first();
        
        $users = DB::table('companies')
                ->join('users', function ($join) use ($id_company) {
            $join->on('companies.company_id', '=', 'users.user_id_company')
                 ->where('companies.company_id', '=', $id_company->company_id);
        })->get();
        //return DB::getQueryLog();
            
        return view('user.index' , compact('users'));
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
      // criptografo a senha

      $request['password'] = bcrypt($request['password']);
      try {
        $user = User::create($request->all());
      }
      catch(Exception $e) {
        $errorCode = 400;
        return response(['error' => $errorCode, 'message' => $e->getMessage()], $errorCode);
      }

      return response(['id' => $user->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       // return $user;
       $id = base64_decode($id);
       $user = User::find($id);
       return view('user.edit' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //CREATED 2017-04-17 15:06 BY EXCELLENCE SOFT
        
        if(empty($request['password']))
        {
            unset($request['password']);
        }else{
            $request['password'] = bcrypt($request['password']);
        }
        //ALTERANDO A DATA BRASILEIRA PARA A AMERICANA
        $request['user_birth'] = FunctionGeneral::DataBRtoMySQL($request['user_birth']);

        $input = $request->all();
        $input = $request->except('_token', '_method');

        try {
             $user_up = $user->update($input);
             return redirect()->back()->with('success' , 'Alteração realizada com sucesso.');
        } catch (Exception $e) {
            return redirect()->back()->with('error' , 'Ocorreu um erro: '.$e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
