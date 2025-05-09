<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;
class RateLimit
{
    /**
    * Handle an incoming request.
    *
    * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
    */

    public function handle(Request $request, Closure $next)
    {
        Log::info('Request from IP: ' . $request->ip());
        $key = $this->resolveRequestSignature($request);
        $maxAttempts = 15; // Cambio il numero di tentativi consentiti
        $decaySeconds = 60; // 1 minuto di finestra temporale 

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            Log::info('Rate limit exceeded for IP: ' . $request->ip());
            abort(429); // Mostro la pagina di errore Laravel 429
        }
    
        RateLimiter::hit($key, $decaySeconds);
        return $next($request); 
        return response()->json(['message' => 'Request OK']);
    }
    private function resolveRequestSignature(Request $request)
    {
        if ($user = $request->user()) {
            return Str::lower($user->email);
        }
        return $request->ip();
    }
}