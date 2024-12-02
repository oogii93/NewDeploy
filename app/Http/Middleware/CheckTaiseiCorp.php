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


        // $user->auth()->user();
        // dd([
        //     'user_id' => $user->id,
        //     'corp_name' => $user->corp->corp_name,
        //     'is_太成HD' => $user->corp->corp_name === '太成HD'
        // ]);


        if (!auth()->check()) {
            abort(403, 'Unauthorized access.');
        }
        $user=auth()->user();


        \Log::info('User Corp Check', [
            'user_id' => $user->id,
            'corps' => $user->corps ? $user->corps->toArray() : 'No Corps',
            'corp_name' => optional($user->corps)->corp_name
        ]);


        if (!$user->corps || $user->corps->corp_name !== '太成HD') {
            abort(403, 'Unauthorized access.');
        }



        return $next($request);
    }
}
