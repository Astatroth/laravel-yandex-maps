<?php

namespace Astatroth\LaravelYandexMaps\Models;

use Illuminate\Database\Eloquent\Model;

class Map extends Model
{
    /*protected $casts = [
        'coordinates' => 'array',
        'placemarks' => 'array',
        'lines' => 'array',
        'polygons' => 'array',
        'routes' => 'array'
    ];*/

    protected $defaults = [
        'title' => 'Default map',
        'init' => [
            'center' => [
                41.330296995242, 69.279665
            ],
            'zoom' => 12,
        ],
        'display_options' => [
            'display_type' => 'map',
        ],
        'controls' => 1,
        'traffic' => 0,
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
        'lines' => '',
        'polygons' => '',
        'routes' => '',
        'edit' => true,
    ];

    protected $fillable = [
        'title', 'type', 'coordinates', 'placemarks', 'lines', 'polygons', 'routes'
    ];

    protected $primaryKey = 'map_id';

    protected $table = 'yamaps';

    public function setDefaultValues()
    {
        $default = json_decode(json_encode($this->defaults));

        $this->title = $default->title;
        $this->type = 'map';
        $this->coordinates = $default->init;
        $this->placemarks = $default->placemarks;
        $this->lines = $default->lines;
        $this->polygons = $default->polygons;
        $this->routes = $default->routes;
    }
}