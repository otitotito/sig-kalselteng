<script src="<?= base_url(); ?>/data/ILOK_KALTENG.js"></script>
<script src="<?= base_url(); ?>/data/IUP_KALTENG.js"></script>
<!-- <script src="<?= base_url(); ?>/data/PETA_ARL.js"></script>
<script src="<?= base_url(); ?>/data/PETA_DIV.js"></script>
<script src="<?= base_url(); ?>/data/PETA_EST.js"></script>
<script src="<?= base_url(); ?>/data/PETA_IZN.js"></script>
<script src="<?= base_url(); ?>/data/PETA_KWS.js"></script>
<script src="<?= base_url(); ?>/data/PETA_RKT.js"></script> -->
<script src="<?= base_url(); ?>/data/PETA_TNM.js"></script>

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

    L.control
        .scale({
            imperial: false,
            position: 'bottomright'
        }).addTo(map);

    var osm2 = new L.TileLayer(osmUrl, {
        minZoom: 0,
        maxZoom: 13,
        attribution: osmAttrib
    });

    var miniMap = new L.Control.MiniMap(osm2, {
        toggleDisplay: true,
        zoomControl: false,
    }).addTo(map);

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
    var dataILOK = L.geoJson(ilok_KALTENG);
    var dataIUP = L.geoJson(iup_KALTENG);
    // var dataARL = L.geoJson(peta_ARL);
    // var dataDIV = L.geoJson(peta_DIV);
    // var dataEST = L.geoJson(peta_EST);
    // var dataIZN = L.geoJson(peta_IZN);
    // var dataKWS = L.geoJson(peta_KWS);
    // var dataRKT = L.geoJson(peta_RKT);
    var dataTNM = L.geoJson(peta_TNM);

    // var baseMaps = {
    //     title: 'Others Base Layers',
    //     "OpenStreetMap": osm,
    //     "Google Maps": gsm,
    //     "Google Satellite": gsat,
    //     "Mapbox": mapbox,
    // }


    var conf = {
        base: {
            title: 'Basemaps',
            layers: [{
                group: "Road Layers",
                collapsed: true,
                layers: [{
                        name: "&nbsp;Open Street Map",
                        active: true,
                        layer: osm
                    },
                    {
                        name: "&nbsp;Google Maps",
                        layer: gsm
                    },
                    {
                        name: "&nbsp;Google Satellite",
                        layer: gsat
                    },
                    {
                        name: "&nbsp;Mapbox",
                        layer: mapbox
                    },
                ]
            }]
        },
        tree: {
            title: "Kategori",
            layers: [{
                    active: false,
                    name: "IUP Kalteng&nbsp;",
                    layer: dataIUP
                },
                {
                    name: "ILOK Kalteng&nbsp;",
                    layer: dataILOK
                }
            ]
        },
        tree1: {
            title: "Jenis",
            layers: [{
                active: false,
                name: "Tanam&nbsp;",
                layer: L.geoJSON(peta_TNM, {
                    onEachFeature: function(feature, layer) {
                        layer.bindPopup("Ini adalah layer Tanam. Info Tambahan: " + feature.properties.nop);
                    }
                }),
            }],
        },
    };


    var base1 = L.control.panelLayers(conf.base.layers, null, {
        title: conf.base.title,
        position: 'topright',
        compact: true
    }).addTo(map);

    var over1 = L.control.panelLayers(null, conf.tree.layers, {
        title: conf.tree.title,
        position: 'topright',
        compact: true
    }).addTo(map);

    var over2 = L.control.panelLayers(null, conf.tree1.layers, {
        title: conf.tree1.title,
        position: 'topright',
        compact: true
    }).addTo(map);
    // END LAYER GROUP

    // -------------------------------------------------------------- //

    // SEARCH
    L.Control.Search = L.Control.extend({
        options: {
            position: "topleft",
        },
        onAdd: function() {
            const container = L.DomUtil.create("div", "autocomplete-container");
            L.DomEvent.disableClickPropagation(container);

            const innerHTML = `
            <div class="auto-search-wrapper max-height loupe" id="search">
                <input type="text" id="local" autocomplete="off" placeholder="Telusuri SIG" />
            </div>`;

            container.innerHTML = innerHTML;
            container.style.zIndex = 1000;

            return container;
        },
    });

    new L.Control.Search().addTo(map);

    var gabungGIS = dataILOK.getLayers().concat(dataIUP.getLayers()).concat(dataTNM.getLayers());
    console.log(gabungGIS)

    new Autocomplete("local", {
        onSearch: ({
            currentValue
        }) => {
            const result = [];
            gabungGIS.map(layer => {
                const feature = layer.feature;
                if (
                    feature &&
                    (feature.properties.Name_Obj && feature.properties.Name_Obj.match(new RegExp(currentValue, "gi"))) ||
                    (feature.properties.nop && feature.properties.nop.match(new RegExp(currentValue, "gi")))
                ) {
                    result.push(feature);
                }
            });
            console.log("Hasil Pencarian:", result);
            return Promise.resolve(result);
        },

        onResults: ({
            matches,
            template,
            currentValue
        }) => {
            return matches === 0 ?
                template :
                matches.map((el) => {
                    const tampilJenis = el.properties.nop || el.properties.Name_Obj;
                    // const titleText = el.properties.nop ? 'NOP' : 'Name_Obj';
                    const hasTanamProperties =
                        el.properties.nop ||
                        el.properties.kd_jns_arl ||
                        el.properties.no_urut ||
                        el.properties.th_tanam ||
                        el.properties.kd_jns_tnm ||
                        el.properties.luas_tnm ||
                        el.properties.uraian;

                    const statusText = hasTanamProperties ? 'TANAM' : (el.properties.Luas_Ha !== undefined ? 'IUP' : '<span>ILOK</span>');


                    return `<li class="flex">
                    <div class="name">${tampilJenis}</div>
                <div class="kanan">
                <span style="${el.properties.Luas_Ha !== undefined ? 'font-weight: bolder; color: black;' : 'font-weight: bolder;'}">${statusText}</span
                </div>
            </li>`;
                }).join("");
        },

        onSubmit: ({
            object
        }) => {
            const tampilGIS = L.geoJSON(object, {
                style: function(feature) {
                    const luasHa = feature.properties.Luas_Ha;

                    if (luasHa !== undefined) {
                        return {
                            color: "red",
                            weight: 7,
                            opacity: 1,
                            fillOpacity: 0.7,
                        };
                    } else {
                        return {
                            color: "blue",
                            weight: 7,
                            opacity: 1,
                            fillOpacity: 0.7,
                        };
                    }
                },
                onEachFeature: function(feature, layer) {
                    const luasHa = feature.properties.Luas_Ha || "N/A";
                    const nameObj = feature.properties.Name_Obj || "N/A";
                    const detilnop = feature.properties.nop || "N/A";
                    const detilUraian = feature.properties.uraian || "N/A";

                    let popupContent = "<table class='table table-striped table-bordered '>" +
                        "<tr><th colspan='2' style='background-color: #000033; color: white;'><center>DETAIL DATA</center></th></tr>";

                    if (nameObj !== "N/A") {
                        popupContent += "<tr><th>Nama</th><td>" + nameObj + "</td></tr>";
                    } else {
                        popupContent += "<tr><th>NOP</th><td>" + detilnop + "</td></tr>" +
                            "<tr><th>Uraian</th><td>" + detilUraian + "</td></tr>";
                    }

                    popupContent += "<tr><th>Luas Ha</th><td>" + luasHa + "</td></tr>" +
                        "</table>";

                    layer.bindPopup(popupContent);
                }
            });

            tampilGIS.addTo(map);
            map.fitBounds(tampilGIS.getBounds(), {
                padding: [300, 300]
            });
        },

        noResults: ({
                currentValue,
                template
            }) =>
            template(`<li class="kosong">Tidak ditemukan: "${currentValue}"</li>`),

        onReset: () => {
            map.eachLayer(function(layer) {
                if (!!layer.toGeoJSON) {
                    map.removeLayer(layer);
                }
            });
            // map.setView([-1.9757525034617567, 113.5960392604668], 8); 
            result = [];
        },
    });
    //END SEARCH

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
        labelTemplateLat: "Latitude: {y}",
        labelTemplateLng: "Longitude: {x}"
    }).addTo(map);
    // END COORDINATES
</script>

<script>
    if (!sessionStorage.getItem("hideModal")) {
        showMyModal();
    }

    function showMyModal() {
        setTimeout(function() {
            Swal.fire({
                title: "SIG v.1.1",
                showClass: {
                    popup: `animate__animated`
                },
                html: `
                    <p class="swal2-p">Apa yang baru?</p>
                    <p class="swal2-minip">${new Date().toLocaleString('default', { month: 'long' })}, ${new Date().getFullYear()}</p>
                    <ul class="swal2-ul">                
                        <li>Perbaikan fitur <span>Pencarian</span></li>
                        <li>Penambahan fitur <span>Fullscreen</span></li>
                        <li>Penambahan data jenis <span>TANAM</span></li>
                    </ul>
                `,
                icon: "warning",
                showCancelButton: true,
                showConfirmButton: false,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ok, lanjut",
                cancelButtonText: "Jangan tampilkan lagi",
                allowOutsideClick: true,
                width: 375,
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.cancel) {
                    sessionStorage.setItem("hideModal", "true");
                }
            });
        }, 1000);
    }
</script>



</body>

</html>