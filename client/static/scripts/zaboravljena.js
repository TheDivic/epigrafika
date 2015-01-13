angular.module('epigrafikaModul').controller('zaboravljenaSifraController', ['$scope','$http', function($scope,$http) {
    $scope.posaljiEmail = function(){
        var user = $scope.user;
        $http.get('../server/korisnik.php?type=zaboravljenaSifra&user="'+user+'"', {responseType: 'JSON'}).
            success(function(data, status, headers, config){
                alert(data.message);
            }).
            error(function(data, status, headers, config){

            });
    }
}]);
console.info("Inicijalizovan zaboravljenaSifraController");