jQuery(document).ready(function() {
    $('.close').on('click', function(e) {
        e.preventDefault();
        $(this).parent().slideUp(300, function() {
            $(this).remove();
        });
    });

    if (document.getElementById('map')) {
        mapInit();
    }
});

function mapInit() {
    var map     = new OpenLayers.Map('map');
    var mapnik  = new OpenLayers.Layer.OSM();
    var markers = new OpenLayers.Layer.Markers('Markers');
    var zoom    = 17;
    var lonlat  = new OpenLayers.LonLat(venue_lon, venue_lat).transform(
        new OpenLayers.Projection('EPSG:4326'), // transform from WGS 1984
        new OpenLayers.Projection('EPSG:900913') // to Spherical Mercator
    );

    map.addLayer(mapnik);
    map.addLayer(markers);
    markers.addMarker(new OpenLayers.Marker(lonlat));
    map.setCenter(lonlat, zoom);
}
