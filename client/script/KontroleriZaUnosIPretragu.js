function formControllerPretraga($scope, $http){
                        $scope.oznaka='';
                        $scope.modernoImeDrzave="";
                        $scope.provincijaNalaska="";
                        $scope.natpisArguments=false;
                        $scope.provincije= null;
                        $scope. drzave=null;
                        
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
                    
                    
          
                    }
                        
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
                                   return "druga polovina ";
                              else  return "prva polovina ";
                          
                    }
                    
                     function formControllerUnos($scope, $http){
                        $scope.oznaka='';
                        $scope.provincije= null;
                        $scope.drzave=null;
                        $scope.gradovi=null;
                        $scope.vrsteNatpisa=null;
                        
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
                    
                        $http.get('../server/gradovi.php', {responseType: 'JSON'}).
                            success(function(data, status, headers, config){
                                if(data!=="null")
                                        $scope.gradovi=data.data;
                                    }).
                            error(function(data, status, headers, config){

                            });
                    
                        $http.get('../server/vrstaNatpisa.php', {responseType: 'JSON'}).
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
                          $scope.periodVekaIzracunat =periodVeka;
                          var vek = izracunajVek(godina);
                          $scope.vekIzracunat =vek+ ".";
                        };
                        
                        $scope.unetPocetakPerioda = function(){
                          if($scope.pocetakPerioda == "")
                          {
                              $scope.vekPocetkaIzracunat = "";
                              $scope.periodVekaPocetkaIzracunat = "";
                              return;
                          }
                          var godina = parseInt($scope.pocetakPerioda);
                          var periodVeka = izracunajPeriodVeka(godina);
                          $scope.periodVekaPocetkaIzracunat ="Pocetak perioda je " + periodVeka;
                          var vek = izracunajVek(godina);
                          $scope.vekPocetkaIzracunat =vek+ ". veka.";
                          
                        };
                        
                        $scope.unetKrajPerioda = function(){
                          if($scope.krajPerioda == "")
                          {
                              $scope.vekKrajaIzracunat = "";
                              $scope.periodVekaKrajaIzracunat = "";
                              return;
                          }
                          var godina = parseInt($scope.krajPerioda);
                          var periodVeka = izracunajPeriodVeka(godina);
                          $scope.periodVekaKrajaIzracunat ="Kraj perioda je " + periodVeka;
                          var vek = izracunajVek(godina);
                          $scope.vekKrajaIzracunat =vek+ ". veka.";
                        };
                    }
                    
                    function formControllerRegistration($scope){
                        $scope.username='';
			$scope.password='';
			$scope.passwordR='';
			$scope.email='';
			$scope.info='';
			$scope.sameR='false';
			$scope.same=function(){
                            if($scope.password==$scope.passwordR)
                                {
				$scope.sameR='false';
                                }
                            else{
				$scope.sameR='true';
                                }
                            }
                    }
                    
                    
