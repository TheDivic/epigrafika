<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/pretraga.js"></script>
<script src="static/scripts/slanjePodatakaServeru.js"></script>

<!-- Bootstrap slider -->
<link rel="stylesheet" type="text/css" href="static/css/bootstrap-slider.css">
<script src="static/scripts/libs/bootstrap-slider.js"></script>

<div class="container" ng-controller='pretragaController' ng-cloak>

<!-- Tab menu -->
	<ul id="myTab" class="nav nav-tabs">
        <li class="active">
			<a id="tab-btn-pretraga" href="#pretraga" data-toggle="tab">{{tr.pretraga}} &nbsp; <span class="glyphicon glyphicon-search"></span> </a>
        </li>
        <li>
			<a id="tab-btn-mapa" href="#mapa" data-toggle="tab">{{tr.mapa}} </a>
        </li>
		 <li  class="nav navbar-right search_hide"> 
                     <span ng-click="prikazi=!prikazi" ng-show="prikazi"> {{tr.sakrij}} &nbsp; <b class="caret-up"></b></span><span ng-click="prikazi=!prikazi" ng-hide="prikazi"> {{tr.prikazi}} &nbsp; <b class="caret"></b></span>
		</li>
    </ul>

	
	<div id="myTabContent" class="tab-content ">
		<!--Pretraga tab -->
        <div class="tab-pane fade in active col-sm-12" id="pretraga" >
			
			<form class="form-horizontal" action=""  name='formPretraga'  id="myForm" method="post" enctype='multipart/form-data' autocomplete="off" ng-show="prikazi" >
			<div class="row">
				<h1> {{tr.pretraga}}</h1>
			</div>
                        <div class="fieldset_border">
				<fieldset>
					<legend> {{ tr.osnovne_informacije }} </legend>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-1">
							<label for="oznaka" class="control-label">{{ tr.oznaka }}: </label>
						</div>
						<div class="col-sm-9">
							<input class="form-control" id="oznaka" type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-pattern="/^[a-zA-Z0-9]+$/" />  
							<span class="text-transparent" ng-class="{textred:(formPretraga.oznaka.$error.maxlength||formPretraga.oznaka.$error.pattern) && formPretraga.oznaka.$dirty}">
                                                            {{ tr.oznaka_error_length }}{{tr.format_error_slova_cifre}}
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-1">
							<label for="natpis" class="control-label">{{ tr.natpis }}: </label>
						</div>
						<div class="col-sm-3">
							<input class="form-control" id="natpis" type="text" name="natpis" ng-change="autocompleteNatpis()" ng-model="natpis"/>
							<!-- Dropdown za autocomplete -->
							<ul class="autocomplete-dropdown" ng-show="show_natpis_autocomplete" role="menu">
								<a ng-repeat="predlog in natpisPredlozi" ng-click="upisiPredlogNatpis($event)"><li>{{ predlog }}</li></a>
							</ul>
						</div>
						<div class="col-sm-3">
							<select class="form-control" name="natpisArg" ng-model="natpisArg" >
								<option value="prazno" ng-value="prazno"> </option>
								<option value="and" ng-value="and"> AND </option>
								<option value="or" ng-value="or"> OR </option>
								<option value="andNot" ng-value="andNot"> AND NOT </option>
							</select>
						</div>
						<div class="col-sm-3">
							<input class="form-control" type="text" name="natpis2" ng-model="natpis2" ng-disabled="!(natpisArg!='prazno')" ng-class="{border_transparent:!(natpisArg!='prazno')}" /> <br/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-9">
							<label><input type="checkbox" ng-model="rezimIgnorisanjaZagrada" name="rezimIgnorisanjaZagrada" value="rezimIgnorisanjaZagrada"> {{ tr.ignorisi_zagrade }} </label>
						</div>
					</div>
				</fieldset>
			</div> <br/>
			<div class="fieldset_border">
				<fieldset>
					 <legend> {{ tr.izvorno_mesto_nastanka }} </legend>
					<div class="row">
						<div class="col-sm-6" >
							<div class="row">
								<div class="col-sm-offset-2 col-sm-2">
									<label for="provincijaNalaska" class="control-label">{{tr.provincija}}: </label>
								</div>
								<div class="col-sm-8">
									<select id="provincijaNalaska" class="form-control" name="provincijaNalaska" ng-model="provincijaNalaska" >
										<option ng-repeat="provincija in provincije | orderBy:'naziv':false"> {{ provincija.naziv }} </option>
									</select>
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-sm-offset-2 col-sm-2">
									<label for="gradNalaska" class="control-label">{{tr.grad}}: </label>
								</div>
								<div class="col-sm-8">
									<input class="form-control" type="text" name="gradNalaska" ng-model="gradNalaska" ng-change="autocompleteGrad()" ng-pattern="/^[a-zA-Z ]+$/"/>
									<!-- Dropdown za autocomplete -->
									<ul class="autocomplete-dropdown" ng-show="show_grad_autocomplete" role="menu">
										<a ng-repeat="predlog in gradPredlozi" ng-click="upisiPredlogGrad($event)"><li>{{ predlog }}</li></a>
									</ul>
									<span class="text-transparent" ng-class="{textred:formPretraga.gradNalaska.$dirty &&formPretraga.gradNalaska.$error.pattern}"> 
												{{tr.format_error_slova}}
									</span>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-offset-2 col-sm-2">
									<label for="mestoNalaska" class="control-label"> {{tr.mesto}}: </label>
								</div>
								<div class="col-sm-8">
									 <input class="form-control" type="text" name="mestoNalaska" ng-model="mestoNalaska" ng-change="autocompleteMesto()" ng-pattern="/^[a-zA-Z ]+$/"/>
									 <!-- Dropdown za autocomplete -->
									<ul class="autocomplete-dropdown" ng-show="show_mesto_autocomplete" role="menu">
										<a ng-repeat="predlog in mestoPredlozi" ng-click="upisiPredlogMesto($event)"><li>{{ predlog }}</li></a>
									</ul>
									<span class="text-transparent" ng-class="{textred:formPretraga.mestoNalaska.$dirty &&formPretraga.mestoNalaska.$error.pattern}"> 
												{{tr.format_error_slova}}
									</span>
								</div>
							</div>
       
		
    
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-4">
									<label for="modernoImeDrzave" class="control-label">{{tr.moderno_ime_drzave}}: </label>
								</div>
								<div class="col-sm-6">
									<select class="form-control" id="modernoImeDrzave" name="modernoImeDrzave" ng-model="modernoImeDrzave">
										<option ng-repeat="drzava in drzave | orderBy:'naziv':false"> {{drzava.naziv}} </option>
									</select>
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-sm-4">
									<label for="modernoMesto" class="control-label">{{tr.moderno_mesto}} </label>
								</div>
								<div class="col-sm-6">
									<select id="modernoMesto" class="form-control" name="modernoMesto" ng-model="modernoMesto">
										<option ng-repeat="mesto in mesta | orderBy:'naziv':false"> {{mesto.naziv}} </option>
									</select> 
								</div>
							</div>
							<br/>
							<div class="row">
								<div class="col-sm-4">
									<label for="pleme" class="control-label">{{tr.pleme}}:</label>
								</div>
								<div class="col-sm-6">
									<select id="pleme" class="form-control" name="pleme" ng-model="pleme">
										<option ng-repeat="p in plemena | orderBy:'naziv':false"> {{p.naziv}} </option>
									</select>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-6">
							<label><input type="checkbox" name="prikaziNelokalizovanePodatke" ng-model="prikaziNelokalizovanePodatke" value="prikaziNelokalizovanePodatke"> {{ tr.prikazi_nelokalizovane_podatke}}  </label>
						</div>
					</div>
				</fieldset>
			</div> <br/>
			<div class="fieldset_border">
				 <fieldset>
					<legend> {{tr.vreme}} </legend>
						<div class="row">
							<div class="col-sm-offset-1 col-sm-1">
								<label class="control-label" for="vek">{{tr.vek}}:</label>
							</div>
							<div class="col-sm-3">
								<input id="vek" class="form-control" type="text" name="vek" ng-model="vek" ng-pattern="/^\d+$/"/>
								<span class="text-transparent" ng-class="{textred:formPretraga.vek.$error.pattern &&formPretraga.vek.$dirty}">
										{{tr.pattern_error_cifre}}
								</span>	
							</div>
							<div class="col-sm-offset-1 col-sm-2">
								<label ng-show="!formPretraga.vek.$error.pattern && vek!=null && vek!=''" class="radio-inline" > <input type="radio" name="periodVeka" ng-model="periodVeka" value="prvaPolovinaVeka"/> {{tr.prva_polovina}} </label>
							</div>
							<div class="col-sm-2">
								<label ng-show="!formPretraga.vek.$error.pattern && vek!=null && vek!=''" class="radio-inline"> <input type="radio" name="periodVeka" ng-model="periodVeka" value="drugaPolovinaVeka"/>  {{tr.druga_polovina}}</label>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-offset-1 col-sm-4">
								<label>  <input type="checkbox" name="" value="prikaziNedatovaneNatpise" ng-model="prikaziNedatovaneNatpise"> {{tr.prikazi_nedatovane_natpise}} </label>
							</div>
						</div>
				</fieldset>
			</div> <br/>
			<div class="fieldset_border">
				<fieldset>
					<legend> {{tr.sortiraj_rezultate_po}} </legend>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-3">
							<label><input type="radio" name="sortiranje" ng-model="sortiranje" value="poVremenu"  ng-checked="true"/> {{tr.vremenu}} </label>
						</div>
						<div class="col-sm-3">
							<label><input type="radio" name="sortiranje" ng-model="sortiranje" value="poMestuNalaska" /> {{tr.mestu_nalaska}} </label>
						</div>
						<div class="col-sm-3">
							<label><input type="radio" name="sortiranje" ng-model="sortiranje" value="poVrstiNatpisa" /> {{tr.vrsti_natpisa}} </label>
						</div>
					</div>
				</fieldset>
			</div>
			<br/>
			<div class="row">
				<div class="col-sm-4 col-sm-offset-2">
					 <button type="submit" class="btn btn-success btn-block" ng-class="{'disabled':!formPretraga.$valid}" ng-click="posalji_podatke()" ng-enabled='formPretraga.$valid'> {{tr.zapocni_pretragu}}  </button>
				</div>
				<div class="col-sm-4 ">
					<button type="reset" id="reset" class="btn btn-primary btn-block">{{tr.resetuj_podatke}}</button>
				</div>
			</div>
 
			</form>

		</div>
		<!-- tab mapa -->
		 <div class="tab-pane fade" id="mapa" ng-controller='mapSearchController'>
			<h1>Mapa</h1>
            <div id="map-container" ng-show="prikazi">
                <div id="map-canvas"></div>
                <br/>
                <div class="row">
                  <div class="col-md-2">
                    <select class="form-control input-sm" ng-model="city" ng-options="city.naziv as city.naziv for city in cities | orderBy:'naziv':false"></select>
                  </div>
                  <div class="col-md-4">
                    <input type="text" id="radius" data-slider-id="map-slider" data-slider-min="1" data-slider-max="100" data-slider-step="0.1" data-slider-value="10"></input>
                  </div>
                  <div class="col-md-2">
                    <button type="button" class="btn btn-success btn-block" ng-click="radiusSearch()">{{tr.zapocni_pretragu}}</button>
                  </div>
                </div>
			</div>
        </div>
	
	</div>
	<!-- rezultati -->
        <div ng-show="!prikazi">
            <div id="rezultati" >
                    <h1> {{tr.rezultati_pretrage}}</h1>
                    
                    <div class="row" ng-repeat="rezultat in rezultatPretrage" style="border: 2px solid #c0c0c0; padding: 30px; border-radius: 20px">
                        <div class="col-sm-4">
                        <label class="control-label ispis" >{{ tr.osnovne_informacije }}</label> <br/>
                        <label class="control-label">{{ tr.oznaka }} : </label>  {{rezultat.oznaka}} <br/>    
                        <label class="control-label">{{tr.natpis}} :</label> {{rezultat.natpis}} <br/> 
                        <label class="control-label">{{tr.vrsta_natpisa}} :</label> {{rezultat.vrstaNatpisa}} <br/> 
                        <label class="control-label">{{tr.jezik}} :</label> {{rezultat.jezik}} <br/>
                        <label class="control-label ispis" >  {{tr.lokacija}}</label> <br/>
                        <label class="control-label">{{tr.provincija}} :</label> {{rezultat.provincijaNalaska}} <br/> 
                        <label class="control-label">{{tr.grad}} :</label> {{rezultat.gradNalaska}} <br/> 
                        <label class="control-label">{{tr.izvorno_mesto_nastanka}} :</label> {{rezultat.mestoNalaska}} <br/> 
                        <label class="control-label">{{tr.moderno_ime_drzave}} :</label> {{rezultat.modernoImeDrzave}} <br/> 
                        <label class="control-label">{{tr.moderno_mesto}} :</label> {{rezultat.modernoMesto}} <br/> 
                        <label class="control-label">  {{tr.trenutna_lokacija_znamenitosti}}: </label>{{rezultat.ustanova}} <br/>

                        </div>
                        <div class="col-sm-4">
                        <label class="control-label ispis">  {{tr.tip_spomenika}}</label> <br/>
                        <label class="control-label">{{tr.tip}} :</label> {{rezultat.tip}} <br/> 
                        <label class="control-label">{{tr.materijal}} :</label> {{rezultat.materijal}} <br/> 
                        <label class="control-label">  {{tr.dimenzije}}: </label>{{rezultat.dimenzije}} <br/>

                        <label class="control-label ispis">  {{tr.dodatne_info}}</label> <br/>
                        <label class="control-label">  {{tr.vreme}}: </label> {{rezultat.vreme}} <br/>
                        <label class="control-label">  {{tr.komentar}}: </label>{{rezultat.komentar}} <br/>

                        <a href="" style="font-size: 18px;"> {{tr.vise_informacija}} </a>
                        </div>
                        <div class="col-sm-4">
                            slika!!!
                        </div>
                    </div>

            <!--paginacija-->
                    <div class="row">
                        <div class="text-center">
                            <ul class="pagination pagination-sm">
                                    <li class="disabled"><a href="#">«</a></li>
                                    <li class="active"><a href="#">1</a></li>
                                    <li><a href="#">»</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
</div>

<!-- Sve skripte vezane za mapu -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBArTJ-mPtJuBsGghbM2LHu-FAJpehXJLg"></script> <!-- Google Maps API -->
<script type="text/javascript" src="static/scripts/map/gmaps.js"></script> <!-- Google Maps Wrapper -->
<script type="text/javascript" src="static/scripts/map/pretraga.js"></script> <!-- Map Search Controller -->

<?php include 'footer.php'; ?>