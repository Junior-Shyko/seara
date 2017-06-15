<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use App\Models\ReceiptCompany;
use Carbon\Carbon;
use Auth, DB;
use Yajra\Datatables\Facades\Datatables;

class HomeController extends Controller
{
    use \App\Traits\ActionTable;

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
        if(Auth::user()->user_id_profile == 1)
        {
          $tot_company = Company::where('company_status' ,'=', 1)->where('company_id', '<>', Auth::user()->company->company_id)->count();
          $tot_users   = User::totalActiveUsers();
          $company_id = Auth::user()->company->company_id;

          $now = Carbon::now();

          $tot_recibos = ReceiptCompany::whereMonth('receipt_date', $now->month)
                          ->whereYear('receipt_date', $now->year)
                          ->where('receipt_id_company', $company_id)
                          ->count();

          $valor_recibos = ReceiptCompany::whereMonth('receipt_date', $now->month)
                          ->whereYear('receipt_date', $now->year)
                          ->where('receipt_id_company', $company_id)
                          ->sum('receipt_value');

          $valor_recibos = "R$ " . number_format( $valor_recibos, 2, ',', '.' );

          return view('home' , compact('tot_recibos' , 'tot_users' , 'tot_company', 'valor_recibos'));
        }
        else
        {
            $company = Company::where('company_id' ,'=', Auth::user()->user_id_company)->get();
            
            //TOTAL DE USUÁRIOS
            $tot_users      = User::where('user_id_company' , Auth::user()->user_id_company);
            

            return view('home_basic' , compact('company' , 'tot_users' ));
        }
    }

    public function dataTable()
    {
        $company = Auth::user()->company;

        $users = Company::select([
            'company_id',
            'company_name',
            'company_fantasy',
            'company_cnpj',
            'created_at'          
          ])
        ->where('company_id', '<>', $company->company_id)
        ->where('company_status', 0);

        return Datatables::of($users)
        ->addColumn(
          'company_admin', function($company) {
            $company = Company::find( $company->company_id );
            $nome = $company->users->where('user_id_profile', 3)->first()->name;
            return $nome;
          }
        )
        ->addColumn(
          'action',
          function ($company) {
            return $this->actions($company->company_id);
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
        return $this->actionButton(
            $id,
            'Aprovar Empresa',
            'allowCompany',
            'fa-check-square'
        );
    }
}
