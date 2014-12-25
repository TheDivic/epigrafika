function posaljiPodatke(){
                        var fields = $("#myForm").serializeArray();
                        var podaci = new Object();
                        jQuery.each( fields, function(i, field ) {
                            podaci[ field.name] = field.value;
                         });
                        var formData = JSON.stringify(podaci);
                        alert("hahahahah");
                        
                        $.ajax({
                            url: "http://localhost:8080/PhpProject1/server.php",
                            type: "get",
                            dataType: "json",
                            data: formData,
                            success: function(book_data, statusText, jqxhr){

                               

                            },
                            error: function(result, statusText, jqxhr){
                                
                            }

                        });
                    }
                 </script>
                <script type='text/javascript'>
                    function formControllerPretraga($scope){
                        $scope.oznaka='';
                        $scope.modernoImeDrzave="";
                        $scope.provincijaNalaska="";
                        $scope.natpisArguments=false;
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
                    
                     function formControllerUnos($scope){
                        $scope.oznaka='';
                        
                        
                        
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
					
function headerController($scope)
{
	$scope.logged=true;
}
                    