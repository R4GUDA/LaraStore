<?php

namespace App\Http\Middleware;

use App\Http\Resources\Auth\UnauthorizedResource;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticateMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): \Symfony\Component\HttpFoundation\Response
    {
        if(!$request->bearerToken())
            return response(null, 401);

        $user = User::where('remember_token', $request->bearerToken())->first();

        if (!$user) {
            return response(null, 401);
        }

        Auth::login($user);

        return $next($request);
    }
}
