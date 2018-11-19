<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Places Search Box</title>
    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 100%;
        }
        /* Optional: Makes the sample page fill the window. */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        #description {
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
        }

        #infowindow-content .title {
            font-weight: bold;
        }

        #infowindow-content {
            display: none;
        }

        #map #infowindow-content {
            display: inline;
        }

        .pac-card {
            margin: 10px 10px 0 0;
            border-radius: 2px 0 0 2px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            outline: none;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            background-color: #fff;
            font-family: Roboto;
        }

        #pac-container {
            padding-bottom: 12px;
            margin-right: 12px;
        }

        .pac-controls {
            display: inline-block;
            padding: 5px 11px;
        }

        .pac-controls label {
            font-family: Roboto;
            font-size: 13px;
            font-weight: 300;
        }

        #pac-input {
            background-color: #fff;
            font-family: Roboto;
            font-size: 15px;
            font-weight: 300;
            margin-left: 12px;
            padding: 0 11px 0 13px;
            text-overflow: ellipsis;
            width: 400px;
        }

        #pac-input:focus {
            border-color: #4d90fe;
        }

        #title {
            color: #fff;
            background-color: #4d90fe;
            font-size: 25px;
            font-weight: 500;
            padding: 6px 12px;
        }
        #target {
            width: 345px;
        }
    </style>
</head>



<body>
<input id="pac-input" class="controls" type="text" placeholder="Search Box">
<div id="map"></div>
<script>

    var beaches = [
        ['Cirebon',-6.711253,108.560772],['Semarang',-6.987972,110.420282,4],['Surabaya',-7.243481,112.737709,5],['Jember',-8.166496,113.701395,6],['Denpasar',-8.649791,115.21855,7],['Makasar',-5.132524,119.404356,8],['Balikpapan',-1.234697,116.858603,9],['Palembang',-2.985417,104.754771,10],['Bangka Utara',-1.874294,105.92299,11],['Bangka Selatan',-2.313024,106.109964,12],['Pekanbaru',0.531735,101.447988,13],['Bintan',1.04832,104.558698,14],['Batam',1.109346,104.036538,15],['Dumai',1.666736,101.447856,16],['Asahan',2.817472,99.634135,17],['Medan',3.592715,98.674858,18],['Tangerang',-6.171137,106.639267,19],['Karawang',-6.300828,107.305321,21],['Depok',-6.404898,106.81469,22],['Bogor',-6.594217,106.797879,23],['Sukabumi',-6.915723,106.92525,24],['Cianjur',-7.357977,107.19572,25],['Purwakarta',-6.557383,107.442974,26],['Cimahi',-6.870391,107.540826,27],['Sumedang',-6.856757,107.919869,28],['Majalengka',-6.833577,108.223722,29],['Indramayu',-6.323008,108.324976,30],['Brebes',-6.867664,109.037311,31],['Garut',-7.213168,107.901316,32],['Tasikmalaya',-7.350581,108.217163,33],['Ciamis',-7.332077,108.349254,34],['Banjar Patroman',-7.370687,108.534249,35],['Wanareja',-7.307627,108.676945,36],['Cilacap',-7.727117,109.009552,37],['Tegal',-6.866029,109.138929,38],['Purwokerto',-7.424278,109.239637,39],['Purbalingga',-7.385822,109.361132,40],['Banjarnegara',-7.394195,109.693201,41],['Wonosobo',-7.357221,109.905631,42],['Pemalang',-6.885389,109.381375,43],['Pekalongan',-6.889836,109.674592,44],['Kendal',-6.919472,110.204323,45],['Ungaran',-7.12869,110.404141,46],['Salatiga',-7.328278,110.501988,47],['Temanggung',-7.314998,110.176502,48],['Magelang',-7.473315,110.218743,49],['Yogyakarta',-7.79726,110.365341,50],['Boyolali',-7.526681,110.597192,51],['Klaten',-7.702348,110.602262,52],['Demak',-6.892546,110.637952,53],['Kudus',-6.81551,110.838116,54],['Pati',-6.751758,111.039631,55],['Rembang',-6.704604,111.348223,56],['Blora',-6.967866,111.414522,57],['Cepu',-7.137207,111.593052,58],['Bojonegoro',-7.317463,111.761466,59],['Lamongan',-7.108111,112.410237,60],['Gresik',-7.154921,112.654612,61],['Solo',-7.564875,110.824708,62],['Sragen',-7.424634,111.025202,63],['Ngawi',-7.396238,111.446895,64],['Madiun',-7.62579,111.523373,65],['Saradan',-7.501379,111.737618,66],['Nganjuk',-7.600949,111.90034,67],['Jombang',-7.535265,112.237503,68],['Mojokerto',-7.460379,112.429404,69],['Kediri',-7.808145,112.004378,70],['Blitar',-8.096142,112.165725,71],['Kepanjen',-8.128772,112.568098,72],['Malang',-7.97376,112.634019,73],['Pasuruan',-7.639402,112.907987,74],['Probolinggo',-7.741812,113.216289,75],['Lumajang',-8.133769,113.223098,76],['Pasirian',-8.238326,113.120332,77],['Jember',-8.167584,113.700477,78],['Banyuwangi',-8.207954,114.370202,79],['Negara',-8.357101,114.621503,80],['Tabanan',-8.534573,115.125936,81]
    ];
    var beaches2 = [
        ['Jakarta',-6.165942,106.823292,1],['Bandung',-6.931401,107.602975,2]
    ];
    var beaches3 = [
        ['Bekasi',-6.232573,106.995278,20],
    ];

    function setMarkers(map) {
        var image = {
            url: 'img/beachflagpink.png',
            size: new google.maps.Size(20, 32),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 32)
        };
        var image2 = {
            url: 'img/beachflagblue.png',
            size: new google.maps.Size(20, 32),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 32)
        };
        var image3 = {
            url: 'img/beachflaghalf.png',
            size: new google.maps.Size(20, 32),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(0, 32)
        };
        var shape = {
            coords: [1, 1, 1, 20, 18, 20, 18, 1],
            type: 'poly'
        };
        for (var i = 0; i < beaches.length; i++) {
            var beach = beaches[i];
            var marker = new google.maps.Marker({
                position: {lat: beach[1], lng: beach[2]},
                map: map,
                icon: image,
                shape: shape,
                title: beach[0],
                zIndex: beach[3]
            });
        }
        for (var i = 0; i < beaches2.length; i++) {
            var beach = beaches2[i];
            var marker = new google.maps.Marker({
                position: {lat: beach[1], lng: beach[2]},
                map: map,
                icon: image2,
                shape: shape,
                title: beach[0],
                zIndex: beach[3]
            });
        }
        for (var i = 0; i < beaches3.length; i++) {
            var beach = beaches3[i];
            var marker = new google.maps.Marker({
                position: {lat: beach[1], lng: beach[2]},
                map: map,
                icon: image3,
                shape: shape,
                title: beach[0],
                zIndex: beach[3]
            });
        }
    }
    // This example adds a search box to a map, using the Google Place Autocomplete
    // feature. People can enter geographical searches. The search box will return a
    // pick list containing a mix of places and predicted search terms.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    function initAutocomplete() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -2.6000285, lng: 118.015776},
            zoom:5.2,
            mapTypeId: 'roadmap',
            maxZoom:10,
        });
        setMarkers(map);

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
        var searchBox = new google.maps.places.SearchBox(input);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
        });

        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCdn15b7WoF0TkikSMqrFMYZLGgQGWU4o4&libraries=places&callback=initAutocomplete"
        async defer></script>
</body>
</html>