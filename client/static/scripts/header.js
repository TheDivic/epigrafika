// epigrafikaModul glavni modul
// JEDINI MODUL koji se koristi u okviru ng-app direktive
var glavniModul = angular.module('epigrafikaModul', ['translationModule', 'ngCookies', 'ui.bootstrap']);

// Root controller sadrzi stvari koje zelimo da delimo izmedju kontrolera
// npr objekat sa prevodima
glavniModul.controller('rootController', ['$scope', 'getTranslation', '$cookies','$http', function($scope, getTranslation, $cookies,$http){
	$scope.admin=false;
	$scope.logged=false;
	$scope.active=false;
<<<<<<< HEAD

    //Funkcija koja menja jezik interfejsa
=======
	
	if($cookies.admin=='admin') $scope.admin=true; else $scope.admin=false;
	if($cookies.logged=='logged') $scope.logged=true; else $scope.logged=false;
	if($cookies.active=='active') $scope.active=true; else $scope.active=false;
	
>>>>>>> 6fc8fe266ec727071ba7c138bb2b6bf01dc7ab8b
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

    $scope.login=function($u,$p){
        console.log("login");
        $http.get('../server/korisnik.php?type=login&user="'+$u+'"&pass="'+$p+'"', {responseType: 'JSON'})
        .success(function(data, status, headers, config){
            if(data!=="null"){
               if(data.isEmpty==false){
                $scope.logged=true;
                console.log("logged");
            }
            if(data.data[0].mod=="admin"){
                $scope.admin=true;
                console.log("admin");
            }
            if(data.data[0].status=="aktivan"){
                $scope.active=true;
                console.log("active");
            }
        }
        }).
        error(function(data, status, headers, config){

        }); 
    };

    $scope.logout=function(){
        $scope.logged=false;
        $scope.admin=false;
        $scope.active=false;
    };

    // ON PAGE LOAD
    if($cookies.language){
        $scope.changeTo($cookies.language);
    }
    else {
        $scope.changeTo('serbian');
<<<<<<< HEAD
    }	
=======
    }
	
	
	$scope.login=function($u,$p){
		console.log("login");
		$http.get('../server/korisnik.php?type=login&user="'+$u+'"&pass="'+$p+'"', {responseType: 'JSON'}).
		success(function(data, status, headers, config){
        if(data!=="null"){
			if(data.isEmpty==false){
				$scope.logged=true; $cookies.logged='logged';
				console.log("logged");
				}
			if(data.data[0].mod=="admin"){
				$scope.admin=true; $cookies.admin='admin';
				console.log("admin");
			}
			if(data.data[0].status=="aktivan"){
				$scope.active=true; $cookies.active='active';
				console.log("active");
			}
			}
	}).
    error(function(data, status, headers, config){

    }); 
	}
	
		$scope.logout=function(){
		$scope.logged=false; $cookies.logged='no';
		$scope.admin=false; $cookies.admin='korisnik';
		$scope.active=false; $cookies.active='nekativan';
		}
	
>>>>>>> 6fc8fe266ec727071ba7c138bb2b6bf01dc7ab8b
}]);

console.info("Inicijalizovan rootController.");