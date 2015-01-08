<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/pretraga.js"></script>
<script src="static/scripts/slanjePodatakaServeru.js"></script>

<div class="container" ng-controller='pretragaController' ng-cloak>

<!-- Tab menu -->
	<ul id="myTab" class="nav nav-tabs">
        <li class="active">
			<a href="#pretraga" data-toggle="tab">{{tr.pretraga}} &nbsp; <span class="glyphicon glyphicon-search"></span> </a>
        </li>
        <li>
			<a href="#mapa" data-toggle="tab">{{tr.mapa}} </a>
        </li>
		 <li  class="nav navbar-right search_hide"> 
			<span ng-click="prikazi=!prikazi" ng-show="prikazi"> {{tr.sakrij}} &nbsp; <b class="caret-up"></b></span><span ng-click="prikazi=!prikazi" ng-hide="prikazi"> {{tr.prikazi}} &nbsp; <b class="caret"></b></span>
		</li>
    </ul>

	
	<div id="myTabContent" class="tab-content ">
		<!--Pretraga tab -->
        <div class="tab-pane fade in active col-sm-12" id="pretraga" >
			<div class="row">
				<h1> {{tr.pretraga}}</h1>
			</div>
			<form class="form-horizontal" action=""  name='formPretraga'  id="myForm" method="post" enctype='multipart/form-data' ng-show="prikazi" >
			<div class="fieldset_border">
				<fieldset>
					<legend> {{ tr.osnovne_informacije }} </legend>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-1">
							<label for="oznaka" class="control-label">{{ tr.oznaka }}<span style="color:red">*</span>: </label>
						</div>
						<div class="col-sm-9">
							<input class="form-control" id="oznaka" type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-required='true' required/>  
							<span class="text-transparent" ng-class="{textred:(formPretraga.oznaka.$error.required ||formPretraga.oznaka.$error.maxlength) && formPretraga.oznaka.$dirty}">
								{{tr.obavezno_polje}}  {{ tr.oznaka_error_length }}
							</span>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-1">
							<label for="natpis" class="control-label">{{ tr.natpis }}: </label>
						</div>
						<div class="col-sm-3">
							<input class="form-control" id="natpis" type="text" name="natpis" ng-model="natpis"/> 
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
							<input class="form-control" type="text" name="natpis2" ng-model="natpis2" ng-class="{border_transparent:!(natpisArg!='prazno')}" /> <br/>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-offset-1 col-sm-9">
							<label><input type="checkbox" ng-model="rezimIgnorisanjaZagrada" name="rezimIgnorisanjaZagrada" value="rezimIgnorisanjaZagrada"> {{ tr.ignorisi_zagrade }} </label>
						</div>
					</div>
				</fieldset>
			</div>
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
									<input class="form-control" type="text" name="gradNalaska" ng-model="gradNalaska" ng-pattern="/^[a-zA-Z ]+$/"/>
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
									 <input class="form-control" type="text" name="mestoNalaska" ng-model="mestoNalaska" ng-pattern="/^[a-zA-Z ]+$/"/>
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
			</div>
			<div class="fieldset_border">
				 <fieldset>
					<legend> {{tr.vreme}} </legend>
						<div class="row">
							<div class="col-sm-offset-1 col-sm-1">
								<label class="control-label" for="vek">{{tr.vek}}:</label>
							</div>
							<div class="col-sm-3">
								<input id="vek" class="form-control" type="text" name="vek" ng-model="vek" ng-pattern="/[0-9]+/"/>
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
			</div>
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
					 <button type="submit" class="btn btn-success btn-block" ng-class="{'disabled':!formPretraga.$valid}"value=ng-click="posalji_podatke()" ng-enabled='formPretraga.$valid'> {{tr.zapocni_pretragu}}  </button>
				</div>
				<div class="col-sm-4 ">
					<button type="reset" class="btn btn-primary btn-block">{{tr.resetuj_podatke}}</button>
				</div>
			</div>
 
			</form>

		</div>
		<!-- tab mapa -->
		 <div class="tab-pane fade" id="mapa">
			<h1> Mesto za mapu </h1>
	
	</div>
	<!-- rezultati -->
	<br/> <br/>
	<div id="rezultati">
		<h1> {{tr.rezultati_pretrage}}</h1>
		<div class="row" ng-repeat="rezultat in rezultatPretrage">
			{{rezultat}} 
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


<?php include 'footer.php'; ?>