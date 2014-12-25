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
                    