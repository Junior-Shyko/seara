<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->guest()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->guest('login');
            }
        }

        // Logout caso a empresa do usuário não esteja ativa
        $company = Company::find( Auth::user()->user_id_company );

        //Caso a empresa não esteja ativa, o usuário é deslogado
        if(Auth::check() && $company->company_status != 1){
            Auth::logout();
            return redirect('login')->with(
                'error',
                "A empresa {$company->company_fantasy} ainda não foi ativada. Aguarde enquanto o cadastro é avaliado."
            );
        }

        return $next($request);
    }
}
