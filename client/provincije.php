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
<!-- ucitavanje kontrolera -->
<script src="static/scripts/provincije.js"></script>
<script src="static/scripts/slanjePodatakaServeru.js"></script>


<div class="container">

<!-- Tab menu -->
	<ul id="myTab" class="nav nav-tabs">
        <li class="active"><a href="#pregled" data-toggle="tab">Pregled &nbsp; <span class="glyphicon glyphicon-list"></span> </a>
        </li>
        <li><a href="#nova" data-toggle="tab">Nova &nbsp; <span class="glyphicon glyphicon-plus"></span></a>
        </li>
    </ul>
<!-- Sadrzaj tabova-->
	<div id="myTabContent" class="tab-content" ng-controller="adminProvincije" ng-cloak>
		<!--Pregled tab -->
        <div class="tab-pane fade in active col-sm-12" id="pregled"><br/><br/>
		<form class="form" id="izmenaForm" name="izmenaForm" method="get" action="">
            <table class="table table-striped hover">
                <thead>
                    <tr class="success row">
						<th>ID</th>
						<th>NAZIV</th>
						<th>POCETAK</th>
						<th>KRAJ</th>
						<th>IZMENI</th>
						<th>OBRISI</th>
					</tr>
                </thead>
                <tbody>
                    <tr ng-repeat="provincija in provincije" ng-class-even="'success'" class="row">
						<td class="col-sm-1"><p>{{ provincija.id }}</p></td>
						<td class="col-sm-3"><input class="izmenaInput" ng-show="izmeni[provincija.id]" form="izmenaForm" type="text" name="naziv" ng-model="provincija.naziv" id="naziv" ng-required="true" required /><p ng-hide="izmeni[provincija.id]" >{{ provincija.naziv }}</p></td>
						<td class="col-sm-3"><input ng-show="izmeni[provincija.id]" form="izmenaForm" type="text" name="naziv" ng-model="provincija.pocetak" id="naziv" ng-required="true" required /><p ng-hide="izmeni[provincija.id]">{{ provincija.pocetak }}</p></td>
						<td class="col-sm-3"><input ng-show="izmeni[provincija.id]" form="izmenaForm" type="text" name="naziv" ng-model="provincija.kraj" id="naziv" ng-required="true" required /><p ng-hide="izmeni[provincija.id]">{{ provincija.kraj }}</p></td>
						<td class="col-sm-1 text-center" ><span ng-click="izmeniIkona(provincija.id, provincija.naziv, provincija.pocetak, provincija.kraj)" ng-hide="izmeni[provincija.id]" class="glyphicon glyphicon-pencil"></span><span ng-click="sacuvajIzmene(provincija.id, provincija.naziv, provincija.pocetak, provincija.kraj)" ng-show="izmeni[provincija.id]" class="glyphicon glyphicon-ok-sign"></span></td>
						<td class="col-sm-1 text-center"><span ng-click="obrisiProvinciju(provincija.id)" ng-hide="izmeni[provincija.id]" class="glyphicon glyphicon-remove"></span><span ng-click="ponistiIzmenu(provincija.id,provincija.naziv, provincija.pocetak, provincija.kraj)" ng-show="izmeni[provincija.id]" class="glyphicon glyphicon-remove-sign"></span></td>
					</tr>
                </tbody>
            </table>
			</form>
				<!-- paginacija -->
			<div class="text-center">
				<ul class="pagination pagination-sm">
					<li ng-class="{disabled: pageNumber <= 1}"><a href="#" ng-click="previousPage()">«</a></li>
					<li class="active"><a href="#">{{pageNumber}}</a></li>
					<li ng-class="{disabled: remainingResults <= 0}"><a href="#" ng-click="nextPage()">»</a></li>
				</ul>
			</div>
        </div>
		<!-- Nova tab -->
        <div class="tab-pane fade" id="nova">
			<h1> Unos nove provincije</h1>
			<form class="form" name="novaProvincija" method="get" action="">
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label for="nazivn" class="control-label"> Naziv <span style="color:red">*</span></label>
							<input type="text" name="nazivn" ng-model="nazivn" class="form-control" id="nazivn" ng-required="true" placeholder="Naziv provincije" required />
							<span class="text-transparent" ng-class="{textred:novaProvincija.nazivn.$error.required && novaProvincija.nazivn.$dirty}">
								Ovo polje je obavezno!
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label for="pocetakn" class="control-label"> Pocetak <span style="color:red">*</span></label>
							<input type="text" name="pocetakn" ng-model="pocetakn" class="form-control" id="pocetakn" ng-required="true" placeholder="Pocetak" required />
							<span class="text-transparent" ng-class="{textred:novaProvincija.pocetakn.$error.required && novaProvincija.pocetakn.$dirty}">
								Ovo polje je obavezno!
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-8">
						<div class="form-group">
							<label for="krajn" class="control-label"> Kraj <span style="color:red">*</span></label>
							<input type="text" name="krajn" ng-model="krajn" class="form-control" id="krajn" ng-required="true" placeholder="Kraj" required />
							<span class="text-transparent" ng-class="{textred:novaProvincija.krajn.$error.required && novaProvincija.krajn.$dirty}">
								Ovo polje je obavezno!
							</span>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<button type="button" ng-click="submit(nazivn,pocetakn,krajn)" class="btn btn-success btn-block" ng-class="{'disabled':!novaProvincija.$valid}" ng-enabled="novaProvincija.$valid"> Unesi </button>
					</div>
					<div class="col-sm-4">
						<button type="reset" class="btn btn-primary btn-block" > Ponisti </button>
					</div>
				</div>
			</form>
        </div>
    </div>
	


</div> <!-- Container end -->






<?php include 'footer.php'?>