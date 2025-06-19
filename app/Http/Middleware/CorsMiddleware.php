<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as BaseResponse;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): BaseResponse
    {
        // Handle preflight OPTIONS requests
        if ($request->getMethod() === 'OPTIONS') {
            $response = response('', 200);
            $this->addCorsHeaders($response, $request, true);
            return $response;
        }

        $response = $next($request);
        $this->addCorsHeaders($response, $request, false);
        
        return $response;
    }

    /**
     * Add CORS headers to response.
     */
    private function addCorsHeaders($response, Request $request, bool $isPreflight = false): void
    {
        $headers = [
            'Access-Control-Allow-Origin' => $this->getAllowedOrigin($request),
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Accept, Authorization, Content-Type, X-Requested-With, X-CSRF-TOKEN, X-XSRF-TOKEN, Origin, Cache-Control, Pragma',
            'Access-Control-Allow-Credentials' => 'true',
            'Vary' => 'Origin',
        ];

        if ($isPreflight) {
            $headers['Access-Control-Max-Age'] = '3600';
        } else {
            $headers['Access-Control-Expose-Headers'] = 'Cache-Control, Content-Language, Content-Type, Expires, Last-Modified, Pragma';
            $headers['Cache-Control'] = 'no-cache, private';
            $headers['X-Content-Type-Options'] = 'nosniff';
            $headers['X-Frame-Options'] = 'DENY';
            $headers['X-XSS-Protection'] = '1; mode=block';
        }

        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }
    }

    /**
     * Get the allowed origin for the request.
     */
    private function getAllowedOrigin(Request $request): string
    {
        $origin = $request->header('Origin');
        
        $allowedOrigins = [
            'https://howlson.onrender.com',
            'http://localhost:5173',
            'http://127.0.0.1:5173',
            'http://localhost:3000',
            'http://127.0.0.1:3000',
        ];

        if (in_array($origin, $allowedOrigins)) {
            return $origin;
        }

        // Check patterns
        if ($origin && (
            str_contains($origin, '.ngrok.io') ||
            str_contains($origin, '.ngrok-free.app') ||
            str_contains($origin, '.onrender.com') ||
            preg_match('/^https?:\/\/(localhost|127\.0\.0\.1):\d+$/', $origin)
        )) {
            return $origin;
        }

        return $allowedOrigins[0]; // Default fallback
    }
}