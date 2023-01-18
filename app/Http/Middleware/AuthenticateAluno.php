<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateAluno
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
        if (Auth::guard('api')->user()->tipo_user_id != 2) {
            $json = [
                'success' => false,
                'data' => null,
                'error' => [
                    'code' => 401,
                    'message' => 'Usuário não tem permissão'
                ]
            ];
            return response()->json($json, 401);
        }

        return $next($request);
    }
}
