<?php

namespace Astatroth\LaravelYandexMaps\Facades;

use Illuminate\Support\Facades\Facade;

class YandexMapsFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'yandex-maps';
    }
}