<!DOCTYPE html>
<html ng-app>
    <head>
		<title>  Epigrafika </title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
        <script src='script/angular.min.js' type='text/javascript' > </script>
		<script src="script/forme.js" type='text/javascript'> </script>
        <script src="script/jquery-1.11.1.js" type='text/javascript'></script>
		<script type='text/javascript' src="./script/KontroleriZaUnosIPretragu.js"></script>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    </head>
    <body>
		<nav class="navbar navbar-default">
			<div class="container-fluid" ng-controller='headerController' >
				<div class="navbar-header">
					<a class="navbar-brand" href="#">Epigrafika</a>
				</div>
				<!--
				<div class="nav navbar-nav navbar-right" ng-hide=true >
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
						<a href="#" class="btn btn-link">Zaboravljenja sifra?</a>
						<a href="#" class="btn btn-link">Registracija</a>
					</form>
				</div>
				-->
				<div class="nav navbar-nav navbar-right" ng-show="logged">
					<a href="#" class="btn btn-primary">Admin</a>
					<a href="#" class="btn btn-danger">Logout</a>
				</div>
			</div>
		</nav>
		
		
        
