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
    $scope.fazaUnosa="nekompletno";
    $scope.greska=false;
    $scope.provincije= null;
    $scope.drzave=null;
    $scope.gradovi=null;
    $scope.vrsteNatpisa=null;
    $scope.mesta=null;
    $scope.korisnik=$cookies.user;
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
};

$scope.unetKrajPerioda = function(){
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
     fazaUnosa:$scope.fazaUnosa,
     korisnickoIme: "Mirko" //$scope.korisnik
 };

 console.log($cookies.user);

 var jsonData = angular.toJson(formData);
 alert(jsonData);

 $http.post('../server/objekat.php', jsonData,
    {responseType:'JSON',headers: {'content-type': 'application/json'}
}).
 success(function(data, status, headers, config){
    if(data!=="null")
        alert(data.status_text);
                //$scope.poruka=data.error_message;
            }).
 error(function(data, status, headers, config){

 });
 
 document.getElementById('reset').click();
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
console.info("Inicijalizovan unosController");