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
        <script src="static/scripts/libs/ui-bootstrap-tpls-0.9.0.min.js"></script>
        <!-- ucitavanje kontrolera -->
        <script src="static/scripts/translation.js" type="text/javascript"></script>
        <script src="static/scripts/header.js" type='text/javascript'> </script>  
        
        <link rel="stylesheet" type="text/css" href="static/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="static/css/bootstrap-theme-admin.css">
        <link rel="stylesheet" type="text/css" href="static/css/style.css">
    </head>
    <body ng-controller="rootController">
		<nav class="navbar navbar-default">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="admin.php">Epigrafika Admin</a>
				</div>
				<ul class="nav navbar-nav navbar-left">
					<li><a href="admin.php" class="btn btn-link"><span class="glyphicon glyphicon-home"></span></a></li> <!--Home-->
					<li><a href="znamenitosti.php" class="btn btn-link">Znamenitosti</a></li>
					<li><a href="korisnici.php" class="btn btn-link">Korisnici</a></li>
					<li><a href="provincije.php" class="btn btn-link">Provincije</a> <li>
					<li><a href="natpisi.php" class="btn btn-link">Natpisi</a> <li>
					<li><a href="gradovi.php" class="btn btn-link">Gradovi</a> <li>
				</ul>
				
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php" class="btn btn-link">Sajt</a></li>
					<li><a href="../server/logout.php"  class="btn btn-link">Logout </a></li>
					<li><a href="config.php" class="btn btn-link"><span class="glyphicon glyphicon-cog"></span></a></li>
				</ul> 
			</div>
		</nav>
		
		
        
