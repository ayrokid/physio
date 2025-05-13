<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header('token');
        $validKey = env('ACCESS_KEY');

        // Validasi token
        if (!$token || $token !== $validKey) {
            return response()->json(['message' => 'Unauthorized - Invalid Token Access Key'], 401);
        }

        // Validasi Whitelist IP
        // $allowedIps = explode(',', env('WHITELIST_IPS', '127.0.0.1')); // default ke localhost
        // $clientIp = $request->ip();

        // if (!in_array($clientIp, $allowedIps)) {
        //     return response()->json(['message' => 'Unauthorized - IP not allowed'], 403);
        // }

        return $next($request);
    }
}
