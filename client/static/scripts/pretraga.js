angular.module('epigrafikaModul').controller('pretragaController', ['$scope', '$http', function ($scope, $http){
    $scope.oznaka=null;
	$scope.natpis=null;
	$scope.natpis2=null;
	$scope.natpisArg='prazno';
	$scope.rezimIgnorisanjaZagrada=false;
	$scope.provincijaNalaska=null;
	$scope.gradNalaska=null;
	$scope.mestoNalaska=null;
	$scope.prikaziNelokalizovanePodatke=false;
	$scope.modernoImeDrzave=null;
	$scope.modernoMesto=null;
	$scope.pleme=null;
        $scope.vek=null;
	$scope.periodVeka=null;
	$scope.prikaziNedatovaneNatpise=false;
	$scope.sortiranje='poVremenu';
	$scope.prikazi=true;
	
        $scope.provincije= null;
        $scope.drzave=null;
	$scope.plemena=null;
	$scope.mesta=null;
	$scope.razultatPretrage=null;

    $http.get('../server/provincije.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
        $scope.provincije=data.data;
    }).
    error(function(data, status, headers, config){
    });

    $http.get('../server/moderna_drzava.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
            $scope.drzave=data.data;
    }).
    error(function(data, status, headers, config){

    });
	
	$http.get('../server/pleme.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
            $scope.plemena=data.data;
    }).
    error(function(data, status, headers, config){

    });
	
	$http.get('../server/moderno_mesto.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
            $scope.mesta=data.data;
    }).
    error(function(data, status, headers, config){

    });
	
	$scope.posalji_podatke=function(){
	
	    if($scope.natpisArg == 'prazno')
		    $scope.natpis2=null;
		if($scope.natpis2==null || $scope.natpis2=="")
			$scope.natpisArg = 'prazno';
		if($scope.natpis2=="")
			$scope.natpis2=null;
	    if(	$scope.vek=="")
			$scope.vek=null;
		if(	$scope.vek==null)
			$scope.periodVeka=null;
	    var formData = {
		    oznaka : $scope.oznaka,
		    natpis : $scope.natpis,
		    natpisArg : $scope.natpisArg,
		    natpis2 : $scope.natpis2,
		    rezimIgnorisanjaZagrada : $scope.rezimIgnorisanjaZagrada,
		    provincijaNalaska : $scope.provincijaNalaska,
		    gradNalaska : $scope.gradNalaska,
		    mestoNalaska : $scope.mestoNalaska,
		    prikaziNelokalizovanePodatke : $scope.prikaziNelokalizovanePodatke,
		    modernoImeDrzave : $scope.modernoImeDrzave,
		    modernoMesto : $scope.modernoMesto,
		    pleme: $scope.pleme,
		    vek : $scope.vek,
		    periodVeka: $scope.periodVeka,
		    prikaziNedatovaneNatpise : $scope.prikaziNedatovaneNatpise,
		    sortiranje: $scope.sortiranje
	 }
	var jsonData = angular.toJson(formData);
	alert(jsonData);
	 
	$http.get('../server/objekat.php?type=search&podaci="'+jsonData+'"', {responseType: 'JSON'}).
        success(function(data, status, headers, config){
            if(data!=="null"){
                alert("ovde udje" +  data.ulazniPodaci);
                $scope.rezultatPretrage=data.data;
                alert(data.data);
            }
            else alert("null");
        }).
        error(function(data, status, headers, config){
                alert("Errorcina");
        });

	$scope.natpis=null;
	$scope.natpis2=null;
	$scope.natpisArg='prazno';
	$scope.rezimIgnorisanjaZagrada=false;
	$scope.provincijaNalaska=null;
	$scope.gradNalaska=null;
	$scope.mestoNalaska=null;
	$scope.prikaziNelokalizovanePodatke=false;
	$scope.modernoImeDrzave=null;
	$scope.modernoMesto=null;
	$scope.pleme=null;
        $scope.vek=null;
	$scope.periodVeka=null;
	$scope.prikaziNedatovaneNatpise=false;
	$scope.sortiranje='poVremenu';
	$scope.prikazi=true;
        document.getElementById('reset').click();
        $scope.prikazi=false;
        
	};

    $scope.autocompleteNatpis = function() {
        if($scope.natpis){
            var lastWord = $scope.natpis.split(/[\s,.!?]+/).pop();

            $http.get('../server/autocomplete.php?type=inscription&key=' + lastWord).
                success(function(data){
                    var response = angular.fromJson(data);

                    if(response.words){
                        $scope.natpisPredlozi = response.words;
                        $scope.show_natpis_autocomplete = true;
                    }
                    else {
                        $scope.natpisPredlozi = [];
                        $scope.show_natpis_autocomplete = false;
                    }
                }).
                error(function(data){
                    console.log("Error");
                });
        }
        else {
            $scope.show_natpis_autocomplete = false;
        }
    };

    // Natpis je oblika:
    // Tekst tekst *tek(st)* 
    // treba da se izvrsi autocomplete za rec *tek* da se doda sufiks *(st)*
    // potrebno je tek zameniti sa st u tekstu
    $scope.upisiPredlogNatpis = function($event){
        var lastWord = $scope.natpis.split(/[\s,.!?]+/).pop();
        var index = $scope.natpis.lastIndexOf(lastWord);
        var new_natpis = $scope.natpis.substring(0, index) + $event.target.innerHTML;
        $scope.natpis = new_natpis;
        $scope.show_natpis_autocomplete = false;
    };

    $scope.autocompleteGrad = function() {
        if($scope.gradNalaska){
            $http.get('../server/autocomplete.php?type=city&key=' + $scope.gradNalaska).
                success(function(data){
                    var response = angular.fromJson(data);

                    if(response.words){
                        $scope.gradPredlozi = response.words;
                        $scope.show_grad_autocomplete = true;
                    }
                    else {
                        $scope.gradPredlozi = [];
                        $scope.show_grad_autocomplete = false;
                    }
                }).
                error(function(data){
                    console.log("Error");
                });
        }
        else {
            $scope.show_grad_autocomplete = false;
        }
    }

    $scope.upisiPredlogGrad = function($event){
        $scope.gradNalaska = $event.target.innerHTML;
        $scope.show_grad_autocomplete = false;
    };

    $scope.autocompleteMesto = function() {
        if($scope.mestoNalaska){
            $http.get('../server/autocomplete.php?type=place&key=' + $scope.mestoNalaska).
                success(function(data){
                    var response = angular.fromJson(data);

                    if(response.words){
                        $scope.mestoPredlozi = response.words;
                        $scope.show_mesto_autocomplete = true;
                    }
                    else {
                        $scope.mestoPredlozi = [];
                        $scope.show_mesto_autocomplete = false;
                    }
                }).
                error(function(data){
                    console.log("Error");
                });
        }
        else {
            $scope.show_mesto_autocomplete = false;
        }
    }

    $scope.upisiPredlogMesto = function($event){
        $scope.mestoNalaska = $event.target.innerHTML;
        $scope.show_mesto_autocomplete = false;
    };
}]);
console.info("Inicijalizovan pretragaController.");