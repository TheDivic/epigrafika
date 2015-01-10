angular.module('epigrafikaModul').controller('registracijaController', ['$scope','$http', function($scope,$http) {
	$scope.greska=false;
	$scope.sameR=false;
	$scope.same= function($first,$second){
		if($first!=$second)
			$scope.sameR=true;
		else
			$scope.sameR=false;
	}
	$scope.jedinstven=function ()
	{	var user = $scope.user;
		$http.get('../server/objekat.php?type=jedinstenost&user="'+user+'"', {responseType: 'JSON'}).
			success(function(data, status, headers, config){
				if(data!=="null"){
					if(data.isEmpty){
						$scope.greska = false;
					else 
						$scope.greska=true;
				}
			}).
			error(function(data, status, headers, config){

    });
	console.log("user "+user);
	console.log("greska "+$scope.greska);
	}
  

  
}]);
console.info("Inicijalizovan registracijaController");
