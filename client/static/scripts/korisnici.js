angular.module('epigrafikaModul').controller('adminKorisnici', ['$scope', '$http','$window', function ($scope, $http,$window){
    
    $scope.korisnici= null;
	$scope.greska=false;
	$scope.sameR=false;
	$scope.single=null;
        $scope.info=null;


    $scope.offset = 0;
    var pageLimit = 10;
    $scope.pageNumber = 1;
    $scope.remainingResults = 0;

    $scope.nextPage = function() {
        if($scope.remainingResults > 0){
            $scope.offset += pageLimit;
            $scope.pageNumber += 1;
            getKorisnici();
        }
    };

    $scope.previousPage = function() {
        if($scope.pageNumber > 1){
            $scope.offset -= pageLimit;
            $scope.pageNumber -= 1;
            getKorisnici();
        }
    };

    var getKorisnici = function() {
        //trazi se lista svih natpis od servera
        $http.get('../server/korisnik.php?type=all&offset=' + $scope.offset, {responseType: 'JSON'}).
        success(function(data, status, headers, config){
            if(data!=="null")
                $scope.korisnici=data.data;
                $scope.remainingResults = data.remaining;
        }).
        error(function(data, status, headers, config){
            console.error(data);
        });
    };
	
    getKorisnici();
		
	//provera za iste sifre
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
	}
	
	//funkcija koja salje zahtev za brisanje korisnika iz baze, sa prosledjenim id-em 
    $scope.obrisi=function($korisnickoIme){
		if($window.confirm('Da li ste sigurni?')) {
		$http.delete('../server/korisnik.php?korisnickoIme="'+$korisnickoIme+'"')
                .success(function (data, status, headers, config)
                {	
                    //$window.alert(data.poruka);
                    $window.location.reload();
                })
                .error(function (data, status, headers, config)
                {
          
                });
        
                } else { }
    };
	//unos novog korisnika
	$scope.submit=function(){
            var formData = {
                ime : $scope.ime,
                prezime : $scope.prezime,
                email : $scope.email,
                institucija : $scope.institucija,
                username : $scope.user,
                password : $scope.pwd,
                info : $scope.info,
		status: $scope.status,
		privilegije: $scope.privilegije
            };
            
            var jsonData = angular.toJson(formData);
			
            $http.post('../server/korisnik.php', jsonData, 
            {responseType:'JSON',headers: {'content-type': 'application/json'}
            }).
            success(function(data, status, headers, config){
               if(data!=="null"){
                    if(data.error_status === false){
                        alert("Uspesno ste uneli korisnika.");
				$window.location.reload();
			}
						
                    else
                        alert("Doslo je do greske pri registraciji.");
                   $window.location.reload();
                }
            }).
            error(function(data, status, headers, config){

            });
	}
	
	$scope.init= function(){
		var user=$window.location.href.split('=');
		//$scope.korisnickoIme= user;
		$http.get('../server/korisnik.php?type=view&korisnickoIme='+user[1], {responseType: 'JSON'}).
			success(function(data, status, headers, config){
			if(data!=="null"){
			$scope.single=data.data;
			}
			else
				$window.location.href="greska.php";
			}).
			error(function(data, status, headers, config){
				$window.location.href="greska.php";
			});
	}

	
	//funkcija koja salje zahtev da azurira odgovarajuci red u bazi
    $scope.sacuvaj=function($korisnickoIme, $ime,$prezime,$email,$institucija, $privilegije,$status)
    {

		var params = {
			korisnickoIme:$korisnickoIme,
			ime: $ime,
			prezime:$prezime,
			email:$email,
			institucija:$institucija,
			privilegije:$privilegije,
			stat:$status
			
		};
		var data = angular.toJson(params);
		//console.log(data);
	$http.put('../server/korisnik.php', data )
	.success(function (data, status, headers, config)
	{
            if(data.error_status==false){
                $window.alert("Azuriran je");         
				$window.location.href="korisnici.php";
            }
	    else
                console.error(data);
	})
	.error(function (data, status, headers, config)
	{
          
	});
	} 
   
	//funkcija koja cuva vrednosti polja pre izmene
	$scope.izmeni=function($korisnickoIme){
		$window.location.href="korisnici.php?korisnickoIme="+$korisnickoIme;
	}
	//funkcija koja ponistava izmene	
	$scope.ponisti=function(){
		$window.location.href="korisnici.php";
		
		}
	

}]);
console.info("Inicijalizovan adminKorisnici.");
