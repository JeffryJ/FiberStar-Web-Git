//UNCOVERED

var kotamap;
var kecamatanmap;
var kelurahanmap;
var kodeposmap;

function DrawAreaOutlines(mapPolygon, bounds) {
    var polygons = [];
    for (var i in coordinates) {
        var arr = [];
        for (var j = 0; j < coordinates[i].length; j++) {
            arr.push(new google.maps.LatLng(
                parseFloat(coordinates[i][j][0]),
                parseFloat(coordinates[i][j][1])
            ));

            bounds.extend(arr[arr.length - 1])
        }
        // Construct the polygon.
        polygons.push(new google.maps.Polygon({
            path: arr,
            strokeColor: '#ec6b29',
            strokeOpacity: 0.35,
            strokeWeight: 1,
            fillOpacity: 0.35,
            geodesic: true,
            fillColor: '#ec6b29',
        }));
        polygons[polygons.length - 1].setMap(mapPolygon);
    }
}

function InitAutoComplete(mapPolygon, selector) {
    var input = document.getElementById(selector);
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.setComponentRestrictions(
        {'country': ['id']}
    );
    autocomplete.bindTo('bounds', mapPolygon);

    //Triggers When Enter is pressed or an item from suggestion is selected.
    // autocomplete.addListener('place_changed',function () {
    //     console.log("halo");
    // });

    return autocomplete;
}

function InitInfoWindow(selector) {
    var infowindowContent = document.getElementById(selector);
    var infowindow = new google.maps.InfoWindow();
    infowindow.setContent(infowindowContent);
}

function initMap() {

    var mapOptions = {
        zoom: 10,
        center: new google.maps.LatLng(-6.29188445866056,106.794714778662),
        mapTypeId: google.maps.MapTypeId.TERRAIN,
        styles: [{
            "featureType": "all",
            "elementType": "labels.text.fill",
            "stylers": [{
                "saturation": 36
            },
                {
                    "color": "#333333"
                },
                {
                    "lightness": 40
                }
            ]
        },
            {
                "featureType": "all",
                "elementType": "labels.text.stroke",
                "stylers": [{
                    "visibility": "on"
                },
                    {
                        "color": "#ffffff"
                    },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "featureType": "all",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#fefefe"
                },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#fefefe"
                },
                    {
                        "lightness": 17
                    },
                    {
                        "weight": 1.2
                    }
                ]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f5f5"
                },
                    {
                        "lightness": 20
                    }
                ]
            },
            {
                "featureType": "poi",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f5f5f5"
                },
                    {
                        "lightness": 21
                    }
                ]
            },
            {
                "featureType": "poi.park",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#dedede"
                },
                    {
                        "lightness": 21
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#ffffff"
                },
                    {
                        "lightness": 17
                    }
                ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#ffffff"
                },
                    {
                        "lightness": 29
                    },
                    {
                        "weight": 0.2
                    }
                ]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffffff"
                },
                    {
                        "lightness": 18
                    }
                ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#ffffff"
                },
                    {
                        "lightness": 16
                    }
                ]
            },
            {
                "featureType": "transit",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#f2f2f2"
                },
                    {
                        "lightness": 19
                    }
                ]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#e9e9e9"
                },
                    {
                        "lightness": 17
                    }
                ]
            }
        ]
    };
    var mapPolygon = new google.maps.Map(document.getElementById('map'), mapOptions);
    var bounds = new google.maps.LatLngBounds();
    mapPolygon.fitBounds(bounds);

    DrawAreaOutlines(mapPolygon,bounds);

    var autocomplete = InitAutoComplete(mapPolygon,'pac-input');

    InitInfoWindow('infowindow-content');

    //Declare a Marker
    var marker = new google.maps.Marker({
        map: mapPolygon,
        anchorPoint: new google.maps.Point(0, -29),
        draggable:true
    });

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();

        mapPolygon.setCenter(place.geometry.location);
        mapPolygon.setZoom(20);
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        var geocoder = new google.maps.Geocoder();

        var input = place.geometry.location.lat()+","+place.geometry.location.lng();
        var latlngStr = input.split(',', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    // console.log(results[0]);
                    infowindowContent.children['place-address'].textContent = results[0].formatted_address;
                    addressFullyCatcher = results[0].formatted_address;

                    var adminlv2 = results[0].address_components.filter(function(address_component){
                        return address_component.types.includes("administrative_area_level_2");
                    });
                    kotamap = adminlv2.length ? adminlv2[0].long_name: "";

                    var pcd = results[0].address_components.filter(function(address_component){
                        return address_component.types.includes("postal_code");
                    });
                    kodeposmap = pcd.length ? pcd[0].long_name: "";

                    var adminlv3 = results[0].address_components.filter(function(address_component){
                        return address_component.types.includes("administrative_area_level_3");
                    });
                    kecamatanmap = adminlv3.length ? adminlv3[0].long_name: "";

                    var adminlv4 = results[0].address_components.filter(function(address_component){
                        return address_component.types.includes("administrative_area_level_4");
                    });
                    kelurahanmap = adminlv4.length ? adminlv4[0].long_name: "";
                } else {
                    window.alert('Cannot Find Your Address');
                }
            } else {
                window.alert('Your Search is too much for per 100 seconds. Please Wait.' +status);
            }
        });

        infowindowContent.children['Lat-Long'].textContent = place.geometry.location.lat()+","+place.geometry.location.lng();
        infowindowContent.children['place-name'].textContent = place.name;
        infowindow.open(mapPolygon, marker);
        placeNameCatcher = place.name;

        ////////DRAGABLE MARKER EVENT
        google.maps.event.addListener(marker, 'dragend', function (event) {
            infowindowContent.children['Lat-Long'].textContent = this.getPosition().lat()+","+this.getPosition().lng();

            input = this.getPosition().lat()+","+this.getPosition().lng();
            latlngStr = input.split(',', 2);
            latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
            geocoder.geocode({'location': latlng}, function(results, status) {
                if (status === 'OK') {
                    if (results[0]) {
                        var add = results[0].formatted_address;
                        infowindowContent.children['place-address'].textContent = add;
                        infowindowContent.children['place-name'].textContent = add.substr(0, add.indexOf(','));

                        placeNameCatcher = add.substr(0, add.indexOf(','));
                        addressFullyCatcher = add;

                    } else {
                        window.alert('Cannot Find Your Address');
                    }
                } else {
                    window.alert('Your Search is too much for per 100 seconds. Please Wait.');
                }
            });
            infowindow.open(mapPolygon, marker);
        });
    });
}

google.maps.event.addDomListener(window, 'load', initMap);