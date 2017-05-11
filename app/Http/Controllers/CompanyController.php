<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use Illuminate\Http\Request;
use Auth;

class CompanyController extends Controller
{
    //SÓ PARA USUARIOS LOGADOS
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //PEGANDO O ID DA EMPRESA DO USUÁRIO
        $id_company = Auth::user()->user_id_company;
        $company = Company::all();
        return view('business.index' , compact('company'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('business.create');
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
        //DB::enableQueryLog();
        $company = Company::create($request->all());
        //return DB::getQueryLog();
      }
      catch(Exception $e){
        $errorCode = 400;
        return response()->json(['error' => $errorCode, 'message' => $e->getMessage()], $errorCode);
      }

      return response()->json(['id' => $company->company_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
      return response()->json($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('business.update');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        //
    }
}
