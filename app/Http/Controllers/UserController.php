<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;
use Auth, DB;
use Exception;
use App\Models\User;
use App\FunctionGeneral;
use App\Models\Company;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Validator;

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
    //id_company passando ID_COMPANY mais está levando o objeto inteiro

    return view('user.index' , compact('users' ));
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

    $messages = [
      'email.required' => 'O email é obrigatório!',
      'email.unique' => 'Esse email já está sendo utilizado!',
      'name.required' => 'O nome é obrigatório'
    ];

    $rules = [
      'email' => 'required|unique:users',
      'name' => 'required'
    ];

    $validator = Validator::make( $request->all(), $rules, $messages );

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
      $errorCode = 412;
      return response(['status' => 'error', 'error' => $errorCode, 'message' => $e->getMessage()], $errorCode);
    }

    return response(['status' => 'success', 'message' => 'Usuário criado com sucesso', 'id' => $user->id]);
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
  public function edit(User $user)
  {
    // return $user;
    //  $id = base64_decode($id);
    //  $user = User::find($id);
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
    // Tentar excluir
    try {

      $user->delete();

    } catch (Exception $e) {

      $errorCode = 412;
      return response(['status' => 'error', 'code' => $errorCode, 'message' => $e->getMessage()], $errorCode);

    }

    return response(['status' => 'success', 'message' => "O usuário foi excluído!"]);
  }

  // Tabela com os usuários da empresa
  public function dataTable()
  {
    $users = DB::table('users')
    ->where('user_id_company', Auth::user()->user_id_company)
    ->where('id', '<>', Auth::user()->id)
    ->leftjoin('profiles', 'users.user_id_profile', '=', 'profiles.profile_id' )
    ->select([
      'users.id',
      'users.name',
      'users.email',
      'profiles.profile_name',
      'users.created_at'
    ]);

    return Datatables::of($users)
    ->addColumn(
      'action',
      function ($user) {
        return $this->actions($user->id);
      })
      ->editColumn(
        'created_at',
        function($user){
          $created_at = new Carbon( $user->created_at );
          return $created_at->format('d/m/Y á\s H:i:s');
        })
        ->make(true);
      }

      private function actions($id)
      {
        return $this->actionEdit($id)
        .$this->actionDelete($id);
      }

      private function actionEdit($id)
      {
        return "<button class='btn btn-primary btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Editar Usuário' onclick='editUser( {$id} )' role='tooltip'> <i class='fa fa-pencil'></i> </button>";
      }

      private function actionDelete($id)
      {
        return "<button class='btn btn-danger btn-xs' data-toggle='tooltip' data-placement='top' data-original-title='Excluir Usuário' onclick='deleteUser( {$id} )' role='tooltip'> <i class='fa fa-trash-o'></i> </button>";
      }
    }
