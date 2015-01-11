$(document).ready(function() {    
    //S obzirom da je slider custom kontrola
    //nije moguce koristiti ng-model nad njom
    //tako da se pribegava jQuery-u
    var radiusCtrl = $('#radius');
    radiusCtrl.slider()
        .on('slide', function(e){
            RadiusSearchManager.getInstance().setRadius(e.value*1000);
        });
    radiusCtrl.slider({
        formatter: function(value) {
            return 'Radius: ' + value + 'km';
        }
    });
    RadiusSearchManager.getInstance().setRadius(radiusCtrl.slider('getValue')*1000);
    
    //Kacimo se na event koji oznacava promenu trenutnog taba na map tab
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if(e.target.id == "tab-btn-mapa")
    {
        //Ovo je potrebno kako bi osigurali korektno
        //iscrtavanje mape u div-u koji je inicijalno skriven.
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
        
        RadiusSearchManager.getInstance().refreshGraphics();
    }     
    }); 
});

//AngularJS kontroler za sve vezano za pretragu preko mape
angular.module('epigrafikaModul').
    controller('mapSearchController',
        ['$scope', '$http', 
            function ($scope, $http){
            
                $scope.cities = null;
                $scope.city = null;
                $scope.center = null;
                $scope.found = 0;
                
                $http.get('../server/moderno_mesto.php', {responseType: 'JSON'}).
                success(function(data, status, headers, config){
                    if(data.error_status == false && data.data.length >= 1)
                    {
                        $scope.cities=data.data;
                        $scope.city=$scope.cities[0].naziv;
                    }
                    else
                        console.error(data.error_message);
                }).
                error(function(data, status, headers, config){
                    console.error(status);
                });
                
                $scope.radiusSearch = function(){
                    $scope.found = RadiusSearchManager.getInstance().doRadiusSearch();
                }
                
                $scope.$watch("city", function(newValue, oldValue){
                    $scope.center = mapGetCoordinatesByName($scope.city);
                    if($scope.center)
                        RadiusSearchManager.getInstance().setCenter($scope.center);                        
                });
                
            }]);
console.info("Inicijalizovan mapSearchController.");