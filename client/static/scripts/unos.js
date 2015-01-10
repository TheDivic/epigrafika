angular.module('epigrafikaModul').controller('unosController', ['$scope', '$http','$cookies', function ($scope, $http,$cookies){
    $scope.oznaka=null;
	$scope.jezikUpisa='latinski';
	$scope.natpis=null;
	$scope.vrstaNatpisa=null;
	$scope.LokalizovanPodatak=true;
	$scope.provincija=null;
	$scope.grad=null;
	$scope.mestoNalaska=null;
	$scope.modernoImeDrzave=null;
	$scope.modernoMesto=null;
	$scope.trenutnaLokacijaZnamenitosti=null;
	$scope.pleme=null;
	$scope.vreme="nedatovan";
	$scope.godinaPronalaska=null;
	$scope.vekPronalaska=null;
	$scope.periodVeka=null;
	$scope.pocetakPerioda=null;
	$scope.krajPerioda=null;
	$scope.tipZnamenitosti=null;
	$scope.materijalZnamenitosti=null;
	$scope.sirina=null;
	$scope.visina=null;
	$scope.duzina=null;
	$scope.bibliografskoPoreklo=null;
	$scope.bibliografskoPorekloSkracenica=null;
	$scope.komentar=null;
	$scope.fotografije=null;
	$scope.fazaUnosa=null;
	$scope.greska="";
	$scope.korisnik=$cookies.user;
        $scope.provincije= null;
        $scope.drzave=null;
        $scope.gradovi=null;
        $scope.vrsteNatpisa=null;
	$scope.mesta=null;
	
	function izracunajVek(godina){
		if(godina < 100)
		{
			return 1;
		}
		var vek;
		vek = Math.floor(godina/100);

		if(godina%100 == 0)
			return vek;
		else 
			return vek+ 1;
	}

	function izracunajPeriodVeka(godina){
	    if(godina%100 > 49)
			return $scope.tr.druga_polovina;
		else  return $scope.tr.prva_polovina;
	}

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
    
    $http.get('../server/moderno_mesto.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
            $scope.mesta=data.data;
    }).
    error(function(data, status, headers, config){

    });

    $http.get('../server/gradovi.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
          $scope.gradovi=data.data;
  }).
    error(function(data, status, headers, config){

    });

    $http.get('../server/vrsta_natpisa.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
          $scope.vrsteNatpisa=data.data;
  }).
    error(function(data, status, headers, config){

    });


    $scope.unetaGodina = function(){
        if($scope.godinaPronalaska == "")
        {
          $scope.vekIzracunat = "";
          $scope.periodVekaIzracunat = "";
          return;
      }
      var godina = parseInt($scope.godinaPronalaska);
      var periodVeka = izracunajPeriodVeka(godina);
	  
	  if( periodVeka==""){
			$scope.periodVekaIzracunat="";
			$scope.vekIzracunat="";
			return;
	  }
		
      $scope.periodVekaIzracunat =periodVeka;
      var vek = izracunajVek(godina);
      $scope.vekIzracunat =vek+ ".";
  };

$scope.unetPocetakPerioda = function(){
    if($scope.pocetakPerioda == "")
    {
		$scope.pocetakPeriodaPoruka = "";
		return;
	}
	var godina = parseInt($scope.pocetakPerioda);
	if(isNaN(godina))
	{
		$scope.pocetakPeriodaPoruka  = "";
		return;
	}
	var periodVeka = izracunajPeriodVeka(godina);
	var vek = izracunajVek(godina);
	$scope.pocetakPeriodaPoruka =$scope.tr.pocetak_perioda + vek +". " + $scope.tr.vek +", "+ periodVeka + ".";
};

$scope.unetKrajPerioda = function(){
    if($scope.krajPerioda == "")
    {
      $scope.krajPeriodaPoruka = "";
      return;
	}
	var godina = parseInt($scope.krajPerioda);
	if(isNaN(godina))
	{
		$scope.krajPeriodaPoruka = "";
		return;
	}
	var periodVeka = izracunajPeriodVeka(godina);
	var vek = izracunajVek(godina);
	
	var godina1 = parseInt($scope.pocetakPerioda);
	if(!isNaN(godina1)){
		if(godina1>godina){
			$scope.krajPeriodaPoruka = $scope.tr.greska_period;
			return;
			}
	}
	
	$scope.krajPeriodaPoruka =$scope.tr.kraj_perioda + vek +". " + $scope.tr.vek +", "+ periodVeka + ".";
};

$scope.posalji_podatke=function(){
		if($scope.LokalizovanPodatak==false){
			$scope.mestoNalaska=null;
			$scope.grad=null;
			$scope.provincija=null;
		}
		
		if($scope.vreme=='nedatovan'){
			$scope.godinaPronalaska=null;
			$scope.vekPronalaska=null;
			$scope.periodVeka=null;
			$scope.pocetakPerioda=null;
			$scope.krajPerioda=null;
		}
		else if($scope.vreme =="godina"){
			$scope.vekPronalaska=null;
			$scope.periodVeka=null;
			$scope.pocetakPerioda=null;
			$scope.krajPerioda=null;
		}
		else if($scope.vreme =="unosVeka"){
			$scope.godinaPronalaska=null;
			$scope.pocetakPerioda=null;
			$scope.krajPerioda=null;
		}
		else if($scope.vreme =="unosPeriodaOdDo"){
			$scope.godinaPronalaska=null;
			$scope.vekPronalaska=null;
			$scope.periodVeka=null;
		}

	    var formData = {
			oznaka : $scope.oznaka,
			jezikUpisa : $scope.jezikUpisa,
			natpis : $scope.natpis,
			vrstaNatpisa : $scope.vrstaNatpisa,
			LokalizovanPodatak : $scope.LokalizovanPodatak,
			provincija : $scope.provincija,
			grad : $scope.grad,
			mestoNalaska : $scope.mestoNalaska,
			modernoImeDrzave : $scope.modernoImeDrzave,
                        modernoMesto: $scope.modernoMesto,
			trenutnaLokacijaZnamenitosti : $scope.trenutnaLokacijaZnamenitosti,
			pleme : $scope.pleme,
			vreme : $scope.vreme,
			godinaPronalaska : $scope.godinaPronalaska,
			vekPronalaska : $scope.vekPronalaska,
			periodVeka : $scope.periodVeka,
			pocetakPerioda : $scope.pocetakPerioda,
			krajPerioda : $scope.krajPerioda,
			tipZnamenitosti : $scope.tipZnamenitosti,
			materijalZnamenitosti : $scope.materijalZnamenitosti,
			sirina : $scope.sirina,
			visina : $scope.visina,
			duzina : $scope.duzina,
			bibliografskoPoreklo: $scope.bibliografskoPoreklo,
			bibliografskoPorekloSkracenica: $scope.bibliografskoPorekloSkracenica,
			komentar: $scope.komentar,
			fotografije: $scope.fotografije,
			fazaUnosa:$scope.fazaUnosa,
			korisnickoIme:$scope.korisnik
	 }
	 
	 console.log($cookies.user);
	 
	var jsonData = angular.toJson(formData);
	alert(jsonData);
	}
	
$scope.proveri_jedinstvenost = function(){
	var oznaka = $scope.oznaka;
	$http.get('../server/objekat.php?type=jedinstena_oznaka&oznaka="'+oznaka+'"', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null"){
			if(data.isEmpty==false){
				$scope.greska = $scope.tr.greska_jedinstvena_oznaka;
				}
			else 
				$scope.greska="";
			}
	}).
    error(function(data, status, headers, config){

    });
}	
}]);
console.info("Inicijalizovan unosController");