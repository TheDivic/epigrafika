<!DOCTYPE html>
<html ng-app='epigrafikaModul'>
    <head>
        <title>  Epigrafika </title>
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
        <link rel="stylesheet" type="text/css" href="static/css/bootstrap-theme.css">
		<link rel="stylesheet" type="text/css" href="static/css/style.css" />
    </head>
    <body ng-controller='rootController' ng-cloack>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Epigrafika</a>
                </div>
                <ul class="nav navbar-nav navbar-left">
                    <li><a href="index.php" class="btn btn-link"><span class="glyphicon glyphicon-home"></span></a></li> <!--Home-->
                </ul>
				<!-- meni koji se prikazuje ako korisnik nije ulogovan -->
                <div class="nav navbar-nav navbar-right" ng-hide="logged">
					<form class="navbar-form form-inline" id="loginForm" method="post" action="" enctype='multipart/form-data'>
						<div class="form-group">
							<input name="usr" ng-model="usr" type="text" class="form-control " id="usr" placeholder={{tr.korisnicko_ime}} />
						</div>
						<div class="form-group">
							<input name="pwd" ng-model="pwd" type="password" class="form-control" id="pwd" placeholder={{tr.sifra}} />
						</div>
						<button type="submit" ng-click="login(usr,pwd)"class="btn btn-default" >Login</button>
						<a href="zaboravljena.php" class="btn btn-link">{{tr.zaboravljena}}</a>
						<a href="registracija.php" class="btn btn-link">{{tr.registracija}}</a>
						<a href="#" class="btn btn-link dropdown dropdown-toggle" data-toggle="dropdown" aria-expanded="true">{{tr.jezici}} <b class="caret"></b></a>
						<div class="dropdown-menu">
							<button ng-click="changeTo('serbian')" type="button" class="btn btn-link menu-black"> <img src="static/img/rs.png" class="btn btn-link" alt="Srpski" title="Srpski"> Srpski </button><br/>
							<button ng-click="changeTo('english')" type="button" class="btn btn-link menu-black"> <img src="static/img/gb.png" class="btn btn-link" alt="English" title="English"> English </button>
						</div>
					</form>
				</div>
				<!-- meni koji se prikazuje ako je korisnik ulogovan -->
				<div class="nav navbar-nav navbar-right vertical-center" style="padding-top:10px;" ng-show="logged">
					<a href="admin.php" ng-show="admin"class="btn btn-success"><span class="glyphicon glyphicon-user"> </span> Admin</a>
					<a href="unos.php" ng-show="active" class="btn btn-info">{{tr.unesi_objekat}}</a>
					<a href="#" ng-click="logout()" class="btn btn-danger">Logout </a>
					<a href="#" class="btn btn-warning dropdown open dropdown-toggle" data-toggle="dropdown" aria-expanded="true">{{tr.jezici}} <b class="caret"></b></a>
						<div class="dropdown-menu">
							<button ng-click="changeTo('serbian')" type="button" class="btn btn-link menu-black"> <img src="static/img/rs.png" class="btn btn-link" alt="Srpski" title="Srpski"> Srpski </button><br/>
							<button ng-click="changeTo('english')" type="button" class="btn btn-link menu-black"> <img src="static/img/gb.png" class="btn btn-link" alt="English" title="English"> English </button>
						</div>
				</div> 
            </div>
        </nav>
        

        
