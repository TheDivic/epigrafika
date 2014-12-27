angular.module('epigrafikaModul').controller('registracijaController', ['$scope', function($scope) {
    $scope.username='';
    $scope.password='';
    $scope.passwordR='';
    $scope.email='';
    $scope.info='';
    $scope.sameR='false';
    $scope.same=function(){
        if($scope.password==$scope.passwordR)
        {
            $scope.sameR='false';
        }
        else{
            $scope.sameR='true';
        }
    }
}]);
console.info("Inicijalizovan registracijaController");
