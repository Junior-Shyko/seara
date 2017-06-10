<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->user_id_profile == 1){
            $company = Company::where('company_status' ,'=', 0)->get();
            //TOTAL DE USUÁRIOS
            $tot_users      = User::all()->count();
            $tot_company    = Company::all()->count();        
            
            return view('home' , compact('company' , 'tot_users' , 'tot_company'));
        }else{
            $company = Company::where('company_id' ,'=', Auth::user()->user_id_company)->get();
            
            //TOTAL DE USUÁRIOS
            $tot_users      = User::where('user_id_company' , Auth::user()->user_id_company);
            

            return view('home_basic' , compact('company' , 'tot_users' ));
        }
    }

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
