angular.module('epigrafikaModul').controller('zaboravljenaSifraController', ['$scope','$http', function($scope,$http) {
        $scope.posaljiEmail = function(){
            var user = $scope.user;
            $http.get('../server/korisnik.php?type=zaboravljenaSifra&user="'+user+'"', {responseType: 'JSON'}).
            success(function(data, status, headers, config){
                if(data!=="null"){
                    if(data.isEmpty){
                        $scope.greska = false;
                    }
                    else 
                        $scope.greska=true;
		}
                alert($scope.greska);
            }).
            error(function(data, status, headers, config){

            });
        }
}]);
console.info("Inicijalizovan zaboravljenaSifraController");