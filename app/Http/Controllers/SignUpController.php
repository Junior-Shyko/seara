<?php

namespace App\Http\Controllers;

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
	      	'user_addr_state' => 'required',

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
		$userData 						= $request->input('user');
		$companyData 					= $request->input('company');
		

		$validation = $this->validateData( array_merge($userData, $companyData) );

		if ( !$validation['status'] )
		{
			return response( ['status' => 'error', 'message' => $validation['message']], 422 );
		}
		else
		{
			// criptografia da senha
			$userData['password'] = bcrypt($userData['password']);

			$company = []; // empresa a ser criada

			// Cadastro da empresa no banco
			try {
				$companyData['company_status'] 	= 0;
				//dd($companyData);
				$company = Company::create($companyData);
			}
			catch(Exception $e){
				$errorCode = 422;
				return response()->json(['status' => 'success', 'message' => 'Cadastrado não concluído, tente novamente.'], $errorCode);
			}

			// Tento Criar o Usuário
			$userData['user_id_company'] 	= $company->company_id;
			$userData['users_avatar'] 		= 'default-user-avatar.png';
			$userData['user_id_profile']	= 2;
			$userData['user_birth']			= Carbon::createFromFormat('d/m/Y', $userData['user_birth'])->format('Y-m-d');

			try {
				$user = User::create($userData);
			}
			catch(Exception $e) {
				$errorCode = 422;

				// Caso tenha alguma falha no cadastro do usuário, devo excluir tb a Empresa
				$company->delete();

				return response(['status' => 'error', 'message' => ['Cadstrado não concluído, tente novamente.']], $errorCode);
			}

			Mail::to('excelencesoft@gmail.com')->send(new UserRegistered($user, true)); // envia para edvan
			Mail::to($user)->send(new UserRegistered($user));

			return response()->json(['status' => 'success', 'message' => 'Cadastrado concluido com sucesso.']);
			}
	}
}
