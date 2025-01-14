<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class YumeyaCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user=Auth::user();



        if(
            $user->office &&
            $user->office->corp &&
            $user->office->corp->corp_name === 'ユメヤ'
        )
        {
            return abort(403, 'Access denied for ユメヤ admins.');
        }
        return $next($request);
    }
}
