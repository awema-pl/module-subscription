<?php

namespace AwemaPL\Subscription\Sections\Installations\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;
use AwemaPL\Subscription\Facades\Subscription;

class GlobalMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
