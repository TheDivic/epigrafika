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

//AngularJS kontroler za sve vezano za pretragu preko mape
angular.module('epigrafikaModul').
    controller('mapSearchController'),
        ['$scope', '$http', 
            function ($scope, $http){

            }];
console.info("Inicijalizovan mapSearchController.");