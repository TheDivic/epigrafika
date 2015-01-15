angular.module('epigrafikaModul').
    controller('objekatController',
        ['$scope', '$http', 
            function ($scope, $http){
                
                $scope.objectId = 0;
                $scope.object = null;
				$scope.imgList = null;
				$scope.bibliographyData = null;
				$scope.map = null;
				
				//Map settings
				var canvasId = "#map-canvas";
				var googleApiKey = "AIzaSyBArTJ-mPtJuBsGghbM2LHu-FAJpehXJLg";
				
				$scope.init = function(id)
                {
                    $scope.objectId = id;
                    
                    $http.get('../server/objekat.php?type=byId&objectId='+$scope.objectId, {responseType: 'JSON'}).
                        success(function(data, status, headers, config){
                            if(data.error_status == false)
                            {
                                $scope.object = data.data;
								$scope.imgList = data.data.fotografije;
								$scope.bibliographyData = data.data.bibliografskiPodatci;
								mapInit($scope.object.modernoMesto);
                            }
                            else
								console.error(data.error_message); 
                        }).
                        error(function(data, status, headers, config){
                            console.error(status);
                    });
                }
				
				/*function getImgUriList()
				{
					$http.get('../server/fotografija.php?type=byObject&objectId='+$scope.objectId, {responseType: 'JSON'}).
                        success(function(data, status, headers, config){
                            if(data.error_status == false)
                                $scope.imgUriList = data.data;
                            else
								console.error(data.error_message);
                        }).
                        error(function(data, status, headers, config){
                            console.error(status);
                    });
				}*/
				
				//Inicijalizacija mape
				function mapInit(name)
				{
					var coords = mapGetCoordinatesByName(name);
					var mapOptions = { center: coords, zoom: 8 };
					var canvas = $(canvasId)[0];
					$scope.map = new google.maps.Map(canvas, mapOptions);
					var marker = new google.maps.Marker({
						position: {lat: coords.lat, lng: coords.lng},
						map: $scope.map,
						title: $scope.object.oznaka
					});
				}
				//Utility metoda koja vraca koordinate na osnovu tekstualnog opisa mesta
				function mapGetCoordinatesByName(locationName)
				{
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
								}
							},
							error:function(jqxhr,statusText){
								console.error(statusText);
							}
						});
					}		
					return result;
				}
            }]);
console.info("Inicijalizovan objekatController.");