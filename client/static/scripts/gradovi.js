angular.module('epigrafikaModul').controller('adminGradovi', ['$scope', '$http','$window', function ($scope, $http,$window){
    
    $scope.gradovi= null;
    $scope.izmeni = [];
    $scope.tmp=null;//pomocna za ponistavanje
    $scope.one=false; //moze da se edituje samo jedan grad
	
	//funkcija koja salje zahtev za brisanje gradovi iz baze, sa prosledjenim id-em gradovi
    $scope.obrisi=function($id){
		if($window.confirm('Da li ste sigurni?')) {
		$http.delete('../server/gradovi.php?id='+$id)
        .success(function (data, status, headers, config)
        {	
			$window.location.reload();
            $window.alert(data.poruka);
			
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
	$http.put('../server/gradovi.php?id='+$id, data )
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
			for(var i=0;i<$scope.gradovi.length;i++){
				if($scope.gradovi[i].id==$id)
					$scope.gradovi[i].naziv=$scope.tmp.naziv;
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
	$http.post('../server/gradovi.php', data )
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
 
	//trazi se lista svih gradova od servera
    $http.get('../server/gradovi.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
        $scope.gradovi=data.data;
		
    }).
    error(function(data, status, headers, config){
    });
	if( $scope.gradovi!=null){
		foreach(g in gradovi)
			$scope.izmeni[g.id]=false;
		}
	

}]);
console.info("Inicijalizovan adminGradovi.");
