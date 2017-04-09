<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\User;
use Exception;

class SignUpController extends Controller
{

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

  public function index()
  {
    return view('register.register');
  }

	public function signup(Request $request)
	{
		$userData = $request->input('user');
		$companyData = $request->input('company');

		// criptografia da senha
		$userData['password'] = bcrypt($userData['password']);

		// Cadastro da empresa no banco
		try {
			$company = Company::create($companyData);
		}
		catch(Exception $e){
			$errorCode = 400;
			return response()->json(['error' => $errorCode, 'message' => $e->getMessage()], $errorCode);
		}

		// Tento Criar o Usuário
		$userData['user_id_company'] = $company->company_id;

		try {
			$user = User::create($userData);
		}
		catch(Exception $e) {
			$errorCode = 400;

			// Caso tenha alguma falha no cadastro do usuário, devo excluir tb a Empresa
			$company->delete();

			return response(['error' => $errorCode, 'message' => $e->getMessage()], $errorCode);
		}

		return response()->json(['message' => 'Cadastro concluído']);
	}
}
