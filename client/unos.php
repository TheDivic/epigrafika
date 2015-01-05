<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/unos.js"></script>

<div ng-controller='unosController'>
    <form action=""  name='formUnos' method="post" enctype='multipart/form-data'>
        <fieldset>
            <legend> {{tr.osnovne_informacije}} </legend>
            {{tr.oznaka}}: <input type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-required='true'/>
            <span ng-show='formUnos.oznaka.$error.maxlength'>
                {{tr.oznaka_error_length}}
            </span>
            <br/>
            <input type="radio" name="jezikUpisa" value="latinski" checked/> {{tr.latinski}}  <br/>
            <input type="radio" name="jezikUpisa" value="grcki"/>  {{tr.grcki}}

            <br/>
            {{tr.natpis}}: <textarea  rows="2"  name="natpis" /> </textarea>
            <br/>
            {{tr.vrsta_natpisa}}: 
            <select name="vrstaNatpisa">
                <option ng-repeat="natpis in vrsteNatpisa  | orderBy:'naziv':false"> {{natpis.naziv}} </option>
            </select>
        </fieldset>
    <fieldset>
        <legend> {{tr.izvorno_mesto_nastanka}} </legend>
		<div ng-init="lokalizovan=true" ng-show="lokalizovan">
        {{tr.provincija}}: 
		<select name="provincija">
			<option ng-repeat="provincija in provincije  | orderBy:'naziv':false"> {{ provincija.naziv }} </option>
		</select>
		<br/>
		{{tr.grad}}: 
		<select name="grad">
			<option ng-repeat="grad in gradovi | orderBy:'naziv':false"> {{grad.naziv}} </option>
		</select>
		<br/>
		{{tr.mesto}}: 
		<input type="text" name="mestoNalaska" /><br/>
		</div>
		<input type="checkbox" name="LokalizovanPodatak" value="LokalizovanPodatak" ng-click="lokalizovan=!lokalizovan"  checked/> {{ tr.lokalizovan_podatak}} <br/>
																				
{{tr.moderno_ime_drzave}}: <select name="modernoImeDrzave">
<option ng-repeat="drzava in drzave  | orderBy:'naziv':false"> {{drzava.naziv}} </option>
</select>
</fieldset>
{{tr.trenutna_lokacija_znamenitosti}}: <input type="text" name="trenutnaLokacijaZnamenitosti" /> <br/>
{{tr.pleme}}: <input type="text" name="pleme" />

<fieldset>
    <legend> {{tr.vreme}} </legend>
    <input type="radio" name="vreme" ng-model="vreme" value="nedatovan" checked/> {{tr.nedatovan_natpis}} <br/>
    <input type="radio" name="vreme" ng-model="vreme" value="godina"/> {{tr.unesite_godinu}} : <br/>
    <fieldset ng-show="vreme=='godina'"> 
        <input type="text" ng-model="godinaPronalaska" ng-change="unetaGodina()"/> <br/>
        {{tr.vek}} :  {{vekIzracunat}} <br/>
        {{tr.vreme}}: {{periodVekaIzracunat}}
    </fieldset>
    
    <input type="radio" name="vreme" ng-model="vreme" value="unosVeka"/> {{tr.unesite_vek}}: <br/>
    <fieldset ng-show="vreme=='unosVeka'"> 
        <input type="text" ng-model="vekPronalaska"/> <br/>
        <input type="radio" name="periodVeka" value="prvaPolovinaVeka"/> {{tr.prva_polovina}}  <br/>
        <input type="radio" name="periodVeka" value="drugaPolovinaVeka"/>  {{tr.druga_polovina}}
    </fieldset>
    <input type="radio" name="vreme" ng-model="vreme" value="unosPeriodaOdDo"/> {{tr.unesite_period}}:
    <fieldset ng-show="vreme=='unosPeriodaOdDo'"> 
        {{tr.od}}: <input type="text" ng-model="pocetakPerioda" ng-change="unetPocetakPerioda()"/>  {{tr.do}}: <input type="text" ng-model="krajPerioda" ng-change="unetKrajPerioda()"/> <br/>
        {{periodVekaPocetkaIzracunat}} {{vekPocetkaIzracunat}}  <br/>
        {{periodVekaKrajaIzracunat}} {{vekKrajaIzracunat}}  
    </fieldset>
</fieldset>
<fieldset>
    <legend>{{tr.informacije_o_znamenitosti}}</legend>
    {{tr.tip}}: <input type="text" ng-model="tipZnamenitosti"/> <br/>
    {{tr.materijal}}: <input type="text" ng-model="materijalZnamenitosti"/> <br/>
    {{tr.sirina}}: <input type="text" ng-model="sirina"/> <br/>
    {{tr.visina}}: <input type="text" ng-model="visina"/> <br/>
    {{tr.duzina}}: <input type="text" ng-model="duzina"/> <br/>
</fieldset>

<fieldset>
    <legend> {{tr.dodatne_informacije}}</legend>
    {{tr.biografsko_poreklo}}: <input type="text" ng-model="biografskoPoreklo"/>//TODO <br/> 
    {{tr.skracenica_biografskog_porekla}}: <input type="text" ng-model="biografskoPorekloSkracenica"/> // TODO <br/>
    {{tr.komentar}}: <textarea  rows="2"  name="natpis" /> </textarea><br/>
    {{tr.dodaj_fotografiju}} // TODO <br/>
    {{tr.trenutna_faza_unosa}}:<br/>
    <input type="radio" name="fazaUnosa" value="nekompletno"/> {{tr.nekompletno}} <br/>
    <input type="radio" name="fazaUnosa" value="zaKontrolu"/> {{tr.za_kontrolu}} <br/>
    <input type="radio" name="fazaUnosa" value="objavljivanje"/> {{tr.objavljivanje}} <br/>

</fieldset>



<input type="submit" value={{tr.unesi_podatke}} />
<input type="reset" value={{tr.resetuj_podatke}} />
</form>
</div>
<?php include 'footer.php'; ?>
