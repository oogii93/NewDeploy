<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckHrDivision
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     if (!auth()->check() || !auth()->user()->division || auth()->user()->division->name !== '人事課') {
    //         abort(403, 'Unauthorized access.');
    //     }

    //     return $next($request);
    // }
}
