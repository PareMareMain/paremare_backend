<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Auth;
class Admin extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::guard('admin')->check())
        {
            return $next($request);
        }
        else {
            return redirect()->route('login');
        }
        // if (! $request->expectsJson()) {
        //     return route('login');
        // }
    }
}
