<?php
session_start();
if(!isset($_SESSION['privilegije'])) {
    header('Location: ../client/pocetna.php');
    exit;
}
else if($_SESSION['privilegije']!=="admin") {
    header('Location: ../client/index.php');
    exit;
}
include 'header-admin.php'; ?>
<script src="static/scripts/config.js"></script>
<div class="container">
	<h2>Konfiguracija sajta</h2>
	<form class="form-horizontal" name="configForm" role="form" ng-controller="configController">
	<class="row">
		<div class="form-group" ng-repeat="p in podesavanja">
			<label for="p.naziv" class="col-sm-4 control-label">{{p.naziv}}</label>
			<div class="col-sm-3">
				<input class="form-control" type="text" id="p.naziv" name="p.naziv" ng-model="p.vrednost" ng-required="true" />
			</div>
		</div>
	</div>
	<div class="row">
		<div class="form-group">
		<div class="col-sm-3 col-sm-offset-2">
			<button type="submit" ng-click="submit()" class="btn btn-success btn-block" > Sacuvaj </button>
		</div>
		<div class="col-sm-3">
			<button type="reset" ng-click="reset()" class="btn btn-primary btn-block" > Ponisti </button>
		</div>
		</div>
	</div>
  </form>

</div>


<?php include 'footer.php'; ?>