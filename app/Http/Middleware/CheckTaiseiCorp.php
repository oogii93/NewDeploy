<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTaiseiCorp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {




        if (!auth()->check()) {
            abort(403, 'Unauthorized access.');
        }
        $user=auth()->user();




        if (!$user->corp || $user->corp->corp_name !== '太成HD') {
            abort(403, 'Unauthorized access.');
        }



        return $next($request);
    }
}
