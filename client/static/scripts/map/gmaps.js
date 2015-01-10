//Map settings
var canvasId = "#map-canvas";
var googleApiKey = "AIzaSyBArTJ-mPtJuBsGghbM2LHu-FAJpehXJLg";

//Global vars
var map;
var radiusCircle;
var markers = new Array();
var coordinatesCache = {};

//Inicijalizacija mape
function mapInit()
{
	var mapOptions = { center: mapGetCoordinatesByName("Beograd"), zoom: 8 };
	var canvas = $(canvasId)[0];
	map = new google.maps.Map(canvas, mapOptions);
}

//Predstavlja jedan arheoloski objekat na mapi
function ArchObject(name, description, polygon)
{
	this.name = name;
	this.description = description;
	
	var latMid = 0;
	var lngMid = 0;
	var coords = new Array();
	for(var i = 0; i < polygon.length; i++)
	{
		latMid += polygon[i].latitude;
		lngMid += polygon[i].longitude;
		coords.push({lat: polygon[i].latitude, lng: polygon[i].longitude});
	}
	
	latMid /= polygon.length;
	lngMid /= polygon.length;
	
    this.marker = new google.maps.Marker({
        position: {lat: latMid, lng: lngMid},
        map: map,
		title: this.name
    });
	
	this.polygon = new google.maps.Polygon({
		paths: coords,
		map: map,
		strokeColor: '#FF0000',
		strokeOpacity: 0.8,
		strokeWeight: 2,
		fillColor: '#FF0000',
		fillOpacity: 0.35
	});
	
	this.infoWindow = new google.maps.InfoWindow({
		content: "<p>"+this.name+"</p><p>"+this.description+"</p>"
	});
	
	var obj = this;
	google.maps.event.addListener(this.marker, 'click', function(){
		obj.infoWindow.open(map,obj.marker);
	});
}

ArchObject.prototype.clearObject = function (){
	this.name = null;
	this.description = null;
	this.marker.setMap(null);
	this.polygon.setMap(null);
	this.infoWindow.setMap(null);
	this.marker = null;
	this.polygon = null;
	this.infoWindow = null;
};

//Singleton koji upravlja pretragom preko mape
var RadiusSearchManager = (function () {
    var instance;
    
    function RadiusSearch()
    {
        this.graphics = {};
        
        var circleOptions = {
            center: { lat: 0, lng: 0 },
            radius: 0,
            fillColor: "blue",
            fillOpacity: 0.25,
            strokeColor: "black",
            strokeWeight: 1,
            strokeOpacity: 1.0,
            map: map
        }
        this.graphics.circle = new google.maps.Circle(circleOptions);
        this.graphics.marker = new google.maps.Marker();
    }
    
    RadiusSearch.prototype.setCenter = function(center)
    {
        if(map)
            map.panTo(center);
        this.graphics.circle.setCenter(center);
        this.graphics.marker.setPosition(center);
    }
    
    RadiusSearch.prototype.setRadius = function(radius)
    {
        this.graphics.circle.setRadius(radius);
    }
    
    RadiusSearch.prototype.refreshGraphics = function()
    {
        this.graphics.circle.setMap(map);
        this.graphics.marker.setMap(map);
    }
    
    function createInstance() {
        var object = new RadiusSearch();
        return object;
    }
 
    return {
        getInstance: function () {
            if (!instance) {
                instance = createInstance();
            }
            return instance;
        }
    };
})();

//Utility metoda koja vraca koordinate na osnovu tekstualnog opisa mesta
function mapGetCoordinatesByName(locationName)
{
    //Check cache first
    if(coordinatesCache.hasOwnProperty(locationName))
        return coordinatesCache[locationName];
        
    var result = null;
    
    if(locationName)
    {
        jQuery.ajax({
            type: "GET",
            async: false,
            url: "https://maps.googleapis.com/maps/api/geocode/json",
            data: {address: locationName, key: googleApiKey},
            dataType: "json",
            success:function(data,statusText,jqxhr){
                if(data.status == 'OK')
                {
                    //found at least one geo location
                    var lat = data.results[0].geometry.location.lat;
                    var lng = data.results[0].geometry.location.lng;
                    
                    result = {lat: lat, lng: lng};
                    coordinatesCache[locationName] = result;
                }
            },
            error:function(jqxhr,statusText){
                console.error(statusText);
            }
        });
    }
    
    return result;
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
	return marker;
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
					
					if(bounds.contains(new google.maps.LatLng(lat,lng)))
						dots.push({lat: lat, lng: lng});
				}
				
				//Oznaci tacke koje su upale u radius pretrage
				//for(var i = 0; i < dots.length; i++)
					//mapPlaceMarker(dots[i].position.lat(),dots[i].position.lng());
				
				var latMin = 9999;
				var latMax = -9999;
				var lngMin = 9999;
				var lngMax = -9999;
				
				for(var i = 0; i < dots.length; i++)
				{
					if(dots[i].lat < latMin)
						latMin = dots[i].lat;
					if(dots[i].lat > latMax)
						latMax = dots[i].lat;
					if(dots[i].lng < lngMin)
						lngMin = dots[i].lng;
					if(dots[i].lng > lngMax)
						lngMax = dots[i].lng;
				}
                
                mapSearch(latMin,latMax,lngMin,lngMax);
            }
            else
                console.error(result.error_message);
        },
        error:function(jqxhr,statusText){
            console.error(statusText);
        }
    }); 
	}
}

function mapSearch(latMin,latMax,lngMin,lngMax)
{
    jQuery.ajax({
        type: "GET",
        async: true,
        url: "http://localhost/epigrafika/server/objekat.php",
        data: { type: "radiusSearch", latMin: latMin, latMax: latMax, lngMin: lngMin, lngMax: lngMax },
        dataType: "json",
        success: function(result,statusText,jqxhr){
            if(result.error_status == false)
            {
                console.log(JSON.stringify(result.data));
            }
            else
                console.error(result.error_message);
        },
        error:function(jqxhr,statusText){
            console.error(statusText);
        }     
    });
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

function mapCreateDemoObject()
{
	var archObject = new ArchObject(demoObject.name, demoObject.desc, demoObject.polygon);
}

var demoObject = {
name: "Arheoloski objekat 1",
desc: "Neki opis, nesto nesto.",
polygon: [{latitude: 44.7866,longitude: 20.4489},{latitude: 44.8,longitude: 20.5},{latitude: 44.75,longitude: 20.43}]
}

//Register map init. on page load
google.maps.event.addDomListener(window,'load', mapInit);