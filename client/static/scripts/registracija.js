angular.module('epigrafikaModul').controller('registracijaController', ['$scope','$http', '$window', function($scope,$http,$window) {
	$scope.greska=false;
	$scope.sameR=false;
        
        $scope.imeprezime=null;
        $scope.email=null;
        $scope.institucija = null;
        $scope.user=null;
        $scope.pwd=null;
        $scope.info=null;
        
	$scope.same= function($first,$second){
		if($first!=$second)
			$scope.sameR=true;
		else
			$scope.sameR=false;
	}
	$scope.jedinstven=function ()
	{	
            var user = $scope.user;
            $http.get('../server/korisnik.php?type=jedinsten_username&user="'+user+'"', {responseType: 'JSON'}).
            success(function(data, status, headers, config){
                if(data!=="null"){
                    if(data.isEmpty)
                        $scope.greska = false;
                    else 
                        $scope.greska=true;
		}
            }).
            error(function(data, status, headers, config){

            });
           // console.log("user "+user);
            //console.log("greska "+$scope.greska);
	}
        
        $scope.posaljiPodatke=function()
        {
	    var formData = {
                ime : $scope.ime,
                prezime : $scope.prezime,
                email : $scope.email,
                institucija : $scope.institucija,
                username : $scope.user,
                password : $scope.pwd,
                info : $scope.info,
		status: "aktivan",
		privilegije: "korisnik"
            };
            
            var jsonData = angular.toJson(formData);
           // alert(jsonData);
            
            $http.post('../server/korisnik.php', jsonData, 
            {responseType:'JSON',headers: {'content-type': 'application/json'}
            }).
            success(function(data, status, headers, config){
                if(data!=="null"){
                    if(data.error_status === false)
                        alert("Uspesno ste se registrovali.");
                    else
                        alert("Doslo je do greske pri registraciji.");
                    $window.location.reload();
                }
            }).
            error(function(data, status, headers, config){

            });
        };
  

  
}]);
console.info("Inicijalizovan registracijaController");
