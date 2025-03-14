<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;



class LogCustomRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    
    {
        // Elenco delle rotte da loggare
        $routesToLog = [
            'route-name-1',
            'route-name-2',
            'route-name-3',
        ];

        if (in_array($request->route()->getName(), $routesToLog)) {
            Log::channel('custom_routes')->info('Azione su rotta sensibile');
        }

        return $next($request);
    }
}
