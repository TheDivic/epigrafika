angular.module('epigrafikaModul').controller('configController', ['$scope', '$http','$cookies', function ($scope, $http,$cookies){
	$scope.podesavanja=null;
	$http.get('../server/podesavanja.php', {responseType: 'JSON'}).
	success(function(data, status, headers, config){
		if(data!=="null")
		$scope.podesavanja=data.data;
	}).
	error(function(data, status, headers, config){

	});
	$scope.submit = function(){
	console.log("SUBMIT");
	}

}]);
console.info("Inicijalizovan configController");