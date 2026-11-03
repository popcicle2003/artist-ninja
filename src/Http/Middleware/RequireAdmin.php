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
        $configuredKey = (string) config('artist-ninja.admin_key');
        $providedKey = (string) ($request->query('key') ?: $request->bearerToken());

        if ($configuredKey !== '' && $providedKey !== '' && hash_equals($configuredKey, $providedKey)) {
            $request->session()->put('artist_ninja_admin', true);

            return $next($request);
        }

        if ($request->session()->get('artist_ninja_admin') === true) {
            return $next($request);
        }

        $authenticated = Auth::guard('user')->check()
            || Auth::guard('web')->check()
            || Auth::check();

        if (! $authenticated) {
            abort(403, 'Artist Ninja admin access requires an authenticated Invoice Ninja session or admin key.');
        }

        return $next($request);
    }
}
