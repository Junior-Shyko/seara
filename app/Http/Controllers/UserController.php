<?php

namespace Seara\Http\Controllers;

use Auth, DB;
use Exception;
use Validator;
use Seara\Role;
use Carbon\Carbon;
use Seara\Permission;
use Seara\Models\User;
use Seara\Models\Company;
use Seara\Models\Profile;
use Seara\FunctionGeneral;
use Illuminate\Http\Request;
use Seara\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;
use Seara\Repository\UserRepository;
use Yajra\DataTables\Facades\DataTables;
use Seara\Http\Controllers\PermissionController;

class UserController extends Controller
{

    use \Seara\Traits\ActionTable;

    public function __construct()
    {
        // $this->middleware('profile:admin');
    }

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
        //EVITANDO DE ENVIAR ESSES IDS DE PERFIL
        $profile    = Profile::all()->except([1,2, 4]);

        $users = DB::table('companies')
        ->join('users', function ($join) use ($id_company) {
          $join->on('companies.company_id', '=', 'users.user_id_company')
          ->where('companies.company_id', '=', $id_company->company_id);
      })->get();

      $companies = Company::get();
        //return DB::getQueryLog();
        //id_company passando ID_COMPANY mais está levando o objeto inteiro

        return view('user.index' , compact('users' , 'profile' , 'companies'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(Request $request)
    {
       
        $user = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_id_profile' => 1,
            'user_id_company' => $request->codCompany,
            'users_avatar' => 'default-user-avatar.png'
        ];
        try {
            User::create($user)->assignRole('user');
            return response()->json(['message' => 'Usuário cadastrado'], 200);
        }
        catch(Exception $e) {
            $errorCode = 422;
            return response(['status' => 'error', 'error' => $errorCode, 'message' => $e->getMessage()], $errorCode);
        }

        
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {

        $rules = [
            'user_id_company' => 'required',
            'email' => 'required|unique:users',
            'name' => 'required',
            'user_cpf' => 'required|unique:users',
            'user_birth' => 'required|date_format:d/m/Y',
            'password' => 'required',
            'user_addr_cep' => 'required',
            'user_addr_street' => 'required',
            'user_addr_number' => 'required',
            'user_addr_district' => 'required',
            'user_addr_city' => 'required',
            'user_addr_state' => 'required'
        ];

        $validator = Validator::make( $request->all(), $rules );

        if ( $validator->fails() )
        {
            $messages = $validator->errors()->all();
            return response( ['status' => 'error', 'message' => $messages], 422 );
        }

        // criptografo a senha
        $request['password'] = bcrypt($request['password']);
        try {
            $request['users_avatar'] = 'default-user-avatar.png';
           
            $user = User::create($request->all());

        }
        catch(Exception $e) {
            $errorCode = 422;
            return response(['status' => 'error', 'error' => $errorCode, 'message' => $e->getMessage()], $errorCode);
        }

        return response(['status' => 'success', 'message' => 'Usuário criado com sucesso', 'id' => $user->id]);
    }

    /**
    * Display the specified resource.
    *
    * @param  \Seara\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function show(User $user)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \Seara\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        $profile = Auth::user();
        $idDecript = base64_decode($id);
        $subTitle = " Edite seus dados do perfil";
        if($profile->user_id_profile == 4) {
            $subTitle = "Altere os dados do usuário";
        }
        //dump($idDecript);
        $user = User::where('user_id_company',$idDecript)->get();
        return view( 'user.edit' , compact('user', 'subTitle') );
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Seara\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, User $user)
    {
          //CREATED 2017-04-17 15:06 BY EXCELLENCE SOFT

        if(empty($request['password']))
        {
            unset($request['password']);
        }
        else
        {
            $request['password'] = bcrypt($request['password']);
        }

        //ALTERANDO A DATA BRASILEIRA PARA A AMERICANA
        $request['user_birth'] = FunctionGeneral::DataBRtoMySQL($request['user_birth']);

        $input = $request->all();
        $input = $request->except('_token', '_method');

        try 
        {
            $user_up = $user->update($input);
            return redirect()->back()->with('success' , 'Alteração realizada com sucesso.');
        }
        catch (Exception $e) 
        {
            return redirect()->back()->with('error' , 'Ocorreu um erro: '.$e->getMessage());
        }

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  \Seara\Models\User  $user
    * @return \Illuminate\Http\Response
    */
    public function destroy(User $user, Request $request)
    {
        // Tentar excluir
        try {

            $user->delete();

        }
        catch (Exception $e) 
        {

            $errorCode = 412;
            return response(['status' => 'error', 'code' => $errorCode, 'message' => $e->getMessage()], $errorCode);

        }

        if($request->ajax())
        {
            return response(['status' => 'success', 'message' => "O usuário foi excluído!"]);
        }

        return redirect()->back()->with('success' , 'Usuário excluído com sucesso.');
    }

    // Tabela com os usuários da empresa
    public function dataTable()
    {
        $users = DB::table('users')
        //->where('user_id_company', Auth::user()->user_id_company)
        ->where('id', '<>', Auth::user()->id)
        ->leftjoin('profiles', 'users.user_id_profile', '=', 'profiles.profile_id' )
        ->select([
            'users.id',
            'users.name',
            'users.email',
            'profiles.profile_name',
            'users.created_at'
        ])->orderBy('users.id', 'DESC');

        $dataTable =  DataTables::of($users);

        $dataTable->addColumn(
           
            'action',

            function ($user) 
            {
              return $this->actions($user->id);
            }
        );

        $dataTable->editColumn(

            'created_at',

            function($user)
            {
              $created_at = new Carbon( $user->created_at );
              return $created_at->format('d/m/Y á\s H:i:s');
            }
        );

        return $dataTable->make(true);
    }

    private function actions($id)
    {

        return $this->actionButtons(

            $id,

            [
                [ 'Editar Usuário', 'editUser', 'fa-pencil' ],
                [ 'Excluir Usuário', 'deleteUser', 'fa-trash-o', 'btn-danger' ]
            ]

        );

    }

    public function listUsers()
    {
        $allRole = new Role;
        $roles = $allRole->allRole();
        $allPermission = new Permission();
        $permission = $allPermission->allPermission();
        return view('user.list-permission', compact('roles', 'permission'));
    }

   
    public function getUserPermission()
    {
        $permission = new PermissionController();
        $dataTable = $permission->getUserPermission();
        return $dataTable;
    }

    public function userDeletePermission($id) {
       $userDelete = new PermissionController();
       return $userDelete->userDeletePermission($id);
    }

    public function alterRoleUser(Request $request)
    {
        $alterRole = new RoleController;
        return $alterRole->alterRoleUser($request);
    }

    public function getPermissionUser($id)
    {
        $user = new UserRepository;
        $permission = $user->getPermissionUser($id);
        return response()->json($permission);
    }

    public function alterPermissionUser(Request $request)
    {
        $user = User::findOrFail($request->user);

        dump($user);
    }
}
