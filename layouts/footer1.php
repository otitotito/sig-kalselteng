<script src="<?= base_url(); ?>/assets/js/jquery.js"></script>

<script>
    // BASEMAPS
    var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
        maxZoom: 19,
    });
    var map = new L.map('map', {
        zoomControl: false,
    });
    var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
    var osmAttrib = '&copy; <?php echo date('Y'); ?>';
    var osm = new L.TileLayer(osmUrl, {
        minZoom: 0,
        maxZoom: 18,
        attribution: osmAttrib,
    });

    map.addLayer(osm);
    map.setView(new L.LatLng(-1.9757525034617567, 113.5960392604668), 8);

    var gsm = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    var gsat = L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    var mapbox = L.tileLayer(
        "https://api.tiles.mapbox.com/styles/v1/{username}/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}", {
            attribution: "&copy;815101546",
            username: "iamtekson",
            id: "cjwhym7s70tae1co8zf17a3r5",
            accessToken: "pk.eyJ1IjoiaWFtdGVrc29uIiwiYSI6ImNqdjV4YzI4YjB0aXk0ZHBtNnVnNWxlM20ifQ.FjQJyCTodXASYtOK8IrLQA",
        });

    map.attributionControl.setPrefix('Bekantan');
    // END BASEMAPS

    // -------------------------------------------------------------- //

    // LAYER GROUP
    // data
    var wfs_ILOK = 'http://10.29.254.234/geoserver/sipeta/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=sipeta%3AILOK_KALTENG&maxFeatures=50&outputFormat=application%2Fjson';
    var wfs_IUP = 'http://10.29.254.234/geoserver/sipeta/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=sipeta%3AIUP_KALTENG&maxFeatures=50&outputFormat=application%2Fjson';
    var wfs_ARL = 'http://10.29.254.234/geoserver/wfs?service=wfs&version=2.0.0&request=GetFeature&typeNames=merge:Peta_ARL&outputFormat=application/json';
    var wfs_DIV = 'http://10.29.254.234/geoserver/wfs?service=wfs&version=2.0.0&request=GetFeature&typeNames=merge:Peta_DIV&outputFormat=application/json';
    // var wfs_EST = 'http://localhost/geoserver/merge/ows?service=WFS&version=1.0.0&request=GetFeature&typeName=merge%3APeta_EST&maxFeatures=50&outputFormat=application%2Fjson';
    var wfs_TNM = 'http://10.29.254.234/geoserver/wfs?service=wfs&version=2.0.0&request=GetFeature&typeNames=merge:Peta_TNM&outputFormat=application/json';

    // $.getJSON(wfs_TNM)
    //     .then((res) => {
    //         console.log(res);
    //     })
    //     .fail((jqXHR, textStatus, errorThrown) => {
    //         console.error("Error:", textStatus, errorThrown);
    //     });

    if (window.jQuery) {
        var baseMaps = {
            "&nbsp;OpenStreetMap": osm,
            "&nbsp;Satellite": gsm,
            "&nbsp;Mapbox": mapbox
        };

        var overlayMaps = {};

        $.when(
            $.getJSON(wfs_ARL),
            $.getJSON(wfs_TNM)
        ).then((res1, res2) => { //res = result

            var geojsonLayer1 = L.geoJson(res1[0], {
                onEachFeature: function(feature, layer) {
                    layer.bindPopup("<table class='table table-striped table-bordered table-condensed'>" +
                        "<tr><th colspan='2' style='background-color: #000033; color: white;'><center>DETAIL DATA</center></th></tr>" +
                        "</table>");
                },
                style: function(feature) {
                    return {

                    };
                }
            });

            var geojsonLayer2 = L.geoJson(res2[0], {
                onEachFeature: function(feature, layer) {
                    layer.bindPopup("<table class='table table-striped table-bordered table-condensed'>" +
                        "<tr><th colspan='2' style='background-color: #000033; color: white;'><center>DETAIL DATA</center></th></tr>" +
                        "</table>");
                },
                style: function(feature) {
                    return {

                    };
                }
            });
            overlayMaps["&nbsp;ARL"] = geojsonLayer1;
            overlayMaps["&nbsp;TNM"] = geojsonLayer2;

            // Tambahkan layer ke peta
            L.control.layers(baseMaps, overlayMaps).addTo(map);

            var allGeoJsonLayers = L.layerGroup([geojsonLayer1, geojsonLayer2]);
        });

    };
    // END LAYER GROUP

    // -------------------------------------------------------------- //


    // FULLSCREEN
    L.control
        .fullscreen({
            position: 'topleft',
        })
        .addTo(map);
    // END FULLSCREEN

    // -------------------------------------------------------------- //

    // ZOOM BAR
    var zoom_bar = new L.Control.ZoomBar({
        position: 'topleft'
    }).addTo(map);
    // END ZOOM BAR

    // -------------------------------------------------------------- //

    // COORDINATES
    L.control.coordinates({
        position: "bottomleft",
        decimals: 5,
        decimalSeperator: ".",
        labelTemplateLng: "Longitude: {x}"
    }).addTo(map);
    // END COORDINATES
</script>



</body>

</html>