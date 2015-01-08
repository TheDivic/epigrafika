// epigrafikaModul glavni modul
// JEDINI MODUL koji se koristi u okviru ng-app direktive
var glavniModul = angular.module('epigrafikaModul', ['translationModule', 'ngCookies']);

glavniModul.controller('headerController', ['$scope', function ($scope){
    $scope.logged=true;

}]);
console.info("Inicijalizovan headerController.");

// Root controller sadrzi stvari koje zelimo da delimo izmedju kontrolera
// npr objekat sa prevodima
glavniModul.controller('rootController', ['$scope', 'getTranslation', '$cookies', function($scope, getTranslation, $cookies){
    $scope.changeTo = function(language){
        var promise = getTranslation(language); 
        
        promise
        .success(function(result){
            $scope.tr = angular.fromJson(result);
            $cookies.language = language;
        })
        .error(function(result){
            console.error(result);
        });
    };

    if($cookies.language){
        $scope.changeTo($cookies.language);
    }
    else {
        $scope.changeTo('serbian');
    }
}]);
console.info("Inicijalizovan rootController.");