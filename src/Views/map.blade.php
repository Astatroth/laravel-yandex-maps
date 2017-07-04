<link rel="stylesheet" href="{{ asset('vendor/yandex-maps/css/yamaps.css') }}">

<div id="map" style="width: {{ $width }}; height: {{ $height }};"></div>

@if ($edit)
<input type="hidden" name="yandex-map-placemarks">
<input type="hidden" name="yandex-map-lines">
<input type="hidden" name="yandex-map-polygons">
<input type="hidden" name="yandex-map-routes">
<input type="hidden" name="yandex-map-coordinates">
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