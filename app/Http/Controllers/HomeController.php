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
}
