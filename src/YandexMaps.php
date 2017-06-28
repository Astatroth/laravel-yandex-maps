<?php

namespace Astatroth\LaravelYandexMaps;

use Astatroth\LaravelYandexMaps\Models\Map;
use Config;

class YandexMaps
{
    protected $options;

    public function create($title, array $options = [])
    {
        $map = new Map;

        $map->title = $title ?: null;

        if (empty($options)) {
            $options = Config::get('yamaps.defaults');
        }

        $this->options = $options;

        $map->type = $this->extractOption('display-type');
        $map->coordinates = $this->extractOption('center');
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
            $options = Config::get('yamaps.defaults');
        }

        $this->options = $options;

        $map->type = $this->extractOption('display-type');
        $map->coordinates = $this->extractOption('center');
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

    public function show($mapId, $edit = false, $zoom = null, $type = null, $controls = 1, $traffic = 0)
    {
        $map = is_numeric($mapId) ? Map::find($mapId) : Map::where('title', $mapId)->first();

        if (!$map) {
            if (Config::has('yamaps.maps.'.$mapId)) {
                $map = Config::get('yamaps.maps.'.$mapId);
            }
        }

        if (!$map) {
            return null;
        }

        $mapOptions = [
            'init' => array(
                'center' => $map->coordinates,
                'zoom' => $zoom ?: $map->zoom,
                'type' => $map->type,
                'behaviors' => ['scrollZoom', 'dblClickZoom', 'drag'],
            ),
            'display_options' => [
                'display_type' => $type ?: $map->type,
            ],
            'controls' => $controls,
            'traffic' => $traffic,
            'placemarks' => $map->placemarks,
            'lines' => $map->lines,
            'polygons' => $map->polygons,
            'routes' => $map->routes,
            'edit' => $edit,
            'locale' => \App::getLocale()
        ];

        return view()->make('yamaps::map')->with([
            'edit' => $edit,
            'options' => json_encode($mapOptions)
        ]);
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