<link rel="stylesheet" href="{{ asset('vendor/yandex-maps/css/yamaps.css') }}">

<div id="map" style="width: {{ $width }}; height: {{ $height }};"></div>

@if ($edit)
<input type="hidden" name="yandex-map-placemarks" value="{{ $placemarks }}">
<input type="hidden" name="yandex-map-lines" value="{{ $lines }}">
<input type="hidden" name="yandex-map-polygons" value="{{ $polygons }}">
<input type="hidden" name="yandex-map-routes" value="{{ $routes }}">
<input type="hidden" name="yandex-map-coords">
@endif

<script src="{{ Config::get('yamaps.api-url') }}?lang={{ Config::get('yamaps.api-language') }}&load=package.full"></script>
<script src="{{ asset('vendor/yandex-maps/js/yamaps.min.js') }}"></script>

<script>
    var options = {!! $options !!};

    ymaps.ready(function () {
        var map = new YandexMap(options);

        map.initLayouts();
        map.showMap('map');
    });
</script>