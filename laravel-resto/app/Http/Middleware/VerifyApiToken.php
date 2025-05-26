<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if request has Authorization header
        if (!$request->bearerToken()) {
            return response()->json([
                'message' => 'API token not provided'
            ], 401);
        }

        // The actual token verification is handled by Sanctum
        // This middleware just ensures the token is present

        return $next($request);
    }
}
