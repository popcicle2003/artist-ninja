<?php

namespace ArtistNinja\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RequireAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $authenticated = Auth::guard('user')->check()
            || Auth::guard('web')->check()
            || Auth::check();

        if (! $authenticated) {
            return redirect('/');
        }

        return $next($request);
    }
}
