<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CacheControl
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
        // Ignore if admin
        foreach (['_admin', 'nova-api'] as $ignorePath) {
            if (preg_match('/^'.$ignorePath.'/i', $request->path())) {
                return $next($request);
            }
        }

        $response = $next($request);
        $response->header('cache-control', 'public, max-age=900');
        return $response;
    }
}
