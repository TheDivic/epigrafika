angular.module('epigrafikaModul').controller('adminNatpisi', ['$scope', '$http','$window', function ($scope, $http,$window){
    
    $scope.natpisi= null;
    $scope.izmeni = [];
    $scope.tmp=null;//pomocna za ponistavanje
    $scope.one=false; //moze da se edituje samo jedan natpis
	
	//funkcija koja salje zahtev za brisanje natpisi iz baze, sa prosledjenim id-em natpisi
    $scope.obrisi=function($id){
		if($window.confirm('Da li ste sigurni?')) {
		$http.delete('../server/vrsta_natpisa.php?id='+$id)
        .success(function (data, status, headers, config)
        {	
			$window.location.reload();
            //$window.alert(data.poruka);
			
        })
        .error(function (data, status, headers, config)
        {
          
        });
        
      } else {
      }
        
		
    }
	
	//funkcija koja salje zahtev da azurira odgovarajuci red u bazi
    $scope.sacuvaj=function($id, $naziv)
    {
	if($scope.one==true){
	var params = {
	    naziv: $naziv
	};
	var data = angular.toJson(params);
	$http.put('../server/vrsta_natpisa.php?id='+$id, data )
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
	$scope.izmeni[$id]=false;
	$scope.one=false;
	$scope.tmp=null;
	$route.reload();
	} 
    }
	//funkcija koja cuva vrednosti polja pre izmene
	$scope.izmeni=function($id, $naziv){
		if($scope.one==false){
		$scope.tmp={	naziv: $naziv
					};
			$scope.izmeni[$id]=true;
			$scope.one=true;
		
		}
		
	}
	//funkcija koja ponistava izmene	
	$scope.ponisti=function($id,$naziv){
		if($scope.one==true && $scope.tmp!=null){
			for(var i=0;i<$scope.natpisi.length;i++){
				if($scope.natpisi[i].id==$id)
					$scope.natpisi[i].naziv=$scope.tmp.naziv;
		}
			$scope.izmeni[$id]=false;
			$scope.one=false;
			$scope.tmp=null;
			
			
		}
	}
	
	//submit funkcija koja ubacuje novi red u bazu
	$scope.submit= function($naziv){
	var params = {
	    naziv: $naziv
	};
	var data = angular.toJson(params);
	$http.post('../server/vrsta_natpisa.php', data )
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
    $scope.remaining = 0;

    $scope.nextPage = function() {
        if($scope.remaining > 0){
            $scope.offset += pageLimit;
            $scope.pageNumber += 1;
            getNatpisi();
        }
    };

    $scope.previousPage = function() {
        if($scope.pageNumber > 1){
            $scope.offset -= pageLimit;
            $scope.pageNumber -= 1;
            getNatpisi();
        }
    };

    var getNatpisi = function() {
        //trazi se lista svih natpis od servera
        $http.get('../server/vrsta_natpisa.php?offset=' + $scope.offset, {responseType: 'JSON'}).
        success(function(data, status, headers, config){
            if(data!=="null") {
                $scope.natpisi=data.data;
                $scope.remaining = data.remaining;
            }
        }).
        error(function(data, status, headers, config){
            console.error(data);
        });
    };

    getNatpisi();

    if( $scope.natpisi!=null){
      foreach(n in natpisi)
      $scope.izmeni[n.id]=false;
  }
	

}]);
console.info("Inicijalizovan adminNatpisi.");
