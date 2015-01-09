angular.module('epigrafikaModul').controller('adminProvincije', ['$scope', '$http','$window', function ($scope, $http,$window){
    
    $scope.provincije= null;
	$scope.izmeni = [];
	$scope.tmp=null;//pomocna za ponistavanje
	$scope.one=false; //moze da se edituje samo jedna provoncija
	
	//funkcija koja salje zahtev za brisanje provincije iz baze, sa prosledjenim id-em provincije
	$scope.obrisiProvinciju=function($pid){

		$http.delete('../server/provincije.php?id='+$pid)
        .success(function (data, status, headers, config)
        {
			alert(data.poruka);
        })
        .error(function (data, status, headers, config)
        {
          
        });
		
		}
	
	//funkcija koja salje zahtev da azurira odgovarajuci red u bazi
	$scope.sacuvajIzmene=function($pid){
		if($scope.one==true){
		 $window.alert("TODO: Azuriranje!!!");
		 $scope.izmeni[$pid]=false;
		 $scope.one=false;
		} 
		}
	
	$scope.izmeniIkona=function($pid){
		if($scope.one==false){
		 $scope.izmeni[$pid]=true;
		 $scope.one=true;
		 /*
		 foreach(p in $scope.provincije){
			if(p.id==$pid)
				$scope.tmp=angular.copy(p);
		 }  */
		}
		
	}
		
	$scope.ponistiIzmenu=function($pid){
		if($scope.one==true){
			$window.alert("TODO: Ponisti izmenu!!!");
			$scope.izmeni[$pid]=false;
			$scope.one=false;
			/*
			foreach(p in $scope.provincije){
				if(p.id==$pid)
				$scope.provincija=angular.copy($scope.tmp);
		 }	
			$scope.tmp=null; */
			
		}
	}
 
	//trazi se lista svih provincija od servera
    $http.get('../server/provincije.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
        $scope.provincije=data.data;
		
    }).
    error(function(data, status, headers, config){
    });
	if( $scope.provincije!=null){
		foreach(p in provincije)
			$scope.izmeni[p.id]=false;
		}
	

}]);
console.info("Inicijalizovan adminProvincije.");
