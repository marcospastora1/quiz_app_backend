<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth;

class AuthenticateJWT
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('api')->user()) {
            $json = [
                'success' => false,
                'data' => null,
                'error' => [
                    'code' => 401,
                    'message' => 'Unauthorized'
                ]
            ];
            return response()->json($json, 401);
        }

        return $next($request);
    }
}
