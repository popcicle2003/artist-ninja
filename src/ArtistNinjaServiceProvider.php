<?php

namespace ArtistNinja;

use Illuminate\Support\ServiceProvider;

class ArtistNinjaServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/artist-ninja.php', 'artist-ninja');
        $this->app->singleton(InvoiceNinjaClient::class);
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__ . '/../config/artist-ninja.php' => config_path('artist-ninja.php'),
        ], 'artist-ninja-config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'artist-ninja-migrations');

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'artist-ninja');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}
