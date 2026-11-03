<?php

namespace ArtistNinja\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->guard('user')->check()) {
            return redirect('/');
        }

        return $next($request);
    }
}
