<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;



class LogCustomRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    
    {
        // Elenco delle rotte da loggare
        $routesToLog = [
            'homepage',
            'careers',
            'careers.submit',
            'articles.create',
            'articles.store',
            'writer.dashboard',
            'articles.edit',
            'articles.update',
            'articles.destroy',
            'admin.dashboard',
            'admin.setAdmin',
            'admin.setRevisor',
            'admin.setWriter',
            'admin.editTag',
            'admin.deleteTag',
            'admin.editCategory',
            'admin.deleteCategory',
            'admin.storeCategory',
            'admin.storeTag'

        ];

        if (in_array($request->route()->getName(), $routesToLog)) {
            Log::channel('custom_routes')->info('Azione su rotta sensibile');
        }

        return $next($request);
    }
}
