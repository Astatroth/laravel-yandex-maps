<?php

namespace Astatroth\LaravelYandexMaps\Facades;

use Illuminate\Support\Facades\Facade;

class YandexMapsFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'yandex-maps';
    }
}