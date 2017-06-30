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

By default the package goes with one default map. To render it add following code to your view:
```php
{!! Maps::get('default')->render() !!}
```

The `get()` method accepts the map title or the map ID.
The `render()` methods accepts following arguments:

- `bool $edit` - indicates if the map is being rendering for editing. Default `false`.
- `string $width` - width of the map container. Default '400px'.
- `string $height` - height of the map container. Default '400px'.
- `string $type` - ** not used at this time **. Default `null`.
- `bool|integer $controls` - indicates if the map controls should be displayed. Default `1`.
- `bool|integer $traffic` - indicates if the traffic information should be displayed on the map. Default `0`.

All arguments are optional.

Additionally you may want to set the map zoom and/or language:

```php
{!! Maps::get('default')->zoom(10)->language('en')->render() !!}
```
> **Note:** The default language is Russian.

#### Managing your maps

##### Adding new maps

###### Via `yamaps.php` configuration file

To add a new map just add it to the configuration, below the default map:

```php
'new_map' => [
            'title' => 'New map',
            'coordinates' => [
                ..., ...
            ],
            'zoom' => 12,
            'type' => 'map',
            'behaviors' => ['scrollZoom', 'dblClickZoom', 'drag'],
            'display-type' => 'map',
            'controls' => 1,
            'traffic' => 0,
            'placemarks' => [
                [...],
                [...]
            ],
            'lines' => '',
            'polygons' => '',
            'routes' => '',
        ]
```

Render your new map:

```php
{!! Maps::get('new_map')->render() !!}
```

###### Via the package interface

##### Editing maps

##### Deleting maps

#### Localization
