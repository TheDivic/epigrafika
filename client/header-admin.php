<!DOCTYPE html>
<html ng-app='epigrafikaModul'>
    <head>
		<title>  Epigrafika Admin</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		
       <!-- eksterne biblioteke -->
        <script src='static/scripts/libs/angular.min.js' type='text/javascript' > </script>
        <script src="static/scripts/libs/jquery-1.11.1.js" type='text/javascript'></script>
        <script src="static/scripts/libs/bootstrap.js"></script>
        <script src="static/scripts/libs/cookies.js"></script>
        
        <!-- ucitavanje kontrolera -->
        <script src="static/scripts/translation.js" type="text/javascript"></script>
        <script src="static/scripts/header.js" type='text/javascript'> </script>  
        
        <link rel="stylesheet" type="text/css" href="static/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="static/css/bootstrap-theme-admin.css">
		<link rel="stylesheet" type="text/css" href="static/css/style.css">
    </head>
    <body>
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">Epigrafika Admin</a>
				</div>
				<ul class="nav navbar-nav navbar-left">
					<li><a href="admin.php" class="btn btn-link"><span class="glyphicon glyphicon-home"></span></a></li> <!--Home-->
					<li><a href="korisnici.php" class="btn btn-link">Korisnici</a></li>
					<li><a href="lokacije.php" class="btn btn-link">Lokacije</a> <li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="registracija.php" class="btn btn-link">Sajt</a></li>
					<li><a href="#" class="btn btn-link">Logout </a></li>
				</ul> 
			</div>
		</nav>
		
		
        
