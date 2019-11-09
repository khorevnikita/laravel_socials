<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $api_token = $request->header('authorization');
        if ($api_token) {
            $user = User::where("api_token", $api_token)->first();
            Auth::login($user);
        }
        return $next($request);
    }
}
