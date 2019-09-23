<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Exception;
use Validator;

use App\Mail\UserRegistered;
use Illuminate\Support\Facades\Mail;

use Carbon\Carbon;

class SignUpController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('guest');
	}

	public function index()
	{
	    return view('register.register');
	}

	private function validateData( $data )
	{
		$rules = [
			/* VALIDAÇÃO DO USUÁRIO */
	      	'name' => 'required',

	      	/* VALIDAÇÃO DA EMPRESA */
	      	'company_cnpj' => 'required|unique:companies',
	      	'company_name' => 'required',
	      	'company_fantasy' => 'required',
	      	'company_addr_cep' => 'required',
	      	'company_addr_street' => 'required',
	      	'company_addr_number' => 'required',
	      	//'company_addr_complement' => 'required',
	      	'company_addr_district' => 'required',
	      	'company_addr_city' => 'required',
	      	'company_addr_state' => 'required',
	      	'company_phone' => 'required',
	      	//'company_mobile' => 'required'
	    ];

	    // Cria o validador
	    $validator = Validator::make( $data, $rules );
	    
	    if ( $validator->fails() )
	    {
	    	$messages = $validator->errors()->all();

	    	return [
	    		'status' => false,
	    		'message' => $messages
	    	];
	    }

	    return ['status' => true];
	}

	public function signup(Request $request)
    {
        $userData = $request->input('user');
        $companyData = $request->input('company');

        $validation = $this->validateData(array_merge($userData, $companyData));

        if (!$validation['status']) {
            return response( ['status' => 'error', 'message' => $validation['message']], 422 );
        }

        try {
            DB::transaction(function () use ($companyData, $userData) {
                $companyData['company_status'] = 1;
                $companyData['company_manager'] = $userData['name'];
                Company::create($companyData);
            });

            return response()->json(['status' => 'success', 'message' => 'Cadastrado concluido com sucesso.']);
        } catch (\Throwable $e) {
            $errorCode = 422;
            return response()
                ->json([
                    'status' => 'error',
                    'message' => 'Cadastrado não concluído, tente novamente.'
                ], $errorCode);
        }
    }

    public function checkCNPJ(Request $request)
	{
		$rules = [
			'company_cnpj' => 'unique:companies'
		];

		$validator = Validator::make( $request->all(), $rules );

		if ( $validator->fails() )
		{
			return response()->json(['status' => 'error', 'message' => $messages = $validator->errors()->all()[0]], 422);
		}
		else
		{
			return response()->json(['status' => 'success']);
		}
	}
}
