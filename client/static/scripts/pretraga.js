angular.module('epigrafikaModul').controller('pretragaController', ['$scope', '$http', function ($scope, $http){
    $scope.oznaka='';
    $scope.modernoImeDrzave="";
    $scope.provincijaNalaska="";
    $scope.natpisArguments=false;
    $scope.provincije= null;
    $scope.drzave=null;

    $http.get('../server/provincije.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
        $scope.provincije=data.data;
    }).
    error(function(data, status, headers, config){
    });

    $http.get('../server/modernaDrzava.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
            $scope.drzave=data.data;
    }).
    error(function(data, status, headers, config){

    });
}]);
console.info("Inicijalizovan pretragaController.");