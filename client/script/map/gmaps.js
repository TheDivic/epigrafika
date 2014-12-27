//Strings to be localized
var errorInGeoRequestString = "Error while processing geo request!";
var locationNotFoundString = "Location not found!";

//Map settings
var canvasId = "#map-canvas";
var googleApiKey = "AIzaSyBArTJ-mPtJuBsGghbM2LHu-FAJpehXJLg";

//Global vars
var map;
var radiusCircle;
var markers = new Array();

//Register map init. on page load
google.maps.event.addDomListener(window,'load', mapInit);

function mapInit()
{
	var mapOptions = { center: { lat: 0, lng: 0 }, zoom: 8 };
	var canvas = $(canvasId)[0];
	map = new google.maps.Map(canvas, mapOptions);
    mapGoToLocation("Beograd");
}

function mapGoToLocation(location)
{
    jQuery.ajax({
        type: "GET",
		async: true,
        url: "https://maps.googleapis.com/maps/api/geocode/json",
        data: {address: location, key: googleApiKey},
		dataType: "json",
        success:function(data,statusText,jqxhr){
            if(data.status == 'OK')
            {
                //found at least one geo location

                var lat = data.results[0].geometry.location.lat;
                var lng = data.results[0].geometry.location.lng;
				
				mapClearAllMarkers();
                mapGoToCoordinates(lat,lng);
                mapPlaceMarker(lat,lng);
            }
            else
            {
                window.alert(locationNotFoundString);
            }
        },
        error:function(jqxhr,statusText){
            console.log(statusText);
            window.alert(errorInGeoRequestString);
        }

    });
}

function mapGoToCoordinates(lat, lng)
{
    map.panTo({ lat: lat, lng: lng });
}

function mapPlaceMarker(lat, lng)
{
    var markerOptions = {
        //animation: google.maps.Animation.DROP,
        position: {lat: lat,lng: lng},
        map: map
    };
    var marker = new google.maps.Marker(markerOptions);
    markers.push(marker);
}

function mapClearAllMarkers()
{
    for(var i = 0; i < markers.length; i++)
    {
        markers[i].setMap(null);
        markers[i] = null;
    }
    markers = [];
}

function mapDrawRadiusCircle(center, radius)
{
	if(radiusCircle == null)
	{
		var circleOptions = {
			center: center,
			radius: radius,
			fillColor: "blue",
			fillOpacity: 0.5,
			strokeColor: "black",
			strokeWeight: 2,
			strokeOpacity: 1.0,
			map: map
		}
		
		radiusCircle = new google.maps.Circle(circleOptions);
	}
	else
	{
		radiusCircle.setCenter(center);
		radiusCircle.setRadius(radius);
	}
}

function mapDoRadiusSearch()
{
	if(radiusCircle != null)
	{
		//Trazimo od servera da nam vrati sve tacke u bazi (par id->Lat,Lng)
		jQuery.ajax({
        type: "GET",
		async: true,
        url: "http://localhost/epigrafika/server/tacka.php",
		dataType: "json",
        success:function(result,statusText,jqxhr){
            if(result.error_status == false)
            {
				//Ukoliko je zahtev prosao, listamo tacke i pamtimo
				//samo one koje upadaju u radius pretrage
				var bounds = radiusCircle.getBounds();
				var dots = new Array();
				for(var i = 0; i<result.data.length; i++)
				{
					var lat = parseFloat(result.data[i].latituda);
					var lng = parseFloat(result.data[i].longituda);
					
					var latLng = new google.maps.LatLng(lat,lng);
					
					if(bounds.contains(latLng))
						dots.push({id: result.data[i].id, position: latLng});
				}
				
				//Oznaci tacke koje su upale u radius pretrage
				for(var i = 0; i < dots.length; i++)
					mapPlaceMarker(dots[i].position.lat(),dots[i].position.lng());
            }
        },
        error:function(jqxhr,statusText){
            console.log(statusText);
        }

    }); 
	}
}

function mapClearAll()
{
	mapClearAllMarkers();
	if(radiusCircle != null)
	{
		radiusCircle.setMap(null);
		radiusCircle = null;
	}
}