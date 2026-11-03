<?php

use ArtistNinja\Http\Controllers\OnboardingController;
use ArtistNinja\Http\Controllers\PackageController;
use ArtistNinja\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;

Route::middleware(array_merge(config('artist-ninja.middleware', ['web']), ['domain_db', 'locale']))
    ->prefix(config('artist-ninja.route_prefix', 'artist-ninja'))
    ->as('artist-ninja.')
    ->group(function (): void {
        Route::get('/onboarding', [OnboardingController::class, 'show'])->name('onboarding');
        Route::post('/onboarding', [OnboardingController::class, 'store'])->name('onboarding.store');
        Route::get('/onboarding/thanks', [OnboardingController::class, 'thanks'])->name('onboarding.thanks');
    });

Route::middleware(['web', 'domain_db', 'locale', 'auth:web'])
    ->prefix(config('artist-ninja.route_prefix', 'artist-ninja') . '/admin')
    ->as('artist-ninja.admin.')
    ->group(function (): void {
        Route::resource('packages', PackageController::class)->except(['show']);
    });

Route::middleware(['auth:contact', 'locale', 'domain_db', 'check_client_existence'])
    ->prefix('client/artist-ninja')
    ->as('client.artist-ninja.')
    ->group(function (): void {
        Route::get('/', [PortalController::class, 'currentClient'])->name('portal');
    });
