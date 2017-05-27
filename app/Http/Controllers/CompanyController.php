<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Company;
use Illuminate\Http\Request;
use Auth , DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

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
        
        return view('business.update', compact('company'));
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
        
        try {
            $input = $request->all();
            $input = $request->except('_token' , '_method');
            $companies = Company::where('company_id' , $company->company_id)->update($input);
            return redirect()->back()->with('success' , 'Igreja alterado com sucesso');
        } catch (Exception $e) {

            return redirect()->back()->with('error' , 'Ocorreu um erro, tente novamente.');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        try {
          $company->delete();
          return redirect()->back()->with('success' , 'Igreja excluída com sucesso');
        } catch (Exception $e) {
          return redirect()->back()->with('error' , 'Ocorreu um erro: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function companiesStatus()
    {
        $company = Company::where('company_status' , 0)->get();
        return response()->json($company);
    }


    public function alterStatus(Request $request)
    {
        $company = Company::find($request['company_id']);

        try{
            //DB::connection()->enableQueryLog();
            $company = DB::table('companies')->where('company_id' , $request['company_id'])->update(['company_status' => 1]);
            //return DB::getQueryLog();
            return redirect()->back()->with('success' , 'Empresa Ativa');
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function alterLogo(Request $request)
    {
       if($request->ajax())
        {
        
            $tot_array = count($_FILES["logo_upload"]["name"]);
            $id_company = Company::find(Auth::user()->user_id_company);

            $tmp_name = $_FILES["logo_upload"]["tmp_name"];
            $exp = explode(".", $_FILES["logo_upload"]["name"]);
            $extension = end($exp);
                // // //RENOMIANDO O ARQUIVO
            $name =  time(). '_'.Str::random(10).'.'.$extension;


            //dd($tmp_name);
            $uploaddir = '/var/www/html/seara/public/img/logo/';
            $uploadfile = $uploaddir . basename($name);


            
            if (move_uploaded_file($tmp_name, $uploadfile)) {
                //\DB::enableQueryLog();
                $company = DB::table('companies')->where('company_id' , $id_company->company_id)->update(['company_brand_logo' => $name]);
                //return \DB::getQueryLog();
                
                return response()->json(['messagem' , 'success']);
            } else {
                return response()->json(['messagem' , 'error']);
            }

           
        }
    }

    
}
