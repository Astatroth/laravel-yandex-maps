<?php

namespace Astatroth\LaravelYandexMaps;

use Astatroth\LaravelYandexMaps\Models\Map;
use Config;

class YandexMaps
{
    /**
     * @var array
     */
    protected $options;

    /**
     * @var \Astatroth\LaravelYandexMaps\Models\Map
     */
    protected $map;

    /**
     * @var integer
     */
    protected $zoom;

    /**
     * @var string
     */
    protected $language = 'ru';

    /**
     * Creates and saves a new map.
     *
     * @param string        $title
     * @param array         $options
     *
     * @return \Astatroth\LaravelYandexMaps\Models\Map
     */
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

    /**
     * Updates the given map.
     *
     * @param integer|string        $mapId
     * @param null                  $title
     * @param array                 $options
     *
     * @return mixed
     */
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

    /**
     * Deletes the given map.
     *
     * @param integer|string     $mapId
     */
    public function remove($mapId)
    {
        $map = is_numeric($mapId) ? Map::find($mapId) : Map::where('title', $mapId)->first();

        if ($map) {
            $map->delete();
        }
    }

    /**
     * Loads the given map.
     *
     * @param integer|string     $mapId
     *
     * @return $this
     * @throws \Astatroth\LaravelYandexMaps\YandexMapsException
     */
    public function get($mapId)
    {
        $this->map = $this->load($mapId);

        return $this;
    }

    /**
     * Adds a localization option to the map before rendering.
     *
     * @param string     $language
     *
     * @return $this
     */
    public function language($language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Renders the map.
     *
     * @param bool $edit
     * @param int  $width
     * @param int  $height
     * @param null $type
     * @param int  $controls
     * @param int  $traffic
     *
     * @return $this
     */
    public function render(
        $edit = false,
        $width = '400px',
        $height = '400px',
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

    /**
     * Loads the map.
     *
     * @param integer|string $mapId
     *
     * @return \Astatroth\LaravelYandexMaps\Models\Map
     * @throws \Astatroth\LaravelYandexMaps\YandexMapsException
     */
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

    /**
     * Extracts an option from the options array.
     *
     * @param string     $key
     *
     * @return string|array|null
     */
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