<div id="map"></div>

@if ($edit)
<input type="hidden" name="placemarks">
<input type="hidden" name="lines">
<input type="hidden" name="polygons">
<input type="hidden" name="routes">
<input type="hidden" name="coordinates">
@endif

<!-- TODO убрать jQuery -->
<script src="{{ asset('js/jquery.2.1.4.min.js') }}"></script>
<script src="{{ Config::get('yamaps.api-url') }}?lang={{ Config::get('yamaps.api-language') }}&load=package.full"></script>
<script src="{{ asset('vendor/yandex-maps/js/yamaps.js') }}"></script>

<script>
    var options = {!! $options !!};

    ymaps.ready(function () {
        var map = new YandexMap(options);

        map.initLayouts();
        map.showMap('map');
    });
</script>