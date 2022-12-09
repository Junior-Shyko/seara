<?php

namespace Seara\Http\Controllers;

use Exception;
use Throwable;
use Carbon\Carbon;
use Seara\Models\User;
use Auth , DB, Validator;
use Seara\Models\Company;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Seara\Service\Company\CompanyDataProvider;
use Intervention\Image\ImageManagerStatic as Image;

class CompanyController extends Controller
{
    use \Seara\Traits\ActionTable;

    //SÓ PARA USUARIOS LOGADOS
    public function __construct()
    {
        $this->middleware('auth');
        //$this->middleware('profile:owner');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->user_id_profile == 4){
            $user = Auth::user();
            $roles = DB::table('roles')->select('id', 'name')->get();
            $company = Company::all();
            return view('business.index' , compact('company', 'roles'));
        }else{
            return redirect()->back();
        }
       
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
     * @param  \Seara\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
      return response()->json($company);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Seara\Models\Company  $company
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
     * @param  \Seara\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        try {
            $input = $request->except('_token' , '_method');
            Company::where('company_id' , $company->company_id)->update($input);
            return response()->json(['status' => 'success', 'message' => 'Cliente alterado com sucesso']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Ocorreu um erro, tente novamente!'], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Seara\Models\Company  $company
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
     * @param  \Seara\Models\Company  $company
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
    
        if(Auth::user()->user_id_profile == 4){
            $company_id = Auth::user()->user_id_company;
            $companies = Company::select([
                'company_id',
                'company_name',
                'company_fantasy',
                'company_cnpj',
                'created_at',
                'company_manager',
            ])
                //->where('company_id', '<>', $company_id)
                ->where('company_status', 1)
                ->orderBy('created_at', 'desc');
    
            $dataTable = DataTables::of($companies);
    
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
        }else{
            $companies = [];
            $dataTable = DataTables::of($companies);
            return $dataTable->make(true);
        }
        
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
            ),
            $this->actionButton(
                $companyId,
                'Alterar Acesso',
                'modalLogin',
                'fa-lock',
                'btn-default'
            ),
            $this->actionButton(
                $companyId,
                'Consultar Caixa',
                'redirectBoxCompany',
                'fa-money',
                'btn-default'
            )
        ]);
    }

    public function getCompanyData(string $cnpj, CompanyDataProvider $companyDataProvider)
    {
        $data = $companyDataProvider->getCompanyData($cnpj);
        return response()->json($data->toArray());
    }

    public function getInfoLogin($id) {
        $user = DB::table('users')->where('user_id_company','=',$id)->get();
        if(empty($user)) {
            return false;
        }
        return response()->json($user);
    }

    public function alterAccess(Request $request) {
        $rules = [
            'emailCompany' => 'required',
            'passwordCompany' => 'required|min:6',
        ];

        $validator = Validator::make( $request->all(), $rules );

        if ( $validator->fails() )
        {
            $messages = $validator->errors()->all();
            return redirect()
                        ->back()
                        ->withErrors($messages)
                        ->withInput();
        }

        $update['email'] = $request['emailCompany'];

        // criptografo a senha
        $update['password'] = bcrypt($request['passwordCompany']);
        
        $user = User::where('user_id_company' , '=' , $request['inputIdClient'])->get();
        //verificando se tem usuario e se tiver verifica de os emails sao igual, se for exclui o array
        dump($request['inputIdClient']);
        dd($update);
        if(count($user) > 0) {
            if($user[0]->email == $request['emailCompany']){
                unset($update['email']);
            }
        }
        $userUp = User::where('user_id_company' , '=' , $request['inputIdClient'])->update($update);
        if($userUp){
            return redirect()
            ->back()->with('success' , 'Acesso alterado com sucesso.');
        }else{
            $messages = $validator->errors()->all();
            return redirect()
                        ->back()
                        ->withErrors($messages)
                        ->withInput();
        }
    }
}
