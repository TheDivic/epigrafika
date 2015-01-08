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

    $http.get('../server/modernaDrzava.php', {responseType: 'JSON'}).
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
	
	$http.get('../server/modernoMesto.php', {responseType: 'JSON'}).
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
	 
	$http.get('../server/objekat.php?podaci='+jsonData, {responseType: 'JSON'}).
        success(function(data, status, headers, config){
            if(data!=="null")
                $scope.rezultatPretrage=data.data;
        }).
        error(function(data, status, headers, config){

        });
	}
}]);
console.info("Inicijalizovan pretragaController.");