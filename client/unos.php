<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/unos.js"></script>
<div class="container" ng-controller='unosController' ng-cloak>
	<form action=""  name='formUnos' method="post" enctype='multipart/form-data' class="form-horizontal">
	<div class="fieldset_border">
		<fieldset>
            <legend> {{tr.osnovne_informacije}} </legend>
			<div class="row form-group">
				<label for="oznaka" class="col-sm-2 control-label">{{tr.oznaka}}  <span style="color:red">*</span>:</label>
				<div class="col-sm-3">
					<input class="form-control" id="oznaka"type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-change="proveri_jedinstvenost()" ng-pattern="/^[a-zA-Z0-9]+$/" ng-required="true"/>				
				</div>
				<div class="col-sm-3">
					<label class="checkbox-inline">
						<input type="radio" name="jezikUpisa" ng-model="jezikUpisa" value="latinski" checked /> {{tr.latinski}}
					</label>
				</div>
				<div class="col-sm-3">
					<label class="checkbox-inline" >
						<input type="radio" name="jezikUpisa" ng-model="jezikUpisa" value="grcki"/>  {{tr.grcki}}
					</label>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-offset-2 col-sm-12">
					<span class="text-transparent" ng-class="{textred:formUnos.oznaka.$dirty && (formUnos.oznaka.$error.required||formUnos.oznaka.$error.pattern||formUnos.oznaka.$error.maxlenght)}">
						{{tr.oznaka_error_length}} {{tr.format_error_slova_cifre}} {{tr.obavezno_polje}}
                                        </span>
					<span class="text-transparent" ng-class="{textred:greska}">
					<span class='glyphicon glyphicon-remove'></span> 
                                        {{tr.greska_jedinstvena_oznaka}}
					</span>	
				</div>
			</div>
			<div class="row form-group">
				<label for="natpis" class="col-sm-2 control-label">{{tr.natpis}}  <span style="color:red">*</span>:</label>
				<div class="col-sm-9">
					<textarea  class="form-control textarea_unos" rows="2" id="natpis" ng-model="natpis" name="natpis" ng-required='true' ng-pattern="/^[a-zA-Z0-9 \. ]+$/"/> </textarea>	
					<span class="text-transparent" ng-class="{textred:formUnos.natpis.$dirty && (formUnos.natpis.$error.required || formUnos.natpis.$error.pattern)}">
						{{tr.obavezno_polje}} {{tr.format_error_slova_cifre_tacka}}
					</span>
				</div>
			</div>
			<div class="row form-group">
				<label for="vrstaNatpisa" class="col-sm-2 control-label">{{tr.vrsta_natpisa}}  <span style="color:red">*</span>:</label>
				<div class="col-sm-9">
					<select class="form-control" id="vrstaNatpisa" name="vrstaNatpisa" ng-model="vrstaNatpisa" ng-required='true'>
						<option ng-repeat="natpis in vrsteNatpisa  | orderBy:'naziv':false"> {{natpis.naziv}} </option>
					</select>
				</div>
			</div>
        </fieldset>
	</div> <br/>
	<div class="fieldset_border">
		<fieldset>
			<legend> {{tr.izvorno_mesto_nastanka}} </legend>
			<label ng-init="lokalizovan=true"> <input type="checkbox" name="LokalizovanPodatak" ng-model="LokalizovanPodatak" value="LokalizovanPodatak" ng-click="lokalizovan=!lokalizovan"  checked/> {{ tr.lokalizovan_podatak}} </label>
			<div class="row form-group" ng-show="lokalizovan">
				<label for="provincija" class="col-sm-1 control-label">{{tr.provincija}}<span style="color:red">*</span></label>
				<div class="col-sm-3">
					<select name="provincija" id="provincija" class="form-control" ng-model="provincija" ng-required="lokalizovan">
						<option ng-repeat="p in provincije  | orderBy:'naziv':false"> {{ p.naziv }} </option>
					</select>
				</div>
				<label for="grad" class="col-sm-1 control-label">{{tr.grad}} <span style="color:red">*</span>:</label>
				<div class="col-sm-3">
					<select id="grad" class="form-control" name="grad" ng-model="grad" ng-required="lokalizovan">
						<option ng-repeat="grad in gradovi | orderBy:'naziv':false"> {{grad.naziv}} </option>
					</select>
				</div>
				<label for="mestoNalaska" class="col-sm-1 control-label">{{tr.mesto}} <span style="color:red">*</span>:</label>
				<div class="col-sm-3 clirfix">
					<input id="mestoNalaska" class="form-control" type="text" name="mestoNalaska" ng-model="mestoNalaska" ng-required="lokalizovan" ng-pattern="/^[a-zA-Z ]+$/"/>
					<span class="text-transparent" ng-class="{textred: (formUnos.mestoNalaska.$error.pattern || formUnos.mestoNalaska.$error.required) && formUnos.mestoNalaska.$dirty}"> 
						{{tr.obavezno_polje}} {{tr.format_error_slova}}
					</span>
				</div>
			</div>
			<div class="row form-group">
				<label for="modernoImeDrzave" class="col-sm-1 control-label">{{tr.moderno_ime_drzave}} <span style="color:red">*</span>:</label>
				<div class="col-sm-3">
					<select id="modernoImeDrzave" class="form-control" name="modernoImeDrzave" ng-model="modernoImeDrzave" ng-required="true">
						<option ng-repeat="drzava in drzave  | orderBy:'naziv':false"> {{drzava.naziv}} </option>
					</select>
				</div>
				<label for="modernoMesto" class="col-sm-1 control-label">{{tr.moderno_mesto}} <span style="color:red">*</span>:</label>
				<div class="col-sm-3">
					<select id="modernoMesto" class="form-control" name="modernoMesto" ng-model="modernoMesto" ng-required="true">
						<option ng-repeat="mesto in mesta | orderBy:'naziv':false"> {{mesto.naziv}} </option>
					</select>
				</div>
			</div>	
		</fieldset>
	</div> <!-- end of fieldset-->
	<br/>
	<div class="fieldset_border">
		<br/>
		<div class="row form-group">
				<label for="trenutnaLokacijaZnamenitosti" class="col-sm-2 control-label">{{tr.trenutna_lokacija_znamenitosti}} <span style="color:red">*</span>:</label>
				<div class="col-sm-4">
					<input type="text" id="trenutnaLokacijaZnamenitosti" class="form-control" name="trenutnaLokacijaZnamenitosti" ng-model="trenutnaLokacijaZnamenitosti" ng-pattern="/^[a-zA-Z ]+$/" ng-required="true"/>
					<span class="text-transparent" ng-class="{textred:formUnos.trenutnaLokacijaZnamenitosti.$dirty && formUnos.trenutnaLokacijaZnamenitosti.$error.pattern}"> 
						{{tr.format_error_slova}}
					</span>
				</div>
				<label for="pleme" class="col-sm-2 control-label">{{tr.pleme}} <span style="color:red">*</span>:</label>
				<div class="col-sm-4">
					<input type="text" id="pleme" class="form-control" name="pleme" ng-model="pleme" ng-pattern="/^[a-zA-Z ]+$/" ng-required="true"/>
					<span class="text-transparent" ng-class="{textred:formUnos.pleme.$dirty && formUnos.pleme.$error.pattern}"> 
						{{tr.format_error_slova}}
					</span>
				</div>
			</div>
	</div> <!--end of fieldset -->
	<br/>
	<div class="fieldset_border">
		<fieldset>
			<legend> {{tr.vreme}} </legend>
			<div class="row">
				<label class="col-sm-2"> <input type="radio" name="vreme" ng-model="vreme" value="nedatovan" checked /> {{tr.nedatovan_natpis}}: </label>
			</div>
			<div class="row">
				<label class="col-sm-2"><input type="radio" name="vreme" ng-model="vreme" value="godina"/> {{tr.unesite_godinu}} : </label>
				<div class="form-group" ng-show="vreme=='godina'">
					<label for="godinaPronalaska" class="col-sm-1 control-label">{{tr.godina}}*:</label>
					<div class="col-sm-3">
						<input id="godinaPronalaska" type="text" class="form-control" name="godinaPronalaska" ng-model="godinaPronalaska" ng-change="unetaGodina()" ng-required='vreme=="godina"' ng-pattern="/^\d+$/"/>
						<span class="text-transparent" ng-class="{textred: formUnos.godinaPronalaska.$error.pattern &&formUnos.godinaPronalaska.$dirty}">
							{{tr.pattern_error_cifre}}
						</span>
					</div>
					<label class="control-label col-sm-2">{{tr.vek}} :  {{vekIzracunat}} </label>
					<label class="control-label col-sm-2">{{tr.vreme}}: {{periodVekaIzracunat}} </label>
				</div>
			</div>
			
			<div class="row">
				<label class="col-sm-2"> <input type="radio" name="vreme" ng-model="vreme" value="unosVeka"/> {{tr.unesite_vek}}:</label>
				<div class="form-group" ng-show="vreme=='unosVeka'">
					<label for="godinaPronalaska" class="col-sm-1 control-label">{{tr.vek}} *</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" name="vekPronalaska" ng-model="vekPronalaska" ng-required='vreme=="unosVeka"' ng-pattern="/^\d+$/"/> 
						<span class="text-transparent" ng-class="{textred: formUnos.vekPronalaska.$error.pattern &&formUnos.vekPronalaska.$dirty}">
							{{tr.pattern_error_cifre}}
						</span>
					</div>
					<label class="radio-inline col-sm-2"><input type="radio" name="periodVeka" ng-model="periodVeka" value="prvaPolovinaVeka"/> {{tr.prva_polovina}} </label>
					<label class="radio-inline col-sm-2"> <input type="radio" name="periodVeka" ng-model="periodVeka" value="drugaPolovinaVeka"/>  {{tr.druga_polovina}} </label>
				</div>
			</div>
			<div class="row clearfix">
				<label class="col-sm-2"><input type="radio" name="vreme" ng-model="vreme" value="unosPeriodaOdDo"/> {{tr.unesite_period}}: </label>
				<div class="form-group" ng-show="vreme=='unosPeriodaOdDo'">
					<label for="pocetakGodina" class="col-sm-1 control-label">{{tr.od}} *:</label>
					<div class="col-sm-3">
						<input class="form-control" id="pocetakGodina" type="text" ng-model="pocetakGodina" name="pocetakGodina" ng-change="unetPocetakPerioda()" ng-required='vreme=="unosPeriodaOdDo"' ng-pattern="/^\d+$/"/>
					</div>
					<label for="krajGodina" class="col-sm-1 control-label">{{tr.od}} *:</label>
					<div class="col-sm-3">
						<input type="text" id="krajGodina" class="form-control" ng-model="krajGodina" name="krajGodina" ng-change="unetKrajPerioda()" ng-required='vreme=="unosPeriodaOdDo"' ng-pattern="/^\d+$/"/> 
					</div>
				</div>
			</div>
			<div class="row">
				<span class="text-transparent col-sm-3" ng-class="{textred:(formUnos.pocetakGodina.$error.pattern || formUnos.krajGodina.$error.pattern) && (formUnos.pocetakGodina.$dirty || formUnos.krajGodina.$dirty)}">
					{{tr.pattern_error_cifre}}
				</span>
				<span class="col-sm-4" ng-show="vreme=='unosPeriodaOdDo'">
					{{pocetakPeriodaPoruka}}
				</span>
				<span class="col-sm-4" ng-show="vreme=='unosPeriodaOdDo'">
					{{krajPeriodaPoruka}} 
				</span>
			</div>
			
		</fieldset>
	</div> <!-- end of filedset-->
	<br/>
	<div class="fieldset_border">
		<fieldset>
			<legend>{{tr.informacije_o_znamenitosti}}</legend>
			<div class="row form-group">
				<label for="tipZnamenitosti" class="col-sm-2 control-label">{{tr.tip}}:</label>
				<div class="col-sm-6">
					<input id="tipZnamenitosti" class="form-control" type="text" name="tipZnamenitosti" ng-model="tipZnamenitosti" ng-pattern="/^[a-zA-Z ]+$/"/>
				</div>
				<span class="text-transparent col-sm-3" ng-class="{textred:formUnos.tipZnamenitosti.$dirty && formUnos.tipZnamenitosti.$error.pattern }"> 
					{{tr.format_error_slova}}
				</span>	
			</div>
			<div class="row form-group">
				<label for="materijalZnamenitosti" class="col-sm-2 control-label">{{tr.materijal}}: </label>
				<div class="col-sm-6">
					<input id="materijalZnamenitosti" class="form-control"type="text" name="materijalZnamenitosti" ng-model="materijalZnamenitosti" ng-pattern="/^[a-zA-Z ]+$/"/>
				</div>
				<span class="text-transparent col-sm-3" ng-class="{textred:formUnos.materijalZnamenitosti.$dirty  && formUnos.materijalZnamenitosti.$error.pattern  }"> 
					{{tr.format_error_slova}}
				</span>	
			</div>
			<div class="row form-group">
				<label for="sirina" class="col-sm-2 control-label">{{tr.sirina}}: </label>
				<div class="col-sm-6">
					 <input id="sirina" class="form-control" type="text" ng-model="sirina" name="sirina" ng-pattern="/^\d+(\.)?(\d{1,9})?$/"/> 
				</div>
				<span class="text-transparent col-sm-3" ng-class="{textred:formUnos.sirina.$dirty  && formUnos.sirina.$error.pattern}"> 
					{{tr.pattern_error_cifre}}
				</span>	
			</div>
			<div class="row form-group">
				<label for="visina" class="col-sm-2 control-label">{{tr.visina}}: </label>
				<div class="col-sm-6">
					 <input id="visina" class="form-control" type="text" ng-model="visina" name="visina" ng-pattern="/^\d+(\.)?(\d{1,9})?$/"/>  
				</div>
				<span class="text-transparent col-sm-3" ng-class="{textred:formUnos.visina.$dirty  && formUnos.visina.$error.pattern}"> 
					{{tr.pattern_error_cifre}}
				</span>	
			</div>
			<div class="row form-group">
				<label for="duzina" class="col-sm-2 control-label">{{tr.duzina}}: </label>
				<div class="col-sm-6">
					<input id="duzina" class="form-control" type="text" ng-model="duzina" name="duzina" ng-pattern="/^\d+(\.)?(\d{1,9})?$/"/>  
				</div>
				<span class="text-transparent col-sm-3" ng-class="{textred:formUnos.duzina.$dirty  && formUnos.duzina.$error.pattern}"> 
					{{tr.pattern_error_cifre}}
				</span>	
			</div>
		</fieldset>
	</div>
	<br/>	<!-- fieldset end -->
	<div class="fieldset_border">
		<fieldset>
			<legend> {{tr.dodatne_informacije}}</legend>
			<div class="row form-group">
				<label for="bibliografskoPoreklo" class="col-sm-2 control-label">{{tr.bibliografsko_poreklo}}:</label>
				<div class="col-sm-2">
					<input id="bibliografskoPoreklo" class="form-control" type="text" ng-model="bibliografskoPoreklo"/>
				</div>
				<label for="bibliografskoPorekloSkracenica" class="col-sm-3 control-label">{{tr.skracenica_bibliografskog_porekla}}:</label>
				<div class="col-sm-3">
					<input id="bibliografskoPorekloSkracenica" class="form-control" type="text" ng-change="autocompleteBibliografskiPodatak()" ng-model="bibliografskoPorekloSkracenica"/>
					<!-- Dropdown za autocomplete -->
					<ul class="autocomplete-dropdown" ng-show="show_biblio_autocomplete" role="menu">
						<a ng-repeat="predlog in biblioSkracenicaPredlozi" ng-click="upisiPredlogBibliografskiPodatak($event)"><li>{{ predlog }}</li></a>
					</ul>
				</div>
			</div>
			<div class="row form-group">
				<label for="bibl" class="col-sm-2 control-label">{{tr.dodaj_pdf}}:</label>
				<div class="col-sm-8">
                                    <input type="file" id="bibl" accept="application/pdf"  name="bibl" multiple onchange="angular.element(this).scope().handlePdfUpload(this.files)"  />
                                    <span ng-repeat="pdf in pdfLinkovi"> {{ pdf }} ;</span>
                                </div>
			</div>
			<div class="row form-group">
				<label for="komentar" class="col-sm-2 control-label">{{tr.komentar}}:</label>
				<div class="col-sm-8">
					<textarea  rows="2" id="komentar" class="form-control textarea_unos" name="komentar" ng-model="komentar" ng-pattern="/^[a-zA-Z0-9 \. ]+$/"/> </textarea>
					 <span class="text-transparent" ng-class="{textred: formUnos.komentar.$error.pattern && formUnos.komentar.$dirty}"> 
						{{tr.format_error_slova_cifre_tacka}}
					</span> 
				</div>
				
			</div>
			<div class="row form-group">
				<label for="foto" class="col-sm-2 control-label">{{tr.dodaj_fotografiju}}:</label>
				<div class="col-sm-8">
					<input type="file" id="foto" accept="image/*"  name="foto" multiple onchange="angular.element(this).scope().handlePhotoUpload(this.files)" />
					<span ng-repeat="photo in photoLinkovi"> {{ photo }} ;</span>
				</div>
			</div>
			<div class="row form-group">
				<label for="foto" class="col-sm-2 control-label">{{tr.trenutna_faza_unosa}}:</label>
				<div class="col-sm-8">
					<label class="radio-inline"><input type="radio" name="fazaUnosa" ng-model="fazaUnosa" value="nekompletno"/> {{tr.nekompletno}}</label>
					<label class="radio-inline"><input type="radio" name="fazaUnosa" ng-model="fazaUnosa" value="zaKontrolu"/> {{tr.za_kontrolu}} </label>
					<label class="radio-inline"><input type="radio" name="fazaUnosa" ng-model="fazaUnosa" value="objavljivanje"/> {{tr.objavljivanje}}</label>
				</div>
			</div>
		</fieldset>
	</div> <br/><!-- fieldset end -->
	<div class="row">
		<div class="col-sm-4 col-sm-offset-2">
			<button type="submit" class="btn btn-success btn-block" ng-class="{'disabled':!formUnos.$valid}" ng-click="posalji_podatke()" ng-enabled='formUnos.$valid'> {{tr.unesi_podatke}}  </button>
		</div>
		<div class="col-sm-4 ">
			<button type="reset" id="reset" class="btn btn-primary btn-block">{{tr.resetuj_podatke}}</button>
		</div>
	</div>
</form>
</div> <!-- end of container -->
<?php include 'footer.php'; ?>
