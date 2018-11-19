//GOOGLE MAP

var streetmap;
var kotamap;
var kecamatanmap;
var kelurahanmap;
var kodeposmap;

var latitude;
var longitude;

var map, infowindow, infowindowContent, marker, geocoder, placeSearchService, autocomplete;

//pass gmap value to form
function funcforward(){
    // coveragelocator.css("display","none");
    buttonforward.css("display","inline");

    youhavebeen.css("display","none");

    street.css("display","none");
    subdistrict.css("display","none");
    district.css("display","none");
    city.css("display","none");

    $("#coverage-form-only").css("display","inline");
    $("#buttonsendrequest").css("display","inline");

    show('popup2');

    // input address info
    document.getElementById("street_input").value = streetmap;
    document.getElementById("city_input").value = kotamap;
    document.getElementById("district_input").value = kecamatanmap;
    document.getElementById("subdistrict_input").value = kelurahanmap;
    document.getElementById("postalcode_input").value = kodeposmap;
    document.getElementById("latitude_input").value = latitude;
    document.getElementById("longitude_input").value = longitude;
}

function InfoWindow(componentSelector) {
    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById(componentSelector);
    infowindow.setContent(infowindowContent);
    infowindow.close();

    return [infowindow,infowindowContent];
}

function Marker(){
    var markerOptions = {
        map: map,
        anchorPoint: new google.maps.Point(0, -29),
        draggable:true
    };
    var marker = new google.maps.Marker(markerOptions);
    marker.setVisible(false);

    google.maps.event.addListener(marker, 'dragend', function (event) {
        //Get Current Lat Long
        var currentPos = this.getPosition();

        //Geocode and save selected position, then show InfoWindow If Success
        var latlng = {
            lat: currentPos.lat(),
            lng: currentPos.lng()
        };
        GeocodeAndSetInfo(latlng);
    });

    return marker;
}

function GeocodeAndSetInfo(latlng) {
    geocoder.geocode({'location': latlng}, function(results, status) {
        if (status === 'OK') {
            if (results[0]) {
                var adressComponents = results[0].address_components;

                //Get Street
                var route = adressComponents.filter(function(address_component){
                    return address_component.types.includes("route");
                });
                streetmap = route.length ? route[0].long_name: "";

                //Get City
                var adminlv2 = adressComponents.filter( function(address_component){
                    return address_component.types.includes("administrative_area_level_2");
                });
                kotamap = adminlv2.length ? adminlv2[0].long_name: "";

                //GetPostalCode
                var pcd = adressComponents.filter(function(address_component){
                    return address_component.types.includes("postal_code");
                });
                kodeposmap = pcd.length ? pcd[0].long_name: "";

                //Get Kecamatan
                var adminlv3 = adressComponents.filter(function(address_component){
                    return address_component.types.includes("administrative_area_level_3");
                });
                kecamatanmap = adminlv3.length ? adminlv3[0].long_name: "";

                //Get Kelurahan
                var adminlv4 = adressComponents.filter(function(address_component){
                    return address_component.types.includes("administrative_area_level_4");
                });
                kelurahanmap = adminlv4.length ? adminlv4[0].long_name: "";

                latitude = latlng.lat;
                longitude = latlng.lng;

                var formatedAddress = results[0].formatted_address;
                infowindowContent.children['place-address'].textContent = formatedAddress;
                infowindowContent.children['place-name'].textContent = formatedAddress.substr(0, formatedAddress.indexOf(','));
                infowindowContent.children['Lat-Long'].textContent = latlng.lat+","+latlng.lng;

                infowindow.open(map, marker);
            }
        }
    });
}

//OLD, DON'T USE!
function AutoComplete(componentSelector) {
    // var input = document.getElementById(componentSelector);
    var input = document.getElementById(componentSelector);
    var autocomplete = new google.maps.places.Autocomplete(input);
    autocomplete.setFields(
        ['address_components', 'geometry', 'icon', 'name']
    );
    autocomplete.setComponentRestrictions(
        {'country': ['id']}
    );
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function() {
        infowindow.close();
        marker.setVisible(false);

        var place = autocomplete.getPlace();

        // User entered the name of a Place that was not suggested and
        // pressed the Enter key, or the Place Details request failed.
        if (!place.geometry) {
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }
        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(20);
        }

        //set marker position and show
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        //Geocode and save selected position, then show InfoWindow If Success
        var latlng = {
            lat: place.geometry.location.lat(),
            lng: place.geometry.location.lng()
        };
        GeocodeAndSetInfo(latlng);
    });

    // google.maps.event.trigger(jqueryComponent,'focus',{});
    // jqueryComponent.focus();

    // var autocompleteHandler;
    // var jqueryComponentSelector = $("#"+componentSelector);
    // var shadowInput = $("#autocomplete-input");


    // shadowInput.keydown(function (event) {
    //     // console.log(event.keyCode);
    //     clearTimeout(autocompleteHandler);
    //     autocompleteHandler = setTimeout(function () {
    //         jqueryComponentSelector.val(shadowInput.val());
    //         google.maps.event.trigger(input,'focus',{});
    //         input.focus();
    //     },1250);
    // });
    // jqueryComponentSelector.keydown(function (event) {
    //     event.preventDefault();
    //     if(event.keyCode == 8){
    //         shadowInput.val(shadowInput.val().substr(0,shadowInput.val().length -1));
    //     }
    //     else if((event.keyCode == 32)||(event.keyCode >=65 && event.keyCode <=90) || (event.keyCode >=48 && event.keyCode <=57)){
    //         shadowInput.val(shadowInput.val()+String.fromCharCode(event.keyCode + (event.shiftKey ? 0 : 32)));
    //     }
    //     shadowInput.focus();
    // });

    return autocomplete;
}
function PLACEHOLDER() {
    $("#pac-input").on("input",function () {
        var minChar = 5;
        var currChar = $(this).val().length;

        var removalFlag = 0;
        if(minChar-currChar <=0){
            clearTimeout(inputHandler);
            if(removalFlag==0){
                if(autocomplete){
                    google.maps.event.clearInstanceListeners(autocomplete);
                }
                google.maps.event.clearInstanceListeners($(this)[0]);
                removalFlag = 1;
            }
            inputHandler = setTimeout(function () {
                autocomplete = AutoComplete( "pac-input");
                removalFlag = 0;
            },1250);
        }
        else{
            if(autocomplete){
                google.maps.event.clearInstanceListeners(autocomplete);
            }
            google.maps.event.clearInstanceListeners($(this)[0]);
            $(".pac-container").remove();
        }
    });
}
//

function AutoCompleteV2(inputSelector, suggestionContainerSelector, suggestionItemSelector) {
    var input = $(inputSelector);
    var suggestionContainer = $(suggestionContainerSelector);

    var inputHandler;
    input.on("input",function () {
        var minChar = 5;
        var inputValue =  $(this).val();
        var currChar = inputValue.length;

        if(minChar-currChar <=0) {
            clearTimeout(inputHandler);
            inputHandler = setTimeout(function () {
                autocomplete.getPlacePredictions(
                    {
                        input: inputValue,
                        componentRestrictions: {
                            country:'id'
                        }
                    },
                    function (predictions, status) {
                        if (status == google.maps.places.PlacesServiceStatus.OK) {
                            for (var i = 0; i < predictions.length; i++) {
                                suggestionContainer.append('<div class="suggestion-item col-md-12" data-placeid="' + predictions[i].place_id + '">' + predictions[i].description + '</div>');
                            }
                        }
                        else{
                            alert(status);
                        }
                    }
                );
            }, 450);
        }
        suggestionContainer.empty();
    });

    suggestionContainer.on("click",suggestionItemSelector,function () {
        //clear the map
        infowindow.close();
        marker.setVisible(false);
        suggestionContainer.empty();

        var place_id = $(this).data('placeid');
        placeSearchService.getDetails(
            {
                placeId: place_id,
                fields:['geometry']
            },
            function (place, status) {
                if (status == google.maps.places.PlacesServiceStatus.OK) {
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(20);
                    }

                    //set marker position and show
                    marker.setPosition(place.geometry.location);
                    marker.setVisible(true);

                    //Geocode and save selected position, then show InfoWindow If Success
                    var latlng = {
                        lat: place.geometry.location.lat(),
                        lng: place.geometry.location.lng()
                    };
                    GeocodeAndSetInfo(latlng);
                }
                else{
                    alert(status);
                }
            }
        );
    });
}

function initMap() {
    //Instantiate a Gmap
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
    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    //Instantiate InfoWindow Component (Popup when clicking a point in Gmap)
    var infowindowData = InfoWindow('infowindow-content');
    infowindow = infowindowData[0];
    infowindowContent = infowindowData[1];

    //Instantiate a Marker Component (Pin in Map)
    marker = Marker();

    //Instantiate Geocoder Component
    geocoder = new google.maps.Geocoder();

    //Instantiate Required Services
    placeSearchService = new google.maps.places.PlacesService(map);
    autocomplete = new google.maps.places.AutocompleteService();

    //Initalize AutoComplete component
    AutoCompleteV2('#pac-input','#gmap-suggestions','.suggestion-item');
}

google.maps.event.addDomListener(window, 'load', initMap);