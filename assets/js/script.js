// BASEMAPS
var osm = L.tileLayer("https://tile.openstreetmap.org/{z}/{x}/{y}.png", {
  maxZoom: 19,
});
var map = new L.map("map", {
  zoomControl: false,
});
var osmUrl = "http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png";
var osmAttrib = "&copy; " + new Date().getFullYear();
var osm = new L.TileLayer(osmUrl, {
  minZoom: 0,
  maxZoom: 18,
  attribution: osmAttrib,
});

map.addLayer(osm);
map.setView(new L.LatLng(-1.9757525034617567, 113.5960392604668), 8);

var osm2 = new L.TileLayer(osmUrl, {
  minZoom: 0,
  maxZoom: 13,
  attribution: osmAttrib,
});

var miniMap = new L.Control.MiniMap(osm2, {
  toggleDisplay: true,
  zoomControl: false,
}).addTo(map);

var gsm = L.tileLayer("http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}", {
  maxZoom: 20,
  subdomains: ["mt0", "mt1", "mt2", "mt3"],
});

var gsat = L.tileLayer("http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}", {
  maxZoom: 20,
  subdomains: ["mt0", "mt1", "mt2", "mt3"],
});

var mapbox = L.tileLayer(
  "https://api.tiles.mapbox.com/styles/v1/{username}/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
  {
    attribution: "&copy;815101546",
    username: "iamtekson",
    id: "cjwhym7s70tae1co8zf17a3r5",
    accessToken:
      "pk.eyJ1IjoiaWFtdGVrc29uIiwiYSI6ImNqdjV4YzI4YjB0aXk0ZHBtNnVnNWxlM20ifQ.FjQJyCTodXASYtOK8IrLQA",
  }
);

map.attributionControl.setPrefix("Bekantan");

L.control
  .scale({
    imperial: false,
    position: "bottomright",
  })
  .addTo(map);

// var loader = L.control.loader().addTo(map);
// setTimeout(function() {
//     loader.hide();
// }, 5000);
// END BASEMAPS

// -------------------------------------------------------------- //

// LAYER GROUP
// data
var dataILOK = L.geoJson(ilok_KALTENG);
var dataIUP = L.geoJson(iup_KALTENG);
var dataARL = L.geoJson(peta_ARL);
// var dataDIV = L.geoJson(peta_DIV);
// var dataEST = L.geoJson(peta_EST);
// var dataIZN = L.geoJson(peta_IZN);
// var dataKWS = L.geoJson(peta_KWS);
// var dataRKT = L.geoJson(peta_RKT);
var dataTNM = L.geoJson(peta_TNM);

var baseMaps = {
  OpenStreetMap: osm,
  "Google Maps": gsm,
  "Google Satellite": gsat,
  Mapbox: mapbox,
};

var overlayMaps = {
  Kategori: {
    "ILOK Kalteng": dataILOK,
    "IUP Kalteng": dataIUP,
  },
  Jenis: {
    AREAL: dataARL,
    // "DIVISI": dataDIV,
    // "ESTATE": dataEST,
    // "IZIN": dataIZN,
    // "KAWASAN": dataKWS,
    // "RKT": dataRKT,
    TANAM: dataTNM,
  },
};

L.control.groupedLayers(baseMaps, overlayMaps).addTo(map);
// END LAYER GROUP

// -------------------------------------------------------------- //

// SEARCH
L.Control.Search = L.Control.extend({
  options: {
    position: "topleft",
  },
  onAdd: function () {
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

var gabungGIS = dataILOK
  .getLayers()
  .concat(dataIUP.getLayers())
  .concat(dataTNM.getLayers());
// console.log(gabungGIS)

new Autocomplete("local", {
  onSearch: ({ currentValue }) => {
    const result = [];
    gabungGIS.map((layer) => {
      const feature = layer.feature;
      if (
        (feature &&
          feature.properties.Name_Obj &&
          feature.properties.Name_Obj.match(new RegExp(currentValue, "gi"))) ||
        (feature.properties.nop &&
          feature.properties.nop.match(new RegExp(currentValue, "gi")))
      ) {
        result.push(feature);
      }
    });
    console.log("Hasil Pencarian:", result);
    return Promise.resolve(result);
  },

  onResults: ({ matches, template, currentValue }) => {
    return matches === 0
      ? template
      : matches
          .map((el) => {
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

            const statusText = hasTanamProperties
              ? "TANAM"
              : el.properties.Luas_Ha !== undefined
              ? "IUP"
              : "<span>ILOK</span>";

            return `<li class="flex">
                <div class="name">${tampilJenis}</div>
                <div class="kanan">
                <span style="${
                  el.properties.Luas_Ha !== undefined
                    ? "font-weight: bolder; color: black;"
                    : "font-weight: bolder;"
                }">${statusText}</span
                </div>
                </li>`;
          })
          .join("");
  },

  onSubmit: ({ object }) => {
    const tampilGIS = L.geoJSON(object, {
      style: function (feature) {
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
      onEachFeature: function (feature, layer) {
        const luasHa = feature.properties.Luas_Ha || "N/A";
        const nameObj = feature.properties.Name_Obj || "N/A";
        const detilnop = feature.properties.nop || "N/A";
        const detilUraian = feature.properties.uraian || "N/A";

        let popupContent =
          "<table class='table table-striped table-bordered '>" +
          "<tr><th colspan='2' style='background-color: #000033; color: white;'><center>DETAIL DATA</center></th></tr>";

        if (nameObj !== "N/A") {
          popupContent += "<tr><th>Nama</th><td>" + nameObj + "</td></tr>";
        } else {
          popupContent +=
            "<tr><th>NOP</th><td>" +
            detilnop +
            "</td></tr>" +
            "<tr><th>Uraian</th><td>" +
            detilUraian +
            "</td></tr>";
        }

        popupContent +=
          "<tr><th>Luas Ha</th><td>" + luasHa + "</td></tr>" + "</table>";

        layer.bindPopup(popupContent);
      },
    });

    tampilGIS.addTo(map);
    map.fitBounds(tampilGIS.getBounds(), {
      padding: [300, 300],
    });
  },

  noResults: ({ currentValue, template }) =>
    template(`<li class="kosong">Tidak ditemukan: "${currentValue}"</li>`),

  onReset: () => {
    map.eachLayer(function (layer) {
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
    position: "topleft",
  })
  .addTo(map);
// END FULLSCREEN

// -------------------------------------------------------------- //

// ZOOM BAR
var zoom_bar = new L.Control.ZoomBar({
  position: "topleft",
}).addTo(map);
// END ZOOM BAR

// -------------------------------------------------------------- //

// COORDINATES
L.control
  .coordinates({
    position: "bottomleft",
    decimals: 5,
    decimalSeperator: ".",
    labelTemplateLat: "Latitude: {y}",
    labelTemplateLng: "Longitude: {x}",
  })
  .addTo(map);
// END COORDINATES
