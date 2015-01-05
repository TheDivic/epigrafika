angular.module('epigrafikaModul').controller('registracijaController', ['$scope', function($scope) {
   	$scope.emailB=false;
	$scope.sameR=false;
	$scope.same=function(){
	if($scope.pwd.trim()==$scope.pwdR.trim())
		$scope.sameR=false;
	else
		$scope.sameR=true;
	}
	
}]);
console.info("Inicijalizovan registracijaController");
