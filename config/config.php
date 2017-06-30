<?php
return [

    /*
     * Yandex.Maps API url.
     */
    'api-url' => 'https://api-maps.yandex.ru/2.0',

    'static-api-url' => 'https://static-maps.yandex.ru/1.x/',

    'geocoder-url' => 'https://geocode-maps.yandex.ru/1.x/',

    'legal-agreement-url' => 'https://legal.yandex.ru/maps_api/',

    /**
     * Yandex.Map API language.
     */
    'api-language' => 'ru-RU',

    /**
     * Predefined maps array.
     */
    'maps' => [
        'default' => [
            'title' => 'Default map',
            'coordinates' => [
                41.330296995242, 69.279665
            ],
            'zoom' => 12,
            'type' => 'map',
            'behaviors' => array('scrollZoom', 'dblClickZoom', 'drag'),
            'display-type' => 'map',
            'controls' => 1,
            'traffic' => 0,
            'placemarks' => [
                [
                    'coordinates' => [
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
                    'coordinates' => [
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
        ]
    ]
];