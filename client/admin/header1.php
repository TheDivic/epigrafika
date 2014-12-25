<!DOCTYPE html>
<html ng-app>
	<head>
		<title>  Epigrafika </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<link href="bootstrap.css" rel="stylesheet"> </link>
        <script type='text/javascript' src='angular.min.js' > </script>
        <script type='text/javascript'>
            function formControllerRegistration($scope){
                        $scope.username='';
						$scope.password='';
						$scope.passwordR='';
						$scope.email='';
						$scope.info='';
						$scope.sameR='false';
						$scope.same=function(){
							if($scope.password==$scope.passwordR){
								$scope.sameR='false';}
							else{
								$scope.sameR='true';}
						}
            }
			function formControllerPretraga($scope){
                        $scope.oznaka='';
            }
                    
            function formControllerUnos($scope){
                        $scope.oznaka='';
            }
        </script>
    </head>
    <body>
	<div class="container">
		<nav class="navigation" aria-label="menu" role="navigation">
			<ul>
				<li><a href="index.php" aria-level="1">Home</a></li>
				<li><a href="pretraga.php" aria-level="2">Pretraga</a></li>
				<li><a href="registration.php" aria-level="3">Registracija</a></li>
				<li><a href="/admin/index.php" aria-level="4">Admin</a></li>
		</ul>
	</nav>
