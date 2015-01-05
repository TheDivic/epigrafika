<?php include 'header.php'; ?>

<!-- ucitavanje kontrolera -->
<script src="static/scripts/pretraga.js"></script>
<script src="static/scripts/slanjePodatakaServeru.js"></script>

<div ng-controller='pretragaController' ng-cloak>
    <p ng-click="prikazi=!prikazi"> {{ tr.pretraga }} </p>
    <form action=""  name='formPretraga' ng-init="prikazi=true" id="myForm" method="post" enctype='multipart/form-data' ng-show="prikazi">
      <fieldset>
        <legend> {{ tr.osnovne_informacije }} </legend>
        {{ tr.oznaka }} **: <input type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-required='true'/>  
        <span ng-show='formPretraga.oznaka.$error.maxlength'> {{ tr.oznaka_error_length }}</span><br/> 
        {{ tr.natpis }}: <input type="text" name="natpis" ng-model="natpis"/> 
        <select name="natpisArg" ng-model="natpisArguments">
            <option value="prazno" ng-value="false"> </option>
            <option value="and" ng-value="true"> AND </option>
            <option value="or" ng-value="true"> OR </option>
            <option value="andNot" ng-value="true"> AND NOT </option>
        </select>
        <input type="text" name="natpis2" ng-show="natpisArguments" /> <br/>
        <input type="checkbox" name="rezimIgnorisanjaZagrada" value="rezimIgnorisanjaZagrada"> {{ tr.ignorisi_zagrade }}

    </fieldset>
    <fieldset>
        <legend> {{ tr.izvorno_mesto_nastanka }} </legend>
        {{tr.provincija}}:
        <select name="provincijaNalaska"  >
            <option ng-repeat="provincija in provincije | orderBy:'naziv':false"> {{ provincija.naziv }} </option>
        </select><br/>
        {{tr.grad}}: <input type="text" name="gradNalaska" ng-model="gradNalaska"/> <br/>
        {{tr.mesto}}: <input type="text" name="mestoNalaska" ng-model="mestoNalaska"/> <br/>
		<input type="checkbox" name="prikaziNelokalizovanePodatke" value="prikaziNelokalizovanePodatke"> {{ tr.prikazi_nelokalizovane_podatke}} <br/>
    </fieldset>
	{{tr.moderno_ime_drzave}}:
        <select name="modernoImeDrzave" >
            <option ng-repeat="drzava in drzave | orderBy:'naziv':false"> {{drzava.naziv}} </option>
        </select>
		<br/>
		{{tr.moderno_mesto}}
		<select name="modernoMesto" >
            <option ng-repeat="mesto in mesta | orderBy:'naziv':false"> {{mesto.naziv}} </option>
        </select> //TODO <br/>
		{{tr.pleme}}
		<select name="pleme" >
            <option ng-repeat="p in plemena | orderBy:'naziv':false"> {{p.naziv}} </option>
        </select> //TODO
    <fieldset>
        <legend> {{tr.vreme}} </legend>
        {{tr.vek}}: <input type="text" name="vek" ng-model="vek"/>
        <br/>
        <input type="radio" name="periodVeka" value="prvaPolovinaVeka"/> {{tr.prva_polovina}}  <br/>
        <input type="radio" name="periodVeka" value="drugaPolovinaVeka"/>  {{tr.druga_polovina}}
        <br/>
        <input type="checkbox" name="" value="prikaziNedatovaneNatpise"> {{tr.prikazi_nedatovane_natpise}}
        <br/>
    </fieldset>
    <fieldset>
        <legend> {{tr.sortiraj_rezultate_po}} </legend>
        <input type="radio" name="sortiranje" value="poVremenu"/> {{tr.vremenu}} <br/>
        <input type="radio" name="sortiranje" value="poMestuNalaska"/> {{tr.mestu_nalaska}} <br/>
        <input type="radio" name="sortiranje" value="poVrstiNatpisa"/> {{tr.vrsti_natpisa}} <br/>
    </fieldset>
    <input type="submit" value={{tr.zapocni_pretragu}} ng-click="posaljiPodatke()" ng-disabled='!formPretraga.$valid'  />
    <input type="reset" value={{tr.resetuj_podatke}} />
</form>
<div id="rezultati">
    <div ng-repeat="rezultat in rezultatiPretrage">
        {{rezultat}} 
    </div>
</div>
</div>

<?php include 'footer.php'; ?>