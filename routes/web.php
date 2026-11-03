<?php

use ArtistNinja\Http\Controllers\OnboardingController;
use ArtistNinja\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::middleware(config('artist-ninja.middleware', ['web']))
    ->prefix(config('artist-ninja.route_prefix', 'artist-ninja'))
    ->as('artist-ninja.')
    ->group(function (): void {
        Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding');
        Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
        Route::get('/onboarding/thanks', [OnboardingController::class, 'thanks'])->name('onboarding.thanks');
    });

Route::middleware(['auth:contact', 'locale', 'domain_db', 'check_client_existence'])
    ->prefix('client/artist-ninja')
    ->as('client.artist-ninja.')
    ->group(function (): void {
        Route::get('/', [PortalController::class, 'currentClient'])->name('portal');
    });
