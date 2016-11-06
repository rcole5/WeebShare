<?php

namespace App\Http\Middleware;

use Closure;

class IsUploader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int $pid
     * @return mixed
     */
    public function handle($request, Closure $next, $pid)
    {
        return $next($request);
    }
}
