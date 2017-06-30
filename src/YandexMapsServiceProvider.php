<?php

namespace Astatroth\LaravelYandexMaps;

use Illuminate\Support\ServiceProvider;

class YandexMapsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(YandexMaps::class, function () {
            return new YandexMaps;
        });

        $this->app->alias(YandexMaps::class, 'yandex-maps');
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('yamaps.php'),
        ]);

        $this->publishes([
            __DIR__.'/Database/Migrations' => database_path('migrations')
        ]);

        $this->publishes([
            __DIR__.'/../public/' => public_path('vendor/yandex-maps')
        ], 'yamaps');

        $this->loadViewsFrom(__DIR__.'/Views', 'yandex-maps');
    }
}