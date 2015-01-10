<?php
include 'konekcija.php';

try{
    $db= konekcija::getConnectionInstance();
    // ovde nedostaje deo gde se iz json formata ocitavaju vrednosti
    // neka sledece promenljive za pocetak sadrze te vrednosti


    $oznaka="Oznaka";
    $jezik='grcki';
    $tekstNatpisa="Tekst natpisa";
    $vrstaNatpisa="Natpis2";
    $provincija="Macedonia";
    $grad="Beograd";
    $mesto="Beograd";
    $modernaDrzava="Srbija";
    $modernoMesto="Beograd";
    $tip=" ";
    $materijal=" ";
    $dimenzije=" ";
    $komentar="komentar";
    $faza="za objavljivanje";
    $pleme="Apace";
    $datovano=0;
    $lokalizovano=0;
    $korisnickoIme='Mirko';
    // Potrebno je odrediti id jezika
    $query="SELECT id FROM `jezik` WHERE naziv=:jezik";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":jezik", $jezik, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $jezik= $o[0][0];
    echo "Id jezika: ".$o[0][0];
    //Potrebno je odrediti id vrsteNatpisa
    $query="SELECT id FROM `vrstanatpisa` WHERE naziv=:vrstaNatpisa";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":vrstaNatpisa", $vrstaNatpisa, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $vrstaNatpisa=$o[0][0];
    echo "<br>Id vrste natpisa: ".$o[0][0];
    //Potrebno je odrediti id provincije
    $query="SELECT id FROM `provincija` WHERE naziv=:provincija";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":provincija", $provincija, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $provincija=$o[0][0];
    echo "<br>Id provincije: ".$o[0][0];
    //Potrebno je odrediti id grada
    $query="SELECT id FROM `grad` WHERE naziv=:grad";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":grad", $grad, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $grad=$o[0][0];
    echo "<br>Id grada: ".$o[0][0];
    //Potrebno je odrediti id Mesta
    $query="SELECT id FROM `mesto` WHERE naziv=:mesto";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":mesto", $mesto, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $mesto=$o[0][0];
    echo "<br>Id mesta: ".$o[0][0];
    //Potrebno je odrediti id moderneDrzave
    $query="SELECT id FROM `modernaDrzava` WHERE naziv=:modernaDrzava";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":modernaDrzava", $modernaDrzava, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $modernaDrzava=$o[0][0];
    echo "<br>Id moderne Drzave: ".$o[0][0];
    //Potrebno je odrediti id modernogMesta
    $query="SELECT id FROM `modernoMesto` WHERE naziv=:modernoMesto";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":modernoMesto", $modernoMesto, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $modernoMesto=$o[0][0];
    echo "<br>Id modernog mesta: ".$o[0][0];
    // datum poslednje izmene ce biti datum kreiranja
    $datumKreiranja=date("Y-m-d");
    $datumPoslednjeIzmene=date("Y-m-d");
    echo "<br>Datum kreiranja: ".$datumKreiranja;
    echo "<br>Datum poslednje Izmene: ".$datumPoslednjeIzmene;
    // odredjujem max id u tabeli objekat, pa sledeca vrsta koju unosim ima id=max+1
    $query="SELECT max(id) FROM `objekat` WHERE 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $id=$o[0][0]+1;
    echo "<br>Id: ".$id;
    //Potrebno je odrediti id plemena
    $query="SELECT id FROM `pleme` WHERE naziv=:pleme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pleme", $pleme, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $pleme=$o[0][0];
    echo "<br>Id plemena: ".$o[0][0];
    // odredjujemo int za ustanovu preko modernog mesta
    $query="SELECT ustanova.id FROM `modernomesto`as mesto join `ustanova` as ustanova on
         mesto.id=ustanova.modernoMesto WHERE 1";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $ustanova=$o[0][0];
    echo "<br>Id ustanove: ".$o[0][0];
    //$query="INSERT INTO `objekat` (id, oznaka, jezik, tekstNatpisa, vrstaNatpisa, provincija, grad, mesto, modernaDrzava,modernoMesto, tip, materijal, dimenzije, komentar, datumKreiranja, datumPoslednjeIzmene, faza, pleme, ustanova)
    // VALUES ($id, $oznaka, $jezik, $tekstNatpisa, $vrstaNatpisa, $provincija, $grad, $mesto, $modernaDrzava,$modernoMesto, $tip, $materijal, $dimenzije, $komentar, $datumKreiranja, $datumPoslednjeIzmene, $faza, $pleme, $ustanova)";
    $stmt = $db->prepare($query);
    $stmt->execute();
}
catch(Exception $e){
    $result->error_status=true;
}
?>