angular.module('epigrafikaModul').controller('adminZnamenitosti', ['$scope', '$http','$window', '$cookies',function ($scope, $http,$window,$cookies){
    
    $scope.znamenitosti= null;
	$scope.greska=false;
	$scope.single=null;
	/*//trazi se lista svih znamenitosti od servera
    $http.get('../server/objekat.php?type=all', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
        $scope.znamenitosti=data.data;
		
    }).
    error(function(data, status, headers, config){
    });
	*/
	//dohvatanje plemena
	$http.get('../server/pleme.php', {responseType: 'JSON'}).
		success(function(data, status, headers, config){
		if(data!=="null")
			$scope.plemena=data.data;
	}).
	error(function(data, status, headers, config){

	});
	//dohvatanje gradova
	$http.get('../server/gradovi.php', {responseType: 'JSON'}).
	success(function(data, status, headers, config){
		if(data!=="null")
		  $scope.gradovi=data.data;
	}).
	error(function(data, status, headers, config){

	});
	//dohvatanje vrste natpisa
	$http.get('../server/vrsta_natpisa.php', {responseType: 'JSON'}).
	success(function(data, status, headers, config){
		if(data!=="null")
		  $scope.vrsteNatpisa=data.data;
	}).
	error(function(data, status, headers, config){

	});
	//dohvatanje provincija
	$http.get('../server/provincije.php', {responseType: 'JSON'}).
	success(function(data, status, headers, config){
		if(data!=="null")
		  $scope.provincije=data.data;
	}).
	error(function(data, status, headers, config){

	});
	//dohvatanje modernih drzava
	$http.get('../server/moderna_drzava.php', {responseType: 'JSON'}).
	success(function(data, status, headers, config){
		if(data!=="null")
		  $scope.drzave=data.data;
	}).
	error(function(data, status, headers, config){

	});
	//dohvatanje modernih mesta
	$http.get('../server/moderno_mesto.php', {responseType: 'JSON'}).
	success(function(data, status, headers, config){
		if(data!=="null")
			$scope.mesta=data.data;
	}).
	error(function(data, status, headers, config){

	});

	//brisanje pojedinacne fotografije
	$scope.obrisiFoto= function($id){
	console.log($id);
	if($window.confirm('Da li ste sigurni?')) {
		$http.delete('../server/obrisi_fotografiju.php/'+$id)
                .success(function (data, status, headers, config)
                {
                    $window.alert(data.poruka);
					$window.location.reload();
                })
                .error(function (data, status, headers, config)
                {
          
                });
        
                } else { }
    };
	
	$scope.obrisiBibl= function($id,$str){
	if($window.confirm('Da li ste sigurni?')) {
		$http.delete('../server/bibliografskipodatak.php/'+$id+'&'+$str)
                .success(function (data, status, headers, config)
                {
                    $window.alert(data.poruka);
					$window.location.reload();
                })
                .error(function (data, status, headers, config)
                {
          
                });
        
                } else { }
    };
	
    $scope.offset = 0;
    $scope.pageNumber = 1;
    $scope.remainingResults = 0;

    var getObjekat = function() {
        $http.get('../server/objekat.php?type=all&offset=' + $scope.offset, {responseType: 'JSON'}).
        success(function(data, status, headers, config){
            if(data!=="null") {
                $scope.znamenitosti=data.data;
                $scope.remainingResults = data.remaining;
            }
        }).
        error(function(data, status, headers, config){
            console.error(data);
        });
    };

	//trazi se lista svih natpis od servera
    $scope.nextPage = function() {
        if($scope.remainingResults > 0) {
            $scope.offset += 10;
            $scope.pageNumber += 1;
            getObjekat();
        }
    };

    $scope.previousPage = function() {
        if($scope.pageNumber > 1) {
            $scope.offset -= 10;
            $scope.pageNumber -= 1;
            getObjekat();
        }
    };

    getObjekat();
	//funkcija koja salje zahtev za brisanje natpisi iz baze, sa prosledjenim id-em natpisi
    $scope.obrisi=function($id){
		if($window.confirm('Da li ste sigurni?')) {
		$http.delete('../server/objekat.php/'+$id)
                .success(function (data, status, headers, config)
                {	
                    //$window.location.reload();
                    $window.alert(data.poruka);
                })
                .error(function (data, status, headers, config)
                {
          
                });
        
                } else { }
    };


	
	//funkcija koja salje zahtev da azurira odgovarajuci red u bazi
    $scope.sacuvaj=function()
    {
	if($scope.single.lokalizovano==false){
		$scope.single.mestoNalaska=null;
		$scope.single.gradNalaska=null;
		$scope.single.provincijaNalaska=null;
 }

	if($scope.single.nedatovano==0){
     $scope.single.pocetakGodina=null;
     $scope.single.pocetakVek=null;
     $scope.single.pocetakOdrednica=null;
     $scope.single.krajGodina=null;
     $scope.single.krajVek=null;
     $scope.single.krajOdrednica=null;
 }
 var formData = {
     oznaka : $scope.single.oznaka,
     jezikUpisa : $scope.single.jezik,
     natpis : $scope.single.natpis,
     vrstaNatpisa : $scope.single.vrstaNatpisa,
     LokalizovanPodatak : $scope.single.lokalizovano,
     provincija : $scope.single.provincijaNalaska,
     grad : $scope.single.gradNalaska,
     mestoNalaska : $scope.single.mestoNalaska,
     modernoImeDrzave : $scope.single.modernoImeDrzave,
     modernoMesto: $scope.single.modernoMesto,
     trenutnaLokacijaZnamenitosti : $scope.single.ustanova,
     pleme : $scope.single.plemeNaziv,
     vreme : $scope.single.datovano,
     pocetakGodina : $scope.single.pocetakGodina,
     pocetakVek: $scope.single.pocetakVek,
	 pocetakOdrednica:$scope.single.pocetakOdrednica,
	 krajGodina:$scope.single.krajGodina,
	 krajVek:$scope.single.krajVek,
	 krajOdrednica:$scope.single.krajOdrednica,
     tipZnamenitosti : $scope.single.tip,
     materijalZnamenitosti : $scope.single.materijal,
     sirina : $scope.single.sirina,
     visina : $scope.single.visina,
     duzina : $scope.single.duzina,
     bibliografskoPoreklo: $scope.single.bibliografskoPoreklo,
     bibliografskoPorekloSkracenica: $scope.single.bibliografskoPorekloSkracenica,
     bibliografskiPdfLinkovi : $scope.pdfLinkovi,
     komentar: $scope.single.komentar,
     fotografije: $scope.photoLinkovi,
     fazaUnosa:$scope.single.fazaUnosa,
	 idBibliografskogPodatka:$scope.single.idBibl,
	 id:$scope.single.id
 };

 var jsonData = angular.toJson(formData);
 alert(jsonData);

 $http.put('../server/objekat.php', jsonData,
    {responseType:'JSON',headers: {'content-type': 'application/json'}
}).
 success(function(data, status, headers, config){
    if(data!=="null")
				;//$window.location="znamenitosti.php";
            }).
 error(function(data, status, headers, config){

 });
 
	} 
   
	//funkcija koja cuva vrednosti polja pre izmene
	$scope.izmeni=function($id){
		$window.location.href="znamenitosti.php?id="+$id;
	}
	//funkcija koja ponistava izmene	
	$scope.ponisti=function(){
		$window.location.href="znamenitosti.php";
		
		}
	$scope.init= function(){
		var id=$window.location.href.split('=');
		//console.log(id[1]);
		$http.get('../server/objekat.php?type=byId&objectId='+id[1], {responseType: 'JSON'}).
                        success(function(data, status, headers, config){
                            if(data.error_status == false)
                            {
								if(!data.data)
                                    $window.location.replace("greska.php");
                                $scope.single=angular.copy(data.data);
								if($scope.single.lokalizovano == 0)
									$scope.single.lokalizovano=false;
								else
									$scope.single.lokalizovano=true;
								var tmp=$scope.single.dimenzije.split(':');
								$scope.single.sirina=tmp[0];$scope.single.visina=tmp[1]; $scope.single.duzina=tmp[2];
								if($scope.single.bibliografskiPodatci.length>0){
									$scope.single.bibliografskoPoreklo=$scope.single.bibliografskiPodatci[0].naslov;
									$scope.single.bibliografskoPorekloSkracenica=$scope.single.bibliografskiPodatci[0].skracenica;
									$scope.single.idBibl=$scope.single.bibliografskiPodatci[0].id}
								else{
									$scope.single.bibliografskoPoreklo=null;
									$scope.single.bibliografskoPorekloSkracenica=null;
									$scope.single.idBibl=null;}
								
								
								
                            }
                            else
                            {	
                                console.error(data.error_message);
                                window.location.replace("greska.php");
                            }     
                        }).
                        error(function(data, status, headers, config){
                            console.error(status);
                            window.location.replace("greska.php");
                    });
	}
	
	
	//sa unosa.js
	
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
    $scope.vekGodine=null;
    $scope.periodVekGodine=null;
    $scope.vekPronalaska=null;
    $scope.periodVeka=null;
    $scope.pocetakGodina=null;
    $scope.pocetakVek=null;
    $scope.pocetakPeriodVeka=null;
    $scope.krajGodina=null;
    $scope.krajVek=null;
    $scope.krajPeriodVeka=null;
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
    $scope.greska=false;
    $scope.provincije= null;
    $scope.drzave=null;
    $scope.gradovi=null;
    $scope.vrsteNatpisa=null;
    $scope.mesta=null;
    $scope.pdfLinkovi = [];
    $scope.photoLinkovi = [];
    $scope.pdfError = false;
    $scope.photoError = false;

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


$scope.unetaGodina = function(){
    if($scope.godinaPronalaska == "")
    {
      $scope.vekIzracunat = "";
      $scope.periodVekaIzracunat = "";
      return;
  }
  var godina = parseInt($scope.godinaPronalaska);  
  if( isNaN(godina)){
   $scope.periodVekaIzracunat="";
   $scope.vekIzracunat="";
   return;
}
var periodVeka = izracunajPeriodVeka(godina);
var vek = izracunajVek(godina);
$scope.periodVekaIzracunat =periodVeka;
$scope.periodVekGodine=periodVeka;
$scope.vekGodine=vek;
$scope.vekIzracunat =vek+ ".";
};

$scope.unetPocetakPerioda = function(){
	if($scope.single!=null)
	{
		if($scope.single.pocetakGodina == "")
		{
		  $scope.single.pocetakPeriodaPoruka = "";
		  return;
		}
		var godina = parseInt($scope.single.pocetakGodina);
		if(isNaN(godina))
		{
			$scope.single.pocetakPeriodaPoruka  = "";
			return;
		}
		var periodVeka = izracunajPeriodVeka(godina);
		var vek = izracunajVek(godina);
		$scope.single.pocetakVek=vek;
		$scope.single.pocetakOdrednica = periodVeka;
		$scope.single.pocetakPeriodaPoruka =$scope.tr.pocetak_perioda + $scope.single.pocetakVek +". " + $scope.tr.vek +", "+ $scope.single.pocetakOdrednica + ".";
	}
	else
	{
		if($scope.pocetakGodina == "")
		{
		  $scope.pocetakPeriodaPoruka = "";
		  return;
		}
		var godina = parseInt($scope.pocetakGodina);
		if(isNaN(godina))
		{
			$scope.pocetakPeriodaPoruka  = "";
			return;
		}
		var periodVeka = izracunajPeriodVeka(godina);
		var vek = izracunajVek(godina);
		$scope.pocetakVek=vek;
		$scope.pocetakPeriodVeka = periodVeka;
		$scope.pocetakPeriodaPoruka =$scope.tr.pocetak_perioda + vek +". " + $scope.tr.vek +", "+ periodVeka + ".";
	}
};

$scope.unetKrajPerioda = function(){
	if($scope.single!=null){
	    if($scope.single.krajGodina === "")
		{
			$scope.single.krajPeriodaPoruka = "";
			return;
		}
		var godina = parseInt($scope.single.krajGodina);
		if(isNaN(godina))
		{
			$scope.single.krajPeriodaPoruka = "";
			return;
		}
		var periodVeka = izracunajPeriodVeka(godina);
		var vek = izracunajVek(godina);
		$scope.single.krajVek=vek;
		$scope.single.krajOdrednica = periodVeka;
		var godina1 = parseInt($scope.pocetakGodina);
		if(!isNaN(godina1))
		{
			if(godina1>godina)
			{
				$scope.single.krajPeriodaPoruka = $scope.tr.greska_period;
				return;
			}
		}

		$scope.single.krajPeriodaPoruka =$scope.tr.kraj_perioda + $scope.single.krajVek +". " + $scope.tr.vek +", "+ $scope.single.krajOdrednica + ".";
	}
	else
	{
		if($scope.krajGodina === "")
		{
		  $scope.krajPeriodaPoruka = "";
		  return;
		}
		var godina = parseInt($scope.krajGodina);
		if(isNaN(godina))
		{
			$scope.krajPeriodaPoruka = "";
			return;
		}
		var periodVeka = izracunajPeriodVeka(godina);
		var vek = izracunajVek(godina);
		$scope.krajVek=vek;
		$scope.krajPeriodVeka = periodVeka;
		var godina1 = parseInt($scope.pocetakGodina);
		if(!isNaN(godina1))
		{
			if(godina1>godina)
			{
				$scope.krajPeriodaPoruka = $scope.tr.greska_period;
				return;
			}
		}

		$scope.krajPeriodaPoruka =$scope.tr.kraj_perioda + vek +". " + $scope.tr.vek +", "+ periodVeka + ".";
	}
};

$scope.submit=function(){
  if($scope.LokalizovanPodatak==false){
     $scope.mestoNalaska=null;
     $scope.grad=null;
     $scope.provincija=null;
 }

 if($scope.vreme=='nedatovan'){
     $scope.godinaPronalaska=null;
     $scope.vekPronalaska=null;
     $scope.periodVeka=null;
     $scope.pocetakGodina=null;
     $scope.krajGodina=null;
 }
 else if($scope.vreme =="godina"){
     $scope.vekPronalaska=null;
     $scope.periodVeka=null;
     $scope.pocetakGodina=null;
     $scope.krajGodina=null;
 }
 else if($scope.vreme =="unosVeka"){
     $scope.godinaPronalaska=null;
     $scope.pocetakGodina=null;
     $scope.krajGodina=null;
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
     vekGodine: $scope.vekGodine,
     periodVekGodine : $scope.periodVekGodine,
     vekPronalaska : $scope.vekPronalaska,
     periodVeka : $scope.periodVeka,
     pocetakGodina : $scope.pocetakGodina,
     pocetakVek: $scope.pocetakVek,
     pocetakPeriodVeka: $scope.pocetakPeriodVeka,
     krajGodina : $scope.krajGodina,
     krajVek : $scope.krajVek,
     krajPeriodVeka: $scope.krajPeriodVeka,
     tipZnamenitosti : $scope.tipZnamenitosti,
     materijalZnamenitosti : $scope.materijalZnamenitosti,
     sirina : $scope.sirina,
     visina : $scope.visina,
     duzina : $scope.duzina,
     bibliografskoPoreklo: $scope.bibliografskoPoreklo,
     bibliografskoPorekloSkracenica: $scope.bibliografskoPorekloSkracenica,
     bibliografskiPdfLinkovi : $scope.pdfLinkovi,
     komentar: $scope.komentar,
     fotografije: $scope.photoLinkovi,
     fazaUnosa:$scope.fazaUnosa
 };

 console.log($cookies.user);

 var jsonData = angular.toJson(formData);
 alert(jsonData);

 $http.post('../server/objekat.php', jsonData,
    {responseType:'JSON',headers: {'content-type': 'application/json'}
}).
 success(function(data, status, headers, config){
    if(data!=="null")
				//alert(data.status_text);
				$window.location.reload();
            }).
 error(function(data, status, headers, config){

 });
 
 //document.getElementById('reset').click();
};

$scope.proveri_jedinstvenost = function(){
	var oznaka = $scope.oznaka;
	$http.get('../server/objekat.php?type=jedinstena_oznaka&oznaka="'+oznaka+'"', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null"){
         if(data.isEmpty==false){
            $scope.greska = true;
        }
        else 
            $scope.greska=false;
    }
}).
    error(function(data, status, headers, config){

    });
};	

     $scope.autocompleteBibliografskiPodatak = function() {
        if($scope.bibliografskoPorekloSkracenica){
            $http.get('../server/autocomplete.php?type=biblio&key=' + $scope.bibliografskoPorekloSkracenica).
                success(function(data){
                    var response = angular.fromJson(data);

                    if(response.words){
                        $scope.biblioSkracenicaPredlozi = response.words;

                        $scope.biblioRecnik = [];
                        for(var i = 0; i < response.words.length; i++){
                            $scope.biblioRecnik[response.words[i]] = response.fullbiblio[i];
                        }

                        $scope.show_biblio_autocomplete = true;
                    }
                    else {
                        $scope.biblioSkracenicaPredlozi = [];
                        $scope.show_biblio_autocomplete = false;
                    }
                }).
                error(function(data){
                    console.log("Error");
                });
        }
        else {
            $scope.show_biblio_autocomplete = false;
            $scope.bibliografskoPoreklo = "";
        }
    };

    $scope.upisiPredlogBibliografskiPodatak = function($event){
        $scope.bibliografskoPorekloSkracenica = $event.target.innerHTML;
        $scope.bibliografskoPoreklo = $scope.biblioRecnik[$event.target.innerHTML];
        $scope.show_biblio_autocomplete = false;
    };


    var uploadFile = function(file, type) {
        var reader = new FileReader();

        reader.onload = function(evt) {
            var fd = new FormData();
            fd.append(type, file);

            $http.post("../server/upload.php", fd, {
                transformRequest: angular.identity,
                headers: {'Content-Type': undefined}
            })
            .success(function(link){
                if(type == "biblioPdf"){
                    $scope.pdfLinkovi.push(link);
                }
                else if(type == "photo"){
                    $scope.photoLinkovi.push(link);
                }
            })
            .error(function(error){
                console.error(error);
            });
        }

        reader.readAsBinaryString(file);
    };

    var checkType = function(fileType, reqType) {
        return fileType.indexOf(reqType) != -1;
    };

    $scope.handlePdfUpload = function(files){
        $scope.pdfError = false;
       
        if(files.length > 10){
            $scope.pdfError = true;
            return;
        }
		if($scope.single!=null){
			var loaded=$scope.single.bibliografskiPodatci.length;
			if(files.length + loaded > 10){
            $scope.pdfError = true;
            return;
			}
		}

        for(var i = 0; i < files.length; i++){
            if(!checkType(files[i].type, "pdf")){
                $scope.pdfError = true;
                $scope.$apply();
                return;
            }
        }

        if(!$scope.pdfError){
            for(var i = 0; i < files.length; i++){
                uploadFile(files[i], "biblioPdf");
            }
        }
    };

    $scope.handlePhotoUpload = function(files){
        $scope.photoError = false;
       
        if(files.length > 10){
            $scope.photoError = true;
            return;
        }
		
		if($scope.single!=null){
			var loaded=$scope.single.fotografije.length;
			if(files.length + loaded > 10){
            $scope.photoError = true;
            return;
			}
		}

        for(var i = 0; i < files.length; i++){
            if(!checkType(files[i].type, "image")){
                $scope.photoError = true;
                $scope.$apply();
                return;
            }
        }

        if(!$scope.photoError){
            for(var i = 0; i < files.length; i++){
                uploadFile(files[i], "photo");
            }
        }
    };

}]);
console.info("Inicijalizovan adminZnamenitosti.");
