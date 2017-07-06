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

    protected $fillable = [
        'title', 'type', 'coordinates', 'placemarks', 'lines', 'polygons', 'routes'
    ];

    protected $primaryKey = 'map_id';

    protected $table = 'yamaps';
}