<?php

namespace App\Http\Controllers;

use App\Service\Company\CompanyDataProvider;
use Exception;
use App\Models\Company;
use Illuminate\Http\Request;
use Auth , DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;
use Throwable;
use Yajra\Datatables\Facades\Datatables;
use Carbon\Carbon;

class CompanyController extends Controller
{
    use \App\Traits\ActionTable;

    //SÓ PARA USUARIOS LOGADOS
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('profile:owner');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
            $company->company_status = 0;
            $company->save();
            return response()->json(['status' => 'success', 'message' => 'Cliente desativado com sucesso']);
        } catch (Throwable $e) {
            return response()->json(['status' => 'error', 'message' => 'Não foi possível desativar o cliente, tente novamente mais tarde']);
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

        try
        {
            //DB::connection()->enableQueryLog();
            $company = DB::table('companies')->where('company_id' , $request['company_id'])->update(['company_status' => 1]);

        }
        catch(Exception $e)
        {
            return response()->json(['status' => 'error', 'message' => 'Empresa não ativada,tente novamente.'], 422);
            // return $e->getMessage();
        }

        return response()->json(['status' => 'success', 'message' => 'Empresa ativada com sucesso.']);

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

            $uploaddir = dirname(dirname(dirname(__DIR__))).'/public/img/logo/';
            
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

    public function dataTable()
    {
        $company_id = Auth::user()->user_id_company;
        $companies = Company::select([
            'company_id',
            'company_name',
            'company_fantasy',
            'company_cnpj',
            'created_at',
            'company_manager',
        ])
            ->where('company_id', '<>', $company_id)
            ->where('company_status', 1)
            ->orderBy('created_at', 'desc');

        $dataTable = Datatables::of($companies);

        $dataTable->addColumn(
            'action',
            function($company) {
                return $this->actions($company->company_id);
            }
        );

        $dataTable->editColumn(
            'created_at',
            function($company) {
                $created_at = new Carbon($company->created_at);
                return $created_at->format('d/m/Y à\s H:i:s');
            }
        );

        return $dataTable->make(true);
    }

    private function actions($companyId)
    {
        return implode("", [
            $this->actionButton(
                $companyId,
                'Editar Empresa',
                'editCompany',
                'fa-pencil'
            ),
            $this->actionButton(
                $companyId,
                'Desativar empresa',
                'deactivateCompany',
                'fa-ban',
                'btn-danger'
            )
        ]);
    }

    public function getCompanyData(string $cnpj, CompanyDataProvider $companyDataProvider)
    {
        $data = $companyDataProvider->getCompanyData($cnpj);
        return response()->json($data->toArray());
    }
}
