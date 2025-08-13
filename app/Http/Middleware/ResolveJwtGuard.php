<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ResolveJwtGuard
{
    public function handle($request, Closure $next)
    {
        $guards = ['student_api', 'teacher_api'];

        foreach ($guards as $guard) {
            try {
                if ($user = Auth::guard($guard)->user()) {
                    Auth::shouldUse($guard);
                    break;
                }

                if ($user = JWTAuth::setToken($request->bearerToken())->parseToken()->authenticate()) {
                    Auth::shouldUse($guard);
                    break;
                }

            } catch (\Exception $e) {
            }
        }

        return $next($request);
    }
}
