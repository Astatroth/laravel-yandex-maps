<?php

namespace Astatroth\LaravelYandexMaps;

use Astatroth\LaravelYandexMaps\Models\Map;
use Config;

class YandexMaps
{
    protected $options;

    protected $map;

    protected $zoom;

    protected $language = 'ru';

    public function create($title, array $options = [])
    {
        $map = new Map;

        $map->title = $title ?: null;

        if (empty($options)) {
            $options = Config::get('yamaps.maps.default');
        }

        $this->options = $options;

        $map->type = $this->extractOption('display-type');
        $map->coordinates = $this->extractOption('coordinates');
        $map->zoom = $this->extractOption('zoom');
        $map->placemarks = $this->extractOption('placemarks');
        $map->lines = $this->extractOption('lines');
        $map->polygons = $this->extractOption('polygons');
        $map->routes = $this->extractOption('routes');

        $map->save();

        return $map;
    }

    public function update($mapId, $title = null, array $options = [])
    {
        $map = Map::findOrFail($mapId);

        $map->title = $title ?: null;

        if (empty($options)) {
            $options = Config::get('yamaps.maps.default');
        }

        $this->options = $options;

        $map->type = $this->extractOption('display-type');
        $map->coordinates = $this->extractOption('coordinates');
        $map->zoom = $this->extractOption('zoom');
        $map->placemarks = $this->extractOption('placemarks');
        $map->lines = $this->extractOption('lines');
        $map->polygons = $this->extractOption('polygons');
        $map->routes = $this->extractOption('routes');

        $map->save();

        return $map;
    }

    public function remove($mapId)
    {
        $map = is_numeric($mapId) ? Map::find($mapId) : Map::where('title', $mapId)->first();

        if ($map) {
            $map->delete();
        }
    }

    public function get($mapId)
    {
        $this->map = $this->load($mapId);

        return $this;
    }

    public function language($language)
    {
        $this->language = $language;

        return $this;
    }

    public function render(
        $edit = false,
        $width = 400,
        $height = 400,
        $type = null,
        $controls = 1,
        $traffic = 0
    )
    {
        $mapOptions = [
            'init' => array(
                'center' => $this->map->coordinates,
                'zoom' => $this->zoom ?: $this->map->zoom,
                'type' => 'yandex#'.$this->map->type,
                'behaviors' => ['scrollZoom', 'dblClickZoom', 'drag'],
            ),
            'display_options' => [
                'display_type' => $type ?: $this->map->type,
            ],
            'controls' => $controls,
            'traffic' => $traffic,
            'placemarks' => [
                [
                    'coords' => [
                        41.324603453913, 69.228509909668
                    ],
                    'params' => [
                        'color' => 'blue',
                        'iconContent' => 'Mark 1',
                        'baloonContentBody' => '',
                        'baloonContentHeader' => 'Mark 1'
                    ]
                ],
                [
                    'coords' => [
                        41.353583534722, 69.310564047852
                    ],
                    'params' => [
                        'color' => 'blue',
                        'iconContent' => 'Mark 2',
                        'baloonContentBody' => '',
                        'baloonContentHeader' => 'Mark 2'
                    ]
                ]
            ],
            'lines' => $this->map->lines,
            'polygons' => $this->map->polygons,
            'routes' => $this->map->routes,
            'edit' => $edit,
            'language' => [
                'url' => '/vendor/yandex-maps/js/'.$this->language.'.json'
            ]
        ];

        return view()->make('yandex-maps::map')->with([
            'edit' => $edit,
            'options' => json_encode($mapOptions),
            'width' => $width,
            'height' => $height
        ]);
    }

    /*public function show($mapId, $edit = true, $zoom = null, $type = null, $controls = 1, $traffic = 0)
    {


        if (!$map) {
            return null;
        }

        $mapOptions = [
            'init' => array(
                'center' => $map->coordinates,
                'zoom' => $zoom ?: $map->zoom,
                'type' => 'yandex#'.$map->type,
                'behaviors' => ['scrollZoom', 'dblClickZoom', 'drag'],
            ),
            'display_options' => [
                'display_type' => $type ?: $map->type,
            ],
            'controls' => $controls,
            'traffic' => $traffic,
            'placemarks' => [
                [
                    'coords' => [
                        41.324603453913, 69.228509909668
                    ],
                    'params' => [
                        'color' => 'blue',
                        'iconContent' => 'Mark 1',
                        'baloonContentBody' => '',
                        'baloonContentHeader' => 'Mark 1'
                    ]
                ],
                [
                    'coords' => [
                        41.353583534722, 69.310564047852
                    ],
                    'params' => [
                        'color' => 'blue',
                        'iconContent' => 'Mark 2',
                        'baloonContentBody' => '',
                        'baloonContentHeader' => 'Mark 2'
                    ]
                ]
            ],
            'lines' => $map->lines,
            'polygons' => $map->polygons,
            'routes' => $map->routes,
            'edit' => $edit,
            'language' => [
                'url' => '/vendor/yandex-maps/js/ru.json'
            ]
        ];

        return view()->make('yandex-maps::map')->with([
            'edit' => $edit,
            'options' => json_encode($mapOptions),
        ]);
    }*/

    protected function load($mapId)
    {
        $map = is_numeric($mapId) ? Map::find($mapId) : Map::where('title', $mapId)->first();

        if ($map) {
            return $map;
        }

        if (Config::has('yamaps.maps.'.$mapId)) {
            return new Map(Config::get('yamaps.maps.'.$mapId));
        }

        throw new YandexMapsException();
    }

    protected function extractOption($key)
    {
        if (!is_array($this->options) || empty($this->options)) {
            return null;
        }

        if (!isset($this->options[$key])) {
            return null;
        }

        return $this->options[$key] ?: null;
    }
}