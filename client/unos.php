<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/unos.js"></script>

<div ng-controller='unosController' ng-cloak>
    <form action=""  name='formUnos' method="post" enctype='multipart/form-data'>
        <fieldset>
            <legend> {{tr.osnovne_informacije}} </legend>
            {{tr.oznaka}} *: <input type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-change="proveri_jedinstvenost()" ng-pattern="/^[a-zA-Z0-9]+$/" ng-required='true'/> 
            <span ng-show='formUnos.oznaka.$error.maxlength'>
                {{tr.oznaka_error_length}}
            </span> 
			<span ng-show='formUnos.oznaka.$error.pattern'>
                {{tr.format_error_slova_cifre}}
            </span><span>{{greska}}</span>
            <br/>
            <input type="radio" name="jezikUpisa" ng-model="jezikUpisa" value="latinski" checked /> {{tr.latinski}}  <br/>
            <input type="radio" name="jezikUpisa" ng-model="jezikUpisa" value="grcki"/>  {{tr.grcki}}

            <br/>
            {{tr.natpis}} *: <textarea  rows="2" ng-model="natpis" name="natpis" ng-required='true'/> </textarea>
            <br/>
            {{tr.vrsta_natpisa}}: 
            <select name="vrstaNatpisa" ng-model="vrstaNatpisa">
                <option ng-repeat="natpis in vrsteNatpisa  | orderBy:'naziv':false"> {{natpis.naziv}} </option>
            </select>
        </fieldset>
    <fieldset>
        <legend> {{tr.izvorno_mesto_nastanka}} </legend>
		<div ng-init="lokalizovan=true" ng-show="lokalizovan">
        {{tr.provincija}}: 
		<select name="provincija" ng-model="provincija">
			<option ng-repeat="p in provincije  | orderBy:'naziv':false"> {{ p.naziv }} </option>
		</select>
		<br/>
		{{tr.grad}}: 
		<select name="grad" ng-model="grad">
			<option ng-repeat="grad in gradovi | orderBy:'naziv':false"> {{grad.naziv}} </option>
		</select>
		<br/>
		{{tr.mesto}}: 
		<input type="text" name="mestoNalaska" ng-model="mestoNalaska" ng-pattern="/^[a-zA-Z ]+$/"/>
		<span ng-show='formUnos.mestoNalaska.$error.pattern '> 
			{{tr.format_error_slova}}
		</span>
		</td><br/>
		</div>
		<input type="checkbox" name="LokalizovanPodatak" ng-model="LokalizovanPodatak" value="LokalizovanPodatak" ng-click="lokalizovan=!lokalizovan"  checked/> {{ tr.lokalizovan_podatak}} <br/>
																				
{{tr.moderno_ime_drzave}}:
<select name="modernoImeDrzave" ng-model="modernoImeDrzave">
	<option ng-repeat="drzava in drzave  | orderBy:'naziv':false"> {{drzava.naziv}} </option>
</select>
</fieldset>
{{tr.trenutna_lokacija_znamenitosti}}: <input type="text" name="trenutnaLokacijaZnamenitosti" ng-model="trenutnaLokacijaZnamenitosti" ng-pattern="/^[a-zA-Z ]+$/"/>
	<span ng-show='formUnos.trenutnaLokacijaZnamenitosti.$error.pattern '> 
			{{tr.format_error_slova}}
	</span>
 <br/>
{{tr.pleme}}: <input type="text" name="pleme" ng-model="pleme" ng-pattern="/^[a-zA-Z ]+$/"/>
<span ng-show='formUnos.pleme.$error.pattern '> 
			{{tr.format_error_slova}}
</span>
<fieldset>
    <legend> {{tr.vreme}} </legend>
    <input type="radio" name="vreme" ng-model="vreme" value="nedatovan" checked /> {{tr.nedatovan_natpis}} <br/>
    <input type="radio" name="vreme" ng-model="vreme" value="godina"/> {{tr.unesite_godinu}} : <br/>
    <fieldset ng-show="vreme=='godina'"> 
        {{tr.godina}}* <input type="text" name="godinaPronalaska" ng-model="godinaPronalaska" ng-change="unetaGodina()" ng-required='vreme=="godina"' ng-pattern="/^\d+$/"/>
		<span ng-show='formUnos.godinaPronalaska.$error.pattern'>
                {{tr.pattern_error_cifre}}
        </span>		<br/>
        {{tr.vek}} :  {{vekIzracunat}} <br/>
        {{tr.vreme}}: {{periodVekaIzracunat}}
    </fieldset>
    
    <input type="radio" name="vreme" ng-model="vreme" value="unosVeka"/> {{tr.unesite_vek}}: <br/>
    <fieldset ng-show="vreme=='unosVeka'"> 
        {{tr.vek}} * <input type="text" name="vekPronalaska" ng-model="vekPronalaska" ng-required='vreme=="unosVeka"' ng-pattern="/^\d+$/"/> 
		<span ng-show='formUnos.vekPronalaska.$error.pattern'>
                {{tr.pattern_error_cifre}}
            </span><br/>
        <input type="radio" name="periodVeka" ng-model="periodVeka" value="prvaPolovinaVeka"/> {{tr.prva_polovina}}  <br/>
        <input type="radio" name="periodVeka" ng-model="periodVeka" value="drugaPolovinaVeka"/>  {{tr.druga_polovina}}
    </fieldset>
    <input type="radio" name="vreme" ng-model="vreme" value="unosPeriodaOdDo"/> {{tr.unesite_period}}:
    <fieldset ng-show="vreme=='unosPeriodaOdDo'"> 
        {{tr.od}} *: <input type="text" ng-model="pocetakPerioda" name="pocetakPerioda" ng-change="unetPocetakPerioda()" ng-required='vreme=="unosPeriodaOdDo"' ng-pattern="/^\d+$/"/>
				
		{{tr.do}} *: <input type="text" ng-model="krajPerioda" name="krajPerioda" ng-change="unetKrajPerioda()" ng-required='vreme=="unosPeriodaOdDo"' ng-pattern="/^\d+$/"/> 
		<span ng-show='formUnos.pocetakPerioda.$error.pattern || formUnos.krajPerioda.$error.pattern'>
            {{tr.pattern_error_cifre}}
        </span> <br/>
        {{pocetakPeriodaPoruka}}   <br/>
        {{krajPeriodaPoruka}} 
    </fieldset>
</fieldset>
<fieldset>
    <legend>{{tr.informacije_o_znamenitosti}}</legend>
    {{tr.tip}}: <input type="text" name="tipZnamenitosti" ng-model="tipZnamenitosti" ng-pattern="/^[a-zA-Z ]+$/"/> 
	<span ng-show='formUnos.tipZnamenitosti.$error.pattern '> 
		{{tr.format_error_slova}}
	</span>	<br/>
    {{tr.materijal}}: <input type="text" name="materijalZnamenitosti" ng-model="materijalZnamenitosti" ng-pattern="/^[a-zA-Z ]+$/"/> 
	<span ng-show='formUnos.materijalZnamenitosti.$error.pattern '> 
		{{tr.format_error_slova}}
	</span><br/>
    {{tr.sirina}}: <input type="text" ng-model="sirina" name="sirina" ng-pattern="/^\d+(\.)?(\d{1,9})?$/"/> 
	    <span ng-show='formUnos.sirina.$error.pattern'>
                {{tr.pattern_error_cifre}}
		</span>		<br/>
    {{tr.visina}}: <input type="text" ng-model="visina" name="visina" ng-pattern="/^\d+(\.)?(\d{1,9})?$/"/> 
		<span ng-show='formUnos.visina.$error.pattern'>
                {{tr.pattern_error_cifre}}
		</span>		<br/>
    {{tr.duzina}}: <input type="text" ng-model="duzina" name="duzina" ng-pattern="/^\d+(\.)?(\d{1,9})?$/"/>
		<span ng-show='formUnos.duzina.$error.pattern'>
                {{tr.pattern_error_cifre}}
		</span>		<br/>
</fieldset>

<fieldset>
    <legend> {{tr.dodatne_informacije}}</legend>
    {{tr.bibliografsko_poreklo}}: <input type="text" ng-model="bibliografskoPoreklo"/>//TODO <br/> 
    {{tr.skracenica_bibliografskog_porekla}}: <input type="text" ng-model="bibliografskoPorekloSkracenica"/> // TODO upload pdf <br/>
    {{tr.komentar}}: <textarea  rows="2"  name="komentar" ng-model="komentar" ng-pattern="/^[a-zA-Z0-9 \. ]+$/"/> </textarea>
	<span ng-show='formUnos.komentar.$error.pattern '> 
		{{tr.format_error_slova_cifre_tacka}}
	</span><br/>
    {{tr.dodaj_fotografiju}} // TODO <br/>
    {{tr.trenutna_faza_unosa}}:<br/>
    <input type="radio" name="fazaUnosa" ng-model="fazaUnosa" value="nekompletno"/> {{tr.nekompletno}} <br/>
    <input type="radio" name="fazaUnosa" ng-model="fazaUnosa" value="zaKontrolu"/> {{tr.za_kontrolu}} <br/>
    <input type="radio" name="fazaUnosa" ng-model="fazaUnosa" value="objavljivanje"/> {{tr.objavljivanje}} <br/>

</fieldset>



<input type="submit" value={{tr.unesi_podatke}} ng-disabled='!formUnos.$valid' ng-click="posalji_podatke()"/>
<input type="reset" value={{tr.resetuj_podatke}} />
</form>
</div>
<?php include 'footer.php'; ?>
