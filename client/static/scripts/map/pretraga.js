$(document).ready(function() {
    $('#radius').slider({
        formatter: function(value) {
            return 'Radius: ' + value + 'km';
        }
    });
    
    //Kacimo se na event promene tabova.
    //Ovo je potrebno kako bi osigurali korektno
    //iscrtavanje mape u div-u koji je inicijalno skriven.
    //TODO: Mozda ovaj bugfix strpati negde drugde
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if(e.target.id == "tab-btn-mapa")
    {
        var center = map.getCenter();
        google.maps.event.trigger(map, "resize");
        map.setCenter(center);
    }     
    }); 
});

//AngularJS kontroler za sve vezano za pretragu preko mape
angular.module('epigrafikaModul').
    controller('mapSearchController',
        ['$scope', '$http', 
            function ($scope, $http){
            
                $scope.mesta = null;
                $scope.center = null;
                
                $scope.radiusMin = 1;
                $scope.radiusMax = 100;
                $scope.radius = 10;
                
                $http.get('../server/moderno_mesto.php', {responseType: 'JSON'}).
                success(function(data, status, headers, config){
                    if(data.error_status == false && data.data.length >= 1)
                    {
                        $scope.mesta=data.data;
                        $scope.center=$scope.mesta[0].naziv;
                    }
                    else
                        console.error(data.error_message);
                }).
                error(function(data, status, headers, config){
                    console.error(status);
                });
            }]);
console.info("Inicijalizovan mapSearchController.");