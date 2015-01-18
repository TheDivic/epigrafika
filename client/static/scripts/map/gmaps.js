//Map settings
var canvasId = "#map-canvas";
var googleApiKey = "AIzaSyBArTJ-mPtJuBsGghbM2LHu-FAJpehXJLg";

//Global vars
var map;
var coordinatesCache = {};

//Inicijalizacija mape
function mapInit()
{
	var mapOptions = { center: mapGetCoordinatesByName("Beograd"), zoom: 8 };
	var canvas = $(canvasId)[0];
	map = new google.maps.Map(canvas, mapOptions);
}

//Predstavlja jedan arheoloski objekat na mapi
function ArchObject(id, name, preview, polygon)
{
	this.name = name;
	this.preview = preview;
	
	var latMid = 0;
	var lngMid = 0;
	var coords = new Array();
	for(var i = 0; i < polygon.length; i++)
	{
		latMid += polygon[i].lat;
		lngMid += polygon[i].lng;
		coords.push({lat: polygon[i].lat, lng: polygon[i].lng});
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
		content: "<p>"+this.name+"</p><p>"+this.preview+"</p>"
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

function QueryResultNode(location, objects)
{
    this.locationId = location.id;
    this.locationName = location.naziv;
    this.marker = null;
    
    var coords = mapGetCoordinatesByName(this.locationName);
    
    if(coords)
    {
        var content = "<div style='width:300px;'>";
        for(var i = 0; i < objects.length; i++)
        {
            content +=  "<h4 style='margin:0'>"+objects[i].oznaka+"</h4>"+
						"<p style='padding-left:5px;margin:0;font-style:italic;word-wrap:break-word;'>"+objects[i].tekstNatpisa.substring(0,50)+"</p>"+
						"<a style='padding-left:5px' href='objekat.php?id="+objects[i].id+"' target='_blank'>Detaljnije</a>"+ //TODO: Lokalizuj
						"<hr style='margin:5px'/>";
        }
		content+="</div";
        
        this.infoWindow = new google.maps.InfoWindow({
            content: content,
			minWidth: 300
        });
        
        this.marker = new google.maps.Marker({
            position: {lat: coords.lat, lng: coords.lng},
            map: map,
            title: this.locationName
        });
        
        var obj = this;
        google.maps.event.addListener(this.marker, 'click', function(){
            obj.infoWindow.open(map,obj.marker);
        });
    }
}

QueryResultNode.prototype.clearNode = function()
{
    this.locationId = null;
    this.locationName = null;
    this.infoWindow = null;
    this.marker.setMap(null);
    this.marker = null;
}

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
            fillOpacity: 0.10,
            strokeColor: "black",
            strokeWeight: 1,
            strokeOpacity: 1.0,
            clickable: false,
            map: map
        }
        var markerOptions = {
            map: map,
            clickable: false,
            draggable: true,
            title: "Center",
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                strokeColor: "blue",
                strokeWeight: 5,
                scale: 5
            }
        }
            
        this.graphics.circle = new google.maps.Circle(circleOptions);
        this.graphics.marker = new google.maps.Marker(markerOptions);
        
        var obj = this;
        google.maps.event.addListener(this.graphics.marker,'drag',function(e){
            obj.graphics.circle.setCenter(e.latLng);
        });
        
        this.nodes = null;
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
    
    //Ne koristi se u trenutnoj verziji
    RadiusSearch.prototype.getInboundPoints = function()
    {
        var points = new Array();
        var center = this.graphics.circle.getCenter();
        var radius = this.graphics.circle.getRadius();
        
        //Trazimo od servera da nam vrati sve tacke u bazi (par id->Lat,Lng)
		jQuery.ajax({
            type: "GET",
            async: false,
            url: "../server/tacka.php",
            dataType: "json",
            success:function(result,statusText,jqxhr){
                if(result.error_status == false)
                {
                    //Ukoliko je zahtev prosao, listamo tacke i pamtimo
                    //samo one koje upadaju u radius pretrage
                    for(var i = 0; i<result.data.length; i++)
                    {
                        var lat = parseFloat(result.data[i].latituda);
                        var lng = parseFloat(result.data[i].longituda);
                        
                        var latLng = new google.maps.LatLng(lat,lng);
                        
                        var distance = google.maps.geometry.spherical.computeDistanceBetween(center, latLng);
                        
                        if(distance <= radius)
                            points.push({lat: lat, lng: lng});
                    }
                }
                else
                    console.error(result.error_message);
            },
            error:function(jqxhr,statusText){
                console.error(statusText);
            }
        });
        
        return points;
    }
    
    RadiusSearch.prototype.getInboundLocations = function()
    {
        var locations = new Array();
        var center = this.graphics.circle.getCenter();
        var radius = this.graphics.circle.getRadius();
        
        //Trazimo od servera da nam vrati sva moderna mesta u bazi
		jQuery.ajax({
            type: "GET",
            async: false,
            url: "../server/moderno_mesto.php",
            dataType: "json",
            success:function(result,statusText,jqxhr){
                if(result.error_status == false)
                {
                    //Ukoliko je zahtev prosao, listamo tacke i pamtimo
                    //samo one koje upadaju u radius pretrage
                    for(var i = 0; i<result.data.length; i++)
                    {
                        var coords = mapGetCoordinatesByName(result.data[i].naziv);
                        if(coords)
                        {            
                            var lat = coords.lat;
                            var lng = coords.lng;
                            
                            var latLng = new google.maps.LatLng(lat,lng);
                            
                            var distance = google.maps.geometry.spherical.computeDistanceBetween(center, latLng);
                            
                            if(distance <= radius)
                                locations.push({id: result.data[i].id,naziv: result.data[i].naziv});
                        }
                    }
                }
                else
                    console.error(result.error_message);
            },
            error:function(jqxhr,statusText){
                console.error(statusText);
            }
        });
        
        return locations;
    }
    
    RadiusSearch.prototype.doRadiusSearch = function()
    {
        //Cistimo prethodni rezultat
        if(this.nodes)
            for(var i = 0; i < this.nodes.length; i++)
                this.nodes[i].clearNode();
        
        var locations = this.getInboundLocations();
        
        var resultNodes = new Array();
        for(var i = 0; i < locations.length; i++)
        {
            jQuery.ajax({
                type: "GET",
                async: false,
                url: "../server/objekat.php",
                data: { type: "byLocation", locationId: locations[i].id},
                dataType: "json",
                success:function(result,statusText,jqxhr){
                    if(result.error_status == false)
					{
						if(result.data.length >= 1)
							resultNodes.push(new QueryResultNode(locations[i], result.data));
					}
                    else
                        console.error(result.error_message);
                },
                error:function(jqxhr,statusText){
                    console.error(statusText);
                }
            });
        }
        
        this.nodes = resultNodes;
        
        return this.nodes.length;
    }
    
    //Singleton pattern
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

//Register map init. on page load
google.maps.event.addDomListener(window,'load', mapInit);