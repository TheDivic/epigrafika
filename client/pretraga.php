<?php include 'header.php'; ?>
        <div ng-controller='formControllerPretraga'>
	<form action=""  name='formPretraga' id="myForm" method="post" enctype='multipart/form-data'>
		<fieldset>
                    <legend> Osnovne informacije </legend>
                    Oznaka **: <input type="text" name="oznaka" ng-maxlength="15" ng-model="oznaka" ng-required='true'/>  
                            <span ng-show='formPretraga.oznaka.$error.maxlength'> Polje mora biti krace od 15 karaktera!</span><br/> 
                    Natpis: <input type="text" name="natpis" ng-model="natpis"/> 
                            <select name="natpisArg" ng-model="natpisArguments">
                                    <option value="prazno" ng-value="false"> </option>
                                    <option value="and" ng-value="true"> AND </option>
                                    <option value="or" ng-value="true"> OR </option>
                                    <option value="andNot" ng-value="true"> AND NOT </option>
                            </select>
                            <input type="text" name="natpis2" ng-show="natpisArguments" /> <br/>
                            <input type="checkbox" name="" value="rezimIgnorisanjaZagrada"> Rezim ignorisanja zagrada
                        	
		</fieldset>
                <fieldset>
                    <legend> Izvorno mesto nalaska </legend>
                            Provincija:
                            <select name="provincijaNalaska" ng-model="provincijaNalaska" >
                                    <option value="aaa"> AAAAAA </option>
                                    <option value="bbbb"> BBBBBB </option>
                                </select><br/>
                            Grad: <input type="text" name="gradNalaska" ng-model="gradNalaska"/> <br/>
                            Mesto: <input type="text" name="mestoNalaska" ng-model="mestoNalaska"/> <br/>
                            Moderno ime drzave:
                            <select name="modernoImeDrzave" ng-model="modernoImeDrzave">
                                <option value="aaa"> AAAAAA </option>
                                <option value="bbbb"> BBBBBB </option>
                            </select>
                </fieldset>
                <fieldset>
                    <legend> Vreme </legend>
                    Vek: <input type="text" name="vek" ng-model="vek"/>
				<br/>
                    <input type="radio" name="periodVeka" value="prvaPolovinaVeka"/> prva polovina  <br/>
                    <input type="radio" name="periodVeka" value="drugaPolovinaVeka"/>  druga polovina
                      <br/>
                    <input type="checkbox" name="" value="prikaziNedatovaneNatpise"> Prikazi i nedatovane natpise
                                <br/>
                </fieldset>
                <fieldset>
                    <legend> Sortiranje rezultata po jednoj od sledecih kategorija </legend>
                    <input type="radio" name="sortiranje" value="poVremenu"/> vremenu <br/>
                    <input type="radio" name="sortiranje" value="poMestuNalaska"/> mestu nalaska <br/>
                    <input type="radio" name="sortiranje" value="poVrstiNatpisa"/> vrsti natpisa <br/>
                </fieldset>
            <input type="submit" value="Zapocni pretragu" onclick="posaljiPodatke()" ng-disabled='!formPretraga.$valid'  />
            <input type="reset" value="Obrisi podatke" />
        </form>
      </div>
    <?php include 'footer.php'; ?>