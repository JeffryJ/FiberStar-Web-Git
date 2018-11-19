/*DATA*/
var allData = [
    {'title': 'Cirebon','lat': -6.711253,'lng': 108.560772,'pass_through_type': 'Terrestrial'},
    {'title': 'Semarang','lat': -6.987972,'lng': 110.420282,'pass_through_type': 'Submarine'},
    {'title': 'Surabaya','lat': -7.243481,'lng': 112.737709,'pass_through_type': 'Hybrid'},
]
var geocoder;
var lat = "0";
var lng = "0";

function errorFunction(){
    alert("Geocoder failed");
}

function initialize() {
	geocoder = new google.maps.Geocoder();
    // google.maps.event.addDomListener(window, 'load', initAutocomplete);
}

function codeLatLng(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
      	if (status == google.maps.GeocoderStatus.OK) {
	      	console.log(results)
	        if (results[1]) {
		        //find country name
		            for (var i=0; i<results[0].address_components.length; i++) {
		            for (var b=0; b<results[0].address_components[i].types.length; b++) {

		            //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
		                if (results[0].address_components[i].types[b] == "administrative_area_level_2") {
		                    //this is the object you are looking for
		                    city= results[0].address_components[i];
		                    break;
		                }
		            }
		        }
		        //city data
                var string = "Your City is ";
                var messaging = "";

                function cityExists(title) {
                    return allData.some(function(el) {
                        // return el.title === title;
                        return title.toLowerCase().search(el.title.toLowerCase()) > -1 ||  el.title.toLowerCase().search(title.toLowerCase()) > -1;
                    }); 
                }

                if (cityExists(city.short_name) == true) {
                    messaging = "Your city has been covered. If you want to contact us, please press ok button. Otherwise, please press x button in the top-right of this message.";
                }else{
                    messaging = "Your city still under maintainance or not yet covered. Please contact us for any submission data. ";
                }

                r = string + city.short_name + "." + '\n' + messaging;
                document.getElementById("alertmessagespopup").innerHTML = r; 
                document.getElementById("Trial").style.display = "block";  
	        }
            else{
	          	//find country name
                    for (var i=0; i<results[0].address_components.length; i++) {
                    for (var b=0; b<results[0].address_components[i].types.length; b++) {

                    //there are different types that might hold a city admin_area_lvl_1 usually does in come cases looking for sublocality type will be more appropriate
                        if (results[0].address_components[i].types[b] == "administrative_area_level_1") {
                            //this is the object you are looking for
                            city = results[0].address_components[i];
                            break;
                        }
                    }
                }

                //city data
                var string = "Your City is ";
                var messaging = "";

                function cityExists(title) {
                    return allData.some(function(el) {
                        // return el.title === title;
                        return title.toLowerCase().search(el.title.toLowerCase()) > -1 ||  el.title.toLowerCase().search(title.toLowerCase()) > -1;
                    }); 
                }

                if (cityExists(city.short_name) == true) {
                    messaging = "Your city has been covered. If you want to contact us, please press ok button. Otherwise, please press x button in the top-right of this message.";
                }else{
                    messaging = "Your city still under maintainance or not yet covered. Please contact us for any submission data. ";
                }

                r = string + city.short_name + "." + '\n' + messaging;
                document.getElementById("alertmessagespopup").innerHTML = r; 
                document.getElementById("Trial").style.display = "block";
	        }
            /*else
            {
                var string = "The City is not Exist. Please re-Type the Address.";
                r = string;
                document.getElementById("alertmessagespopup").innerHTML = r; 
                document.getElementById("Trial").style.display = "block";
            } */
      	} 	
      	else {
        	alert("Geocoder failed due to: " + status);
      	}
    });
}

 

$(document).ready(function () {

    initialize();

    $("#searchBox").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "http://dev.virtualearth.net/REST/v1/Locations",
                dataType: "jsonp",
                data: {
                    key: "Ap-MQcoO6xNAmfRd_eOmIbn1zo67gZwlD7gt757uL9S6v2DtRalxoUgxTt79QRdJ",
                    q: (request.term + "Indonesia")
                },
        		
                jsonp: "jsonp",

                success: function (data) {
                    var result = data.resourceSets[0];
                    if (result) {
                        if (result.estimatedTotal > 0) {
                            response($.map(result.resources, function (item) {
                                return {
                                    data: item,
                                    label: item.name + ' (' + item.address.countryRegion + ')',
                                    value: item.name
                                }
                            }));
                        }
                    }
                },
            });
        },
        minLength: 1,
        change: function (event, ui) {
            if (!ui.item)
                $("#searchBox").val('');
        },
        select: function (event, ui) {
            displaySelectedItem(ui.item.data);
        }
    });
});

function displaySelectedItem(item) {
    $("#searchResult").empty().append('Data Result: ' + item.name).append(' (Latitude: ' + item.point.coordinates[0] + ' Longitude: ' + item.point.coordinates[1]  + ')');
    
    latss = item.point.coordinates[0];
    longss = item.point.coordinates[1];
	codeLatLng(latss, longss)
}

var map, searchManager;
function GetMap() {
    var infoboxLayer = new Microsoft.Maps.EntityCollection();
    var pinLayer = new Microsoft.Maps.EntityCollection();
    var apiKey = "Ap-MQcoO6xNAmfRd_eOmIbn1zo67gZwlD7gt757uL9S6v2DtRalxoUgxTt79QRdJ";
    
    map = new Microsoft.Maps.Map('#myMap', {
        mapTypeId: Microsoft.Maps.MapTypeId.grayscale,
        supportedMapTypes: [Microsoft.Maps.MapTypeId.road, Microsoft.Maps.MapTypeId.aerial, Microsoft.Maps.MapTypeId.grayscale]
    });
    map = map;
    //Load the Bing Spatial Data Services and Search modules, then create an instance of the search manager.
    Microsoft.Maps.loadModule(['Microsoft.Maps.SpatialDataService',
    'Microsoft.Maps.Search'], function () {
        searchManager = new Microsoft.Maps.Search.SearchManager(map);
    });
    map = map;
    pinInfobox = new Microsoft.Maps.Infobox(new Microsoft.Maps.Location(0, 0), { visible: false });
    infoboxLayer.push(pinInfobox);



    /*PUSHPIN*/
    var locs = [];
    for (var i = 0; i < allData.length; i++) {
        locs[i] = new Microsoft.Maps.Location(allData[i].lat, allData[i].lng);
        if (allData[i].pass_through_type == "Submarine") {
            var pin = new Microsoft.Maps.Pushpin(locs[i], {
                icon: 'img/beachflagblue.png',
                anchor: new Microsoft.Maps.Point(12, 39)
            });
            pin.Title = allData[i].title;
            pinLayer.push(pin); 
            Microsoft.Maps.Events.addHandler(pin, 'click', displayInfobox);
        }else if (allData[i].pass_through_type == "Terrestrial") {
            var pin = new Microsoft.Maps.Pushpin(locs[i], {
                icon: 'img/beachflagpink.png',
                anchor: new Microsoft.Maps.Point(12, 39)
            });
            pin.Title = allData[i].title;
            pinLayer.push(pin); 
            Microsoft.Maps.Events.addHandler(pin, 'click', displayInfobox);
        }else if (allData[i].pass_through_type == "Hybrid") {
            var pin = new Microsoft.Maps.Pushpin(locs[i], {
                icon: 'img/beachflaghalf.png',
                anchor: new Microsoft.Maps.Point(12, 39)
            });
            pin.Title = allData[i].title;
            pinLayer.push(pin); 
            Microsoft.Maps.Events.addHandler(pin, 'click', displayInfobox);
        }
    }
    






    //Load the Bing Spatial Data Services and Search modules, then create an instance of the search manager.
    Microsoft.Maps.loadModule(['Microsoft.Maps.SpatialDataService',
    'Microsoft.Maps.Search'], function () {
        searchManager = new Microsoft.Maps.Search.SearchManager(map);
    });

    map.entities.push(pinLayer);
    map.entities.push(infoboxLayer);

    var bestview = Microsoft.Maps.LocationRect.fromLocations(locs);
    map.setView({ center: bestview.center, zoom: 5.3});
    map.setOptions({
        maxZoom: 10,
    });
}
function Search() {
    //Create the geocode request.
    var geocodeRequest = {
        where: document.getElementById('searchBox').value,
        callback: getBoundary,
        errorCallback: function (e) {
        }
    };
    //Make the geocode request.
    searchManager.geocode(geocodeRequest);
}
function getBoundary(geocodeResult){
    //Add the first result to the map and zoom into it.
    if (geocodeResult && geocodeResult.results && geocodeResult.results.length > 0) {
        //Zoom into the location.
        map.setView({ bounds: geocodeResult.results[0].bestView });
        //Create the request options for the GeoData API.
        var geoDataRequestOptions = {
            lod: 1,
            getAllPolygons: true
        };
        //Verify that the geocoded location has a supported entity type.
        switch (geocodeResult.results[0].entityType) {
            case "CountryRegion":
            case "AdminDivision1":
            case "AdminDivision2":
            case "Postcode1":
            case "Postcode2":
            case "Postcode3":
            case "Postcode4":
            case "Neighborhood":
            case "PopulatedPlace":
                geoDataRequestOptions.entityType = geocodeResult.results[0].entityType;
                break;
            default:
                //Display a pushpin if GeoData API does not support EntityType.
                //var pin = new Microsoft.Maps.Pushpin(geocodeResult.results[0].location);
                //map.entities.push(pin);
                return;
        }
        //Use the GeoData API manager to get the boundaries of the zip codes.
        Microsoft.Maps.SpatialDataService.GeoDataAPIManager.getBoundary(
            geocodeResult.results[0].location,
            geoDataRequestOptions,
            map,
            function (data) {
                //Add the polygons to the map.
                if (data.results && data.results.length > 0) {
                    //map.entities.push(data.results[0].Polygons);
                } else {
                    //Display a pushpin if a boundary isn't found.
                    //var pin = new Microsoft.Maps.Pushpin(data.location);
                    //map.entities.push(pin);
                }
            }
        );
    }
}
function displayInfobox(e) {
    pinInfobox.setOptions({ title: e.target.Title, visible: true, offset: new Microsoft.Maps.Point(0, 25) });
    pinInfobox.setLocation(e.target.getLocation());
}

function hideInfobox(e) {
    pinInfobox.setOptions({ visible: false });
}

function exitbuttonpopup(){
    document.getElementById("Trial").style.display = "none";
    document.getElementById('searchBox').value = '';
}   

function exitpopup(){
    var elmnt = document.getElementById("coverage-bottomID");
    //elmnt.scrollIntoView();
    $('html, body').animate({
        scrollTop: $(elmnt).offset().top
    }, 1500);
    document.getElementById("Trial").style.display = "none";
    document.getElementById('searchBox').value = '';
}