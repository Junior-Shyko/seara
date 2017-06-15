<?php

namespace App\Http\Middleware;

use Closure;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $profile)
    {
        // Se o perfil do usuário logado não for o perfil necessário,
        // Retorno acesso negado
        $user_profile = $request->user()->profile;

        if ( $user_profile != 'owner' && $user_profile != $profile ) {
            abort(403);
        }

        return $next($request);
    }
}
