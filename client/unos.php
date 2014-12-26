<?php include 'header.php'; ?>
        <div ng-controller='formControllerUnos'>
	<form action=""  name='formUnos' method="post" enctype='multipart/form-data'>
		<fieldset>
                    <legend> Osnovne informacije </legend>
                    Oznaka: <input type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-required='true'/>
				<span ng-show='formUnos.oznaka.$error.maxlength'>
					Polje mora biti krace od 15 karaktera!
                                </span>
                                <br/>
                                <input type="radio" name="jezikUpisa" value="latinski" checked/> Latinski  <br/>
                                <input type="radio" name="jezikUpisa" value="grcki"/>  Grcki
                     
                                <br/>
                                Natpis: <textarea  rows="2"  name="natpis" /> </textarea>
				<br/>
                                Vrsta natpisa: <select name="vrstaNatpisa">
                                    <option ng-repeat="natpis in vrsteNatpisa  | orderBy:'naziv':false"> {{natpis.naziv}} </option>
                                </select>
				
		</fieldset>
                <fieldset>
                    <legend> Izvorno mesto nalaska </legend>
                    Provincija: <select name="provincija">
                        <option ng-repeat="provincija in provincije  | orderBy:'naziv':false"> {{ provincija.naziv }} </option>
                    </select>
                    <br/>
                    Grad: <select name="grad">
                        <option ng-repeat="grad in gradovi | orderBy:'naziv':false"> {{grad.naziv}} </option>
                    </select>
				<br/>
                    Mesto: <input type="text" name="mestoNalaska" /><br/>
                    Moderno ime drzave: <select name="modernoImeDrzave">
                        <option ng-repeat="drzava in drzave  | orderBy:'naziv':false"> {{drzava.naziv}} </option>
                    </select>
                </fieldset>
                Trenutna lokacija znamenitosti: <input type="text" name="trenutnaLokacijaZnamenitosti" />
				
                <fieldset>
                    <legend> Vreme </legend>
                    <input type="radio" name="vreme" ng-model="vreme" value="nedatovan" checked/> Nedatovan natpis  <br/>
                    <input type="radio" name="vreme" ng-model="vreme" value="godina"/> Unesite godinu:
                        <fieldset ng-show="vreme=='godina'"> 
                            <input type="text" ng-model="godinaPronalaska" ng-change="unetaGodina()"/> <br/>
                            Vek :  {{vekIzracunat}} <br/>
                            Period veka: {{periodVekaIzracunat}}
                        </fieldset>
                    <br/>
                    <input type="radio" name="vreme" ng-model="vreme" value="unosVeka"/> Unesite vek:
                        <fieldset ng-show="vreme=='unosVeka'"> 
                            <input type="text" ng-model="vekPronalaska"/> <br/>
                            <input type="radio" name="periodVeka" value="prvaPolovinaVeka"/> prva polovina  <br/>
                            <input type="radio" name="periodVeka" value="drugaPolovinaVeka"/>  druga polovina
                        </fieldset>
                      <br/>
                    <input type="radio" name="vreme" ng-model="vreme" value="unosPeriodaOdDo"/> Unesite period:
                        <fieldset ng-show="vreme=='unosPeriodaOdDo'"> 
                            Od: <input type="text" ng-model="pocetakPerioda" ng-change="unetPocetakPerioda()"/>  do: <input type="text" ng-model="krajPerioda" ng-change="unetKrajPerioda()"/> <br/>
                            {{periodVekaPocetkaIzracunat}} {{vekPocetkaIzracunat}}  <br/>
                            {{periodVekaKrajaIzracunat}} {{vekKrajaIzracunat}}  

                        </fieldset>
                </fieldset>
                <fieldset>
                    <legend>Informacije o znamenitosti</legend>
                    Tip: <input type="text" ng-model="tipZnamenitosti"/> <br/>
                    Materijal: <input type="text" ng-model="materijalZnamenitosti"/> <br/>
                    Sirina: <input type="text" ng-model="sirina"/> <br/>
                    Visina: <input type="text" ng-model="visina"/> <br/>
                    Duzina: <input type="text" ng-model="duzina"/> <br/>
                </fieldset>
                
                <fieldset>
                    <legend> Dodatne informacije</legend>
                    Biografsko poreklo: <input type="text" ng-model="biografskoPoreklo"/>//TODO <br/> 
                    Skracenica biografskog porekla: <input type="text" ng-model="biografskoPorekloSkracenica"/> // TODO <br/>
                    Komentar: <textarea  rows="2"  name="natpis" /> </textarea><br/>
                    Dodaj fotografiju // TODO <br/>
                    Trenutna faza unosa:
                        <input type="radio" name="fazaUnosa" value="nekompletno"/> Nekompletno <br/>
                        <input type="radio" name="fazaUnosa" value="zaKontrolu"/> Za kontrolu <br/>
                        <input type="radio" name="fazaUnosa" value="objavljivanje"/> Objavljivanje <br/>

                </fieldset>
                
                
               
            <input type="submit" value="Unesi podatke" />
            <input type="reset" value="Obrisi podatke" />
        </form>
      </div>
 <?php include 'footer.php'; ?>
