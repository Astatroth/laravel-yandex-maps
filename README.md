# Laravel Yandex.Maps
Drupal "Yandex.Maps" module port for Laravel 5.

This package allows you to use Yandex.Maps in your project with following features:

- Display map (suddenly :)) with or without traffic jams
- Edit map - add placemarks, lines, polygons or routes

## Installation

Install the package via Composer: `composer require astatroth/laravel-yandex-maps`

Register the service provider in `config/app.php`:

```php
Astatroth\LaravelYandexMaps\YandexMapsServiceProvider::class,
```

Also you may add a facade if you wish:

```php
'Maps' => Astatroth\LaravelYandexMaps\Facades\YandexMapsFacade::class,
```

Next, publish the package assets:

``` php artisan vendor:publish --provider="Astatroth\LaravelYandexMaps\YandexMapsServiceProvider" ```

And that's it! Your're ready to go.

## Usage

#### Rendering a map

#### Managing your maps

##### Adding new maps

##### Editing maps

##### Deleting maps

#### Localization
