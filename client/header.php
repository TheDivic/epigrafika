<!DOCTYPE html>
<html ng-app>
    <head>
		<title>  Epigrafika </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
        <script src='script/angular.min.js' type='text/javascript' > </script>
		<script src="script/forme.js" type='text/javascript'> </script>
        <script src="script/jquery-1.11.1.js" type='text/javascript'></script>
		<script src="script/bootstrap.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
    </head>
    <body>
		<nav class="navbar navbar-default">
			<div class="container-fluid" ng-controller='headerController' >
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Epigrafika</a>
				</div>
				<ul class="nav navbar-nav navbar-left">
					<li><a href="index.php" class="btn btn-default"><span class="glyphicon glyphicon-home"></span></a></li> <!--Home-->
				<!--	<li><a href="" class="btn btn-default"><span class="glyphicon glyphicon-search"></span>  </a></li> <!--search-->
				</ul>
				<div class="nav navbar-nav navbar-right" ng-hide="logged" >
					<form class="navbar-form form-inline">
						<div class="form-group">
							<label class="sr-only" for="usr">Email:</label>
							<input type="text" class="form-control " id="usr" placeholder="Korisnicko ime" />
						</div>
						<div class="form-group">
							<label class="sr-only" for="pwd">Password:</label>
							<input type="password" class="form-control" id="pwd" placeholder="Sifra" />
						</div>
						<button type="submit" class="btn btn-default">Login</button>
						<a href="zaboravljena.php" class="btn btn-link">Zaboravljenja sifra?</a>
						<a href="registracija.php" class="btn btn-link">Registracija</a>
					</form>
				</div>
				
				<ul class="nav navbar-nav navbar-right" ng-show="logged">
					<li><a href="Admin/index.php" class="btn btn-default"><span class="glyphicon glyphicon-user"> </span> Admin</a></li>
					<li><a href="#" class="btn btn-default">Logout </a></li>
				</ul>
			</div>
		</nav>
		
		
        
