<?php
session_start();
if(!isset($_SESSION['privilegije'])) {
    header('Location: ../client/pocetna.php');
    exit;
}
else if($_SESSION['privilegije']!=="admin") {
    header('Location: ../client/greska.php');
    exit;
}
include 'header-admin.php';?>
<script src="static/scripts/admin.js"> </script>
<div class="container" ng-controller="adminChart">
<script src="static/scripts/amcharts.js" type="text/javascript"></script>
<script src="static/scripts/serial.js" type="text/javascript"></script>
<div class="col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Novi korisnici</h3>
		</div>
		<div class="panel-body" id="chartdiv1" style="padding:3px;background-color:white; width: 100%; height: 500px;">
		
		</div>
	</div>
	</div>
	<div class="col-sm-6">
	<div class="panel panel-success">
		<div class="panel-heading">
			<h3 class="panel-title">Nove znamenitosti</h3>
		</div>
		<div class="panel-body" id="chartdiv2" style="padding:3px;background-color:white; width: 100%; height: 500px;">
			
		</div>
	</div>
	</div>
	
</div>
<?php include 'footer.php';?>