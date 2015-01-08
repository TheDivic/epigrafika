angular.module('epigrafikaModul').controller('adminProvincijeLista', ['$scope', '$http','$window', function ($scope, $http,$window){
    
    $scope.provincije= null;
	$scope.izmeni = [];
	$scope.tmp=null;//pomocna za ponistavanje
	$scope.one=false; //moze da se edituje samo jedna provoncija
	$scope.obrisiProvinciju=function($pid){
		 $window.alert("TODO: Brisanje!!!");
		}
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
console.info("Inicijalizovan pretragaController.");

angular.module('epigrafikaModul').controller('adminProvincijeNova', ['$scope', '$http', function ($scope, $http){
    
    $scope.provincije= null;
 
	//trazi se lista svih provincija od servera
    $http.get('../server/provincije.php', {responseType: 'JSON'}).
    success(function(data, status, headers, config){
        if(data!=="null")
        $scope.provincije=data.data;
    }).
    error(function(data, status, headers, config){
    });

}]);