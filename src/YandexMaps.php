<?php

namespace Astatroth\LaravelYandexMaps;

use Astatroth\LaravelYandexMaps\Models\Map;
use Config;

class YandexMaps
{
    protected $center;

    protected $language = 'ru';

    protected $lines;

    protected $map;

    protected $placemarks;

    protected $polygons;

    protected $routes;

    protected $size;

    protected $title;

    protected $zoom;

    public function get($mapId)
    {
        $this->load($mapId);

        return $this;
    }

    public function render(
        $edit = false,
        $width = 200,
        $height = 200,
        $controls = 1,
        $traffic = 0
    )
    {
        $options = [
            'init' => array(
                'center' => $this->center ?: $this->map->coordinates->center,
                'zoom' => $this->zoom ?: $this->map->coordinates->zoom,
                'type' => 'yandex#'.$this->map->type,
                'behaviors' => ['scrollZoom', 'dblClickZoom', 'drag'],
            ),
            'display_options' => [
                'display_type' => 'map',
            ],
            'controls' => $controls,
            'traffic' => $traffic,
            'placemarks' => $this->placemarks ?: $this->map->placemarks,
            'lines' => $this->lines ?: $this->map->lines,
            'polygons' => $this->polygons ?: $this->map->polygons,
            'routes' => $this->routes ?: $this->map->routes,
            'edit' => $edit,
            'language' => [
                'url' => '/vendor/yandex-maps/js/'.$this->language.'.json'
            ]
        ];

        return view()
            ->make('yandex-maps::map')
            ->with([
                'title' => $this->title,
                'edit' => $edit,
                'options' => json_encode($options),
                'width' => isset($this->size['width']) ? $this->size['width'] : $width,
                'height' => isset($this->size['height']) ? $this->size['height'] : $height,
                'placemarks' => $this->placemarks ? json_encode($this->placemarks) : json_encode($this->map->placemarks),
                'lines' => $this->lines ? json_encode($this->lines) : json_encode($this->map->lines),
                'polygons' => $this->polygons ? json_encode($this->polygons) : json_encode($this->map->polygons),
                'routes' => $this->routes ? json_encode($this->routes) : json_encode($this->map->routes),
            ]);
    }

    public function center(array $coordinates, $zoom = null)
    {
        $this->center = json_encode($coordinates);

        if ($zoom) {
            $this->zoom = $zoom;
        }

        return $this;
    }

    public function language($language)
    {
        $this->language = $language;

        return $this;
    }

    public function lines(array $lines)
    {
        $this->lines = json_encode($lines);

        return $this;
    }

    public function placemarks(array $placemarks)
    {
        $this->placemarks = json_encode($placemarks);

        return $this;
    }

    public function polygons(array $polygons)
    {
        $this->polygons = json_encode($polygons);

        return $this;
    }

    public function routes(array $routes)
    {
        $this->routes = json_encode($routes);

        return $this;
    }

    public function size($width, $height)
    {
        $this->size = [
            'width' => $width,
            'height' => $height
        ];

        return $this;
    }

    public function title($title)
    {
        $this->title = $title;

        return $this;
    }

    public function zoom($zoom)
    {
        $this->zoom = $zoom;

        return $this;
    }

    protected function load($mapId)
    {
        $map = Map::where('title', $mapId)
            ->orWhere('map_id', $mapId)
            ->first();

        if (!$map) {
            $map = new Map;
            $map->setDefaultValues();
        }

        $this->map = $map;
    }
}