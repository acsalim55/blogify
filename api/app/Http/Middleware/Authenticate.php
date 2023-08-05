<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return "/api/error";
        }
    }

    /*
    public function handle($request, Closure $next, ...$guards)
    {
        //fix headers
        $request->headers->set('Accept', 'application/json','Authorization');
        return $next($request);
    }*/
}
