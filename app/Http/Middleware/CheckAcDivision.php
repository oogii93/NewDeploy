<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAcDivision
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     if (!auth()->check() || !auth()->user()->division || auth()->user()->division->name !== '経理課') {
    //         abort(403, 'Unauthorized access.');
    //     }

    //     return $next($request);
    // }
}
