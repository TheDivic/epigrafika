// epigrafikaModul glavni modul
// JEDINI MODUL koji se koristi u okviru ng-app direktive
var glavniModul = angular.module('epigrafikaModul', ['translationModule']);

glavniModul.controller('headerController', ['$scope', function ($scope){
    $scope.logged=false;
}]);
console.info("Inicijalizovan headerController.");

// Root controller sadrzi stvari koje zelimo da delimo izmedju kontrolera
// npr objekat sa prevodima
glavniModul.controller('rootController', ['$scope', 'getTranslation', function($scope, getTranslation){
    $scope.changeTo = function(language){
        var promise = getTranslation(language); 
        
        promise
        .success(function(result){
            $scope.tr = angular.fromJson(result);
        })
        .error(function(result){
            console.error(result);
        });
    };

    $scope.changeTo('serbian');
}]);
console.info("Inicijalizovan rootController.");