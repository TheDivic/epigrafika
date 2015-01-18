// epigrafikaModul glavni modul
// JEDINI MODUL koji se koristi u okviru ng-app direktive
var glavniModul = angular.module('epigrafikaModul', ['translationModule', 'ngCookies', 'ui.bootstrap']);
  

// Root controller sadrzi stvari koje zelimo da delimo izmedju kontrolera
// npr objekat sa prevodima
glavniModul.controller('rootController', ['$scope', 'getTranslation', '$cookies','$http', '$window',function($scope, getTranslation, $cookies,$http,$window){

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
	
	
	$scope.login=function($u,$p){
		console.log("login");
		$http.get('../server/korisnik.php?type=login&user="'+$u+'"&pass="'+$p+'"', {responseType: 'JSON'}).
		success(function(data, status, headers, config){
        if(data!=="null"){
			if(data.isEmpty==false)

                window.location.replace('index.php');

			else{
				alert("Pogresno korisnicko ime ili sifra");}
			
		}
	}).
    error(function(data, status, headers, config){

    }); 
	}
	

	
}]);

console.info("Inicijalizovan rootController.");