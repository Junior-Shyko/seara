<?php

namespace Seara\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Seara\SettingsBox;
use Illuminate\Support\Facades\Auth;
use Seara\Repository\SettingsBoxRepository;

class CheckBoxOpenClose
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $id_company = Auth::user()->user_id_company;
        $openClose =  SettingsBoxRepository::getBoxOpenOrClose($id_company, $request->entries_date_launch);
        if($openClose->slug == 'close')
        {
            return response()->json(['message' => 'Vocẽ não poderá lançar movimento com um caixa fechado'], 403);
        }

        return $next($request);
    }
}
