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