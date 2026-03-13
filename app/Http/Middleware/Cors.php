<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = config('cors.allowed_origins', ['*']);
        $origin = $request->header('Origin');

        // Check if origin is allowed
        $isAllowed = in_array('*', $allowedOrigins) || in_array($origin, $allowedOrigins);

        if ($request->getMethod() == "OPTIONS") {
            $headers = [
                'Access-Control-Allow-Methods' => 'GET, POST, PUT, PATCH, DELETE, OPTIONS',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization, X-Requested-With',
                'Access-Control-Max-Age' => '86400',
            ];

            if ($isAllowed) {
                $headers['Access-Control-Allow-Origin'] = $origin ?: '*';
                if (config('cors.supports_credentials', false)) {
                    $headers['Access-Control-Allow-Credentials'] = 'true';
                }
            }

            return response()->json([], 200, $headers);
        }

        $response = $next($request);

        if ($isAllowed) {
            $response->header('Access-Control-Allow-Origin', $origin ?: '*');
            if (config('cors.supports_credentials', false)) {
                $response->header('Access-Control-Allow-Credentials', 'true');
            }
        }

        return $response
            ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');
    }
}
