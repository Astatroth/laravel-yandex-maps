<?php

namespace Astatroth\LaravelYandexMaps;

use Exception;

class YandexMapsException extends Exception
{
    public function __construct()
    {
        parent::__construct('Map not found.');
    }
}