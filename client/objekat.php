<?php
session_start();
if(!isset($_SESSION['privilegije'])) {
    header('Location: ../client/pocetna.php');
    exit;
}
else if($_SESSION['privilegije']==="admin")
    include 'header.php';
else if($_SESSION['status']==="aktivan")
    include 'headerAktivan.php';
else
    include 'headerNeaktivan.php';

    if(!isset($_GET['id']))
    {
        header("Location: greska.php");
        exit();
    } 

?>

<div class="container" ng-controller="objekatController" ng-init="init(<?php echo $_GET['id']; ?>)"> 
	<div style="border: 2px solid #c0c0c0; margin-bottom: 20px; padding: 30px; border-radius: 20px">
		<div class="row">
			<div class="col-sm-6">
				<label class="control-label ispis" >{{ tr.osnovne_informacije }}</label> <br/>
				<label class="control-label">{{ tr.oznaka }} : </label> <span ng-if="!object.oznaka">{{tr.nepoznato}}</span> {{object.oznaka}} <br/>   
				<label class="control-label">{{tr.vrsta_natpisa}} :</label> <span ng-if="!object.vrstaNatpisa">{{tr.nepoznato}}</span> {{object.vrstaNatpisa}} <br/> 
				<label class="control-label">{{tr.jezik}} :</label> <span ng-if="!object.jezik">{{tr.nepoznato}}</span> {{object.jezik}} <br/>
				<label class="control-label">{{tr.pleme}} :</label> <span ng-if="!object.pleme">{{tr.nepoznato}}</span> {{object.plemeNaziv}} <br/>
				<br/> <label class="control-label ispis"> {{tr.tip_spomenika}} </label> <br/>
				<label class="control-label">{{tr.tip}} :</label> <span ng-if="!object.tip">{{tr.nepoznato}}</span> {{object.tip}} <br/> 
				<label class="control-label">{{tr.materijal}} :</label> <span ng-if="!object.materijali">{{tr.nepoznato}}</span> {{object.materijal}} <br/> 
				<label class="control-label">  {{tr.dimenzije}}: </label> <span ng-if="!object.dimenzije">{{tr.nepoznato}}</span> {{object.dimenzije}} <br/>	
				<br/> <label class="control-label"> {{tr.natpis}} :</label><br/> 
				<div style="border: 1px solid #c0c0c0; width: 100%; height: 100%; margin: 0; padding: 10px; border-radius: 10px">
					<span ng-if="!object.natpis">{{tr.nepoznato}}</span> <span style="word-wrap:break-word;">{{object.natpis}}</span>
				</div>
			</div>
			<div class="col-sm-6">
				<label class="control-label ispis" >{{ tr.lokacija }}</label> <br/>
				<label class="control-label">{{tr.izvorno_mesto_nastanka}} :</label> <span ng-if="!object.provincijaNalaska">{{tr.nepoznato}}</span> {{object.provincijaNalaska}} <br/> 
				<label class="control-label">{{tr.izvorni_grad}} :</label> <span ng-if="!object.gradNalaska">{{tr.nepoznato}}</span> {{object.gradNalaska}} <br/> 
				<label class="control-label">{{tr.moderno_mesto}} :</label> <span ng-if="!object.modernoMesto">{{tr.nepoznato}}</span> {{object.modernoMesto}} <br/> 
				<label class="control-label">{{tr.moderno_ime_drzave}} :</label> <span ng-if="!object.modernoImeDrzave">{{tr.nepoznato}}</span> {{object.modernoImeDrzave}} <br/> 
				<label class="control-label">  {{tr.trenutna_lokacija_znamenitosti}}: </label> <span ng-if="!object.trenutnaLokacijaZnamenitosti">{{tr.nepoznato}}</span> {{object.trenutnaLokacijaZnamenitosti}}<br/>
				<br/> <div id="map-canvas" style="width:100%;height:300px"></div>
			</div>
		</div>

	</div>	
	<div style="border: 2px solid #c0c0c0; margin-bottom: 20px; padding: 30px; border-radius: 20px">
		<div class="row">
			<div class="col-sm-6">
				<label class="control-label ispis" >{{ tr.bibliografski_podaci }}</label> <br/>
				<span ng-show="!bibliographyData.length">  {{tr.nema_podataka}} </span>
				<ul>
				<li ng-repeat="bib in bibliographyData"> {{bib['naslov']}} ({{bib['strana']}}) - <a href="{{bib['putanja']}}" target="_blank">(.PDF)</a></li>
				</ul>
			</div>
			<div class="col-sm-6">
				<label class="control-label ispis" >{{ tr.slike }}</label> <br/>
				<span ng-show="!imgList.length">  {{tr.nema_slika}} </span>
				<a ng-repeat="imgData in imgList" href="{{imgData['putanja']}}" target="_blank"> <img style="float:left;margin:10px;padding:0;width:100px;height:100px"  src="{{imgData['putanja']}}"/> </a>
			</div>
		</div>
	</div>
	<div style="border: 2px solid #c0c0c0; margin-bottom: 20px; padding: 30px; border-radius: 20px">
		<div class="row">
			<div class="col-sm-6">
				<label class="control-label ispis" >{{ tr.vreme }}</label> <br/>
				<label class="control-label">  {{tr.vreme}}: </label> {{object.vreme}} <br/>
			</div>
			<div class="col-sm-6">
				<label class="control-label ispis" >{{ tr.dodatne_info }}</label> <br/>
				<label class="control-label">  {{tr.datum_kreiranja}}: </label> {{object.datumKreiranja}} <br/>
				<label class="control-label">  {{tr.datum_poslednje_izmene}}: </label> {{object.datumPoslednjeIzmene}} <br/>
				<label class="control-label">  {{tr.komentar}}: </label> <span ng-if="!object.komentar">{{tr.nepoznato}}</span> {{object.komentar}} <br/>
			</div>
		</div>
	</div>
</div>

<!-- Google Maps API -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBArTJ-mPtJuBsGghbM2LHu-FAJpehXJLg"></script> <!-- Google Maps API -->

<!-- ucitavanje kontrolera -->
<script type="text/javascript" src="static/scripts/objekat.js"></script> 

<?php include 'footer.php'; ?>