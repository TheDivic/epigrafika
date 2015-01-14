<?php 
    if(!isset($_GET['id']))
    {
        header("Location: greska.php");
        exit();
    }
    
    include 'header.php';
?>

<div class="container" ng-controller="objekatController" ng-init="init(<?php echo $_GET['id']; ?>)"> 
	<div style="border: 2px solid #c0c0c0; margin-bottom: 20px; padding: 30px; border-radius: 20px">
		<div class="row">
			<legend> {{ tr.osnovne_informacije }} </legend>
			<div class="col-sm-4">
				<label class="control-label">{{ tr.oznaka }} : </label> {{object.oznaka}} <br/>   
				<label class="control-label">{{tr.vrsta_natpisa}} :</label> {{object.vrstaNatpisa}} <br/> 
				<label class="control-label">{{tr.jezik}} :</label> {{object.jezik}} <br/>
				<br/> <label class="control-label">{{tr.natpis}} :</label><br/> 
			</div>
			<div class="col-sm-4">
				<label class="control-label">{{tr.tip}} :</label> {{object.tip}} <br/> 
				<label class="control-label">{{tr.materijal}} :</label> {{object.materijal}} <br/> 
				<label class="control-label">  {{tr.dimenzije}}: </label> {{object.dimenzije}} <br/>	
			</div>
		</div>
		<div style="border: 1px solid #c0c0c0; width: 100%; height: 100%; margin: 0; padding: 10px; border-radius: 10px">
			<span>{{object.tekstNatpisa}}</span>
		</div>
	</div>
	
	<div style="border: 2px solid #c0c0c0; margin-bottom: 20px; padding: 30px; border-radius: 20px">
		<div class="row">
			<legend> {{ tr.lokacija }} </legend>
			<div class="col-sm-6">
				<label class="control-label">{{tr.provincija}} :</label> {{object.provincija}} <br/> 
				<label class="control-label">{{tr.grad}} :</label> {{object.grad}} <br/> 
				<label class="control-label">{{tr.izvorno_mesto_nastanka}} :</label> {{object.provincija}} <br/> 
				<label class="control-label">{{tr.moderno_ime_drzave}} :</label> {{object.modernaDrzava}} <br/> 
				<label class="control-label">{{tr.moderno_mesto}} :</label> {{object.modernoMesto}} <br/> 
				<label class="control-label">  {{tr.trenutna_lokacija_znamenitosti}}: </label> {{object.ustanova}}<br/>
			</div>
			<div class="col-sm-6">
				<div id="map-canvas" style="width:100%;height:300px"></div>
			</div>
		</div>
	</div>
	<div style="border: 2px solid #c0c0c0; margin-bottom: 20px; padding: 30px; border-radius: 20px">
		<div class="row">
			<legend> {{ tr.dodatne_info }} </legend>
			<div class="col-sm-6">
				<label class="control-label">  {{tr.vek}}: </label> {{object.pocetakVek}} - {{object.krajVek}}<br/>
				<label class="control-label">  {{tr.godina}}: </label> {{object.pocetakGodina}} - {{object.krajGodina}} <br/>
				<label class="control-label">  {{tr.datum_kreiranja}}: </label> {{object.datumKreiranja}} <br/>
				<label class="control-label">  {{tr.datum_poslednje_izmene}}: </label> {{object.datumPoslednjeIzmene}} <br/>
				<label class="control-label">  {{tr.komentar}}: </label> {{object.komentar}} <br/>
			</div>
			<div class="col-sm-6">
				<label class="control-label">  {{tr.slike}}: </label> <span ng-show="!imgUriList.length">  {{tr.nema_slika}} </span> <br/>
				<img style="float:left;margin:10px;padding:0;" ng-repeat="imgUri in imgUriList" src="{{imgUri['putanja']}}"/>
			</div>
		</div>
	</div>
</div>

<!-- ucitavanje kontrolera -->
<script type="text/javascript" src="static/scripts/objekat.js"></script> 

<!-- Sve skripte vezane za mapu -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBArTJ-mPtJuBsGghbM2LHu-FAJpehXJLg"></script> <!-- Google Maps API -->

<?php include 'footer.php'; ?>