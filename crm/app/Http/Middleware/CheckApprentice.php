<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;

class CheckApprentice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /**
     * Uwaga!!! przy testowaniu middleware nalezy sparawdzic czy zalogowany user jest w skladzie aktualnego team'u!!!
     *
     */
    public function handle(Request $request, Closure $next)
    {
        $team = $request->user()->currentTeam;

        if (!empty($team)){  
            
            $user = $request->user();

        if ( $user->teamRole($team)->key =='apprentice') {
            abort(401);
        }

        return $next($request);
    }
     
    }
}
