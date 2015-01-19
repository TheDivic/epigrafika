angular.module('epigrafikaModul').controller('adminProvincije', ['$scope', '$http','$window', function ($scope, $http,$window){
    
    $scope.provincije= null;
    $scope.izmeni = [];
    $scope.tmp=null;//pomocna za ponistavanje
    $scope.one=false; //moze da se edituje samo jedna provoncija
	
	//funkcija koja salje zahtev za brisanje provincije iz baze, sa prosledjenim id-em provincije
    $scope.obrisiProvinciju=function($pid){
		if($window.confirm('Da li ste sigurni da želite da obrišete provinciju?')) {
		$http.delete('../server/provincije.php?id='+$pid)
        .success(function (data, status, headers, config)
        {	
            //$window.alert(data.poruka);
            $window.location.reload();
        })
        .error(function (data, status, headers, config)
        {
          
        });
        
      } else {
      }
        
		
    }
	
	//funkcija koja salje zahtev da azurira odgovarajuci red u bazi
    $scope.sacuvajIzmene=function($pid, $naziv, $pocetak, $kraj)
    {
	if($scope.one==true){
	var params = {
	    naziv: $naziv,
	    pocetak: $pocetak,
	    kraj: $kraj
	};
	var data = angular.toJson(params);
	$http.put('../server/provincije.php?id='+$pid, data )
	.success(function (data, status, headers, config)
	{
            if(data.error_status==false)
                $window.alert("Objekat je uspesno ažuriran.");
	    else
                $window.alert("Greška! Objekat nije ažuriran.");
	})
	.error(function (data, status, headers, config)
	{
          
	});
	$scope.izmeni[$pid]=false;
	$scope.one=false;
	$scope.tmp=null;
	$route.reload();
	} 
    }
	//funkcija koja cuva vrednosti polja pre izmene
	$scope.izmeniIkona=function($pid, $naziv, $pocetak, $kraj){
		if($scope.one==false){
		$scope.tmp={	naziv: $naziv,
						pocetak: $pocetak,
						kraj: $kraj
					};
			$scope.izmeni[$pid]=true;
			$scope.one=true;
		
		}
		
	}
	//funkcija koja ponistava izmene	
	$scope.ponistiIzmenu=function($pid,$naziv, $pocetak, $kraj){
		if($scope.one==true && $scope.tmp!=null){
			for(var i=0;i<$scope.provincije.length;i++){
				if($scope.provincije[i].id==$pid){
					$scope.provincije[i].naziv=$scope.tmp.naziv;
					$scope.provincije[i].pocetak=$scope.tmp.pocetak;
					$scope.provincije[i].kraj=$scope.tmp.kraj;}}
			$scope.izmeni[$pid]=false;
			$scope.one=false;
			$scope.tmp=null;
			
			
		}
	}
	
	//submit funkcija koja ubacuje novu provinciju u bazu
	$scope.submit= function($naziv, $pocetak,$kraj){
	var params = {
	    naziv: $naziv,
	    pocetak: $pocetak,
	    kraj: $kraj
	};
	var data = angular.toJson(params);
	$http.post('../server/provincije.php', data )
	.success(function (data, status, headers, config)
	{
            if(data.error_status==false){
				$window.location.reload();
                $window.alert("Objekat uspesno unesen.");
			}
			else
                $window.alert("Greška! Objekat nije ažuriran.");
	})
	.error(function (data, status, headers, config)
	{
          
	});}
 
    $scope.offset = 0;
    var pageLimit = 10;
    $scope.pageNumber = 1;
    $scope.remainingResults = 0;

    $scope.nextPage = function() {
        if($scope.remainingResults > 0){
            $scope.offset += pageLimit;
            $scope.pageNumber += 1;
            getProvincije();
        }
    };

    $scope.previousPage = function() {
        if($scope.pageNumber > 1){
            $scope.offset -= pageLimit;
            $scope.pageNumber -= 1;
            getProvincije();
        }
    };

    var getProvincije = function() {
        //trazi se lista svih provincija od servera
        $http.get('../server/provincije.php?offset=' + $scope.offset, {responseType: 'JSON'}).
        success(function(data, status, headers, config){
            if(data!=="null") {
                $scope.provincije=data.data;
                $scope.remainingResults = data.remaining;
            }
        }).
        error(function(data, status, headers, config){
            console.error(data);
        });
    };

    getProvincije();

	if( $scope.provincije!=null){
		foreach(p in provincije)
			$scope.izmeni[p.id]=false;
		}
	

}]);
console.info("Inicijalizovan adminProvincije.");
