function initMap() {
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(-6.29188445866056,106.794714778662),
    mapTypeId: google.maps.MapTypeId.TERRAIN,
    styles: [
        {
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

  var bounds = new google.maps.LatLngBounds();
  var polygons = [];
  var arr = new Array();
  var mapPolygon = new google.maps.Map(document.getElementById('map'), mapOptions);

  for (var i in coordinates) {
    arr = [];
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
  mapPolygon.fitBounds(bounds);

  var marker = new google.maps.Marker({
    map: mapPolygon,
    anchorPoint: new google.maps.Point(0, -29),
    draggable:true
  });
}

function SearchMyCoverage(){
  document.getElementById('coverage_coverage_wrapper').style.visibility = "hidden";
  document.getElementById('coverage_coverage_wrapper').style.opacity = "0";
  document.getElementById('coverage_coverage_wrapper').style.transition = "visibility 0s 1s, opacity 1s linear";
  setTimeout(function() {
      window.location.href = "/coverage/my-coverage";
  }, 1000);
}

google.maps.event.addDomListener(window, 'load', initMap);