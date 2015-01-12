<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/11/2015
 * Time: 11:10 PM
 */
function azuriraj($data, $db){

//    $db=konekcija::getConnectionInstance();

    $data = json_decode($data);

    $id = $data->id;
    $oznaka = $data->oznaka;
    $natpis = $data->natpis;

    /*dobijamo ime jezika pa spajamo sa bazom da bismo dobili id */
    $jezikUpisa = $data->jezikUpisa;
    $query="SELECT id FROM `jezik` WHERE naziv=:jezik";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":jezik", $jezikUpisa, PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $jezikUpisa= $o[0][0];


    //Potrebno je odrediti id vrsteNatpisa
    $vrstaNatpisa = $data->vrstaNatpisa;
    $query="SELECT id FROM `vrstanatpisa` WHERE naziv=:vrstaNatpisa";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":vrstaNatpisa", trim($vrstaNatpisa), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $vrstaNatpisa=$o[0][0];

    //u vezi null-a ako nece da prodje prosledjen null, mozemo da stavimo if(null) stavljamo 0

    $lokalizovanPodatak = $data->LokalizovanPodatak;
    //echo "<br>Lokalizovan: $lokalizovanPodatak";
    if($lokalizovanPodatak==true){
        $provincija = $data->provincija;
        $grad = $data->grad;
        $mestoNalaska = $data->mestoNalaska;
        //Potrebno je odrediti id provincije
        $query="SELECT id FROM `provincija` WHERE naziv=:provincija";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":provincija", trim($provincija), PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $provincija=$o[0][0];
        //Potrebno je odrediti id grada
        $query="SELECT id FROM `grad` WHERE naziv=:grad";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":grad", trim($grad), PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $grad=$o[0][0];
//            echo "<br>Id grada: ".$o[0][0];
        //Potrebno je odrediti id Mesta
        $query="SELECT id FROM `mesto` WHERE naziv=:mesto";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":mesto", trim($mestoNalaska), PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $mestoNalaska=$o[0][0];


    }
    else{

        // ovo nece proci jer su provincija, grad i mesto strani kljucevi i not null su....

        $provincija = 0;
        $grad = 0;
        $mestoNalaska = 0;

    }



    $modernoImeDrzave = $data->modernoImeDrzave;
    //Potrebno je odrediti id moderneDrzave
    $query="SELECT id FROM `modernaDrzava` WHERE naziv=:modernaDrzava";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":modernaDrzava", trim($modernoImeDrzave), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $modernoImeDrzave=$o[0][0];
//        echo "<br>Id moderne Drzave: ".$o[0][0];
    //Potrebno je odrediti id modernogMesta
    $modernoMesto = $data->modernoMesto;
    $query="SELECT id FROM `modernoMesto` WHERE naziv=:modernoMesto";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":modernoMesto", trim($modernoMesto), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();
    $modernoMesto =$o[0][0];
//        echo "<br>Id modernog mesta: ".$o[0][0];

    $trenutnaLokacijaZnamenitosti = $data->trenutnaLokacijaZnamenitosti;

    $query="SELECT count(*) FROM `ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();

    if($o[0][0]==1) {
        $query = "SELECT id FROM `ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
        $stmt->execute();
        $o = $stmt->fetchAll();
        $trenutnaLokacijaZnamenitosti = $o[0][0];
    }else{

        // ovde postoji problem jer se id ne inkrementira automatski

        $query="INSERT INTO  `ustanova` (naziv, modernoMesto) VALUES (:trenutnaLokacijaZnamenitosti, :modernoMesto)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
        $stmt->bindParam(":modernoMesto", $modernoMesto, PDO::PARAM_INT);
        $stmt->execute();

        $query = "SELECT id FROM `ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
        $stmt->execute();
        $o = $stmt->fetchAll();
        $trenutnaLokacijaZnamenitosti = $o[0][0];

    }

//Potrebno je odrediti id plemena
    $pleme = $data->pleme;

    $query="SELECT count(*) FROM `pleme` WHERE naziv=:pleme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();

    if($o[0][0]==1) {
        $query = "SELECT id FROM `pleme` WHERE naziv=:pleme";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
        $stmt->execute();
        $o = $stmt->fetchAll();
        $pleme = $o[0][0];
    }else{

        $query="INSERT INTO  `pleme` (naziv) VALUES (:pleme)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
        $stmt->execute();

        $query = "SELECT id FROM `pleme` WHERE naziv=:pleme";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
        $stmt->execute();
        $o = $stmt->fetchAll();
        $pleme = $o[0][0];

    }
//        echo "<br>Id plemena: ".$o[0][0];

//        radimo sa vremenom, dovrsiti
    $vreme = $data->vreme;

    if(strcmp($vreme, "nedatovan")==0){
        $datovano = false;

        $pocetakGodina = null;
        $pocetakVek = null;
        $pocetakOdrednica = null;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;

    }
    //velika mogucnost greske

    else if(strcmp($vreme, "godina")==0){
        $datovano = true;
        $pocetakGodina = $data->godinaPronalaska;
        $pocetakVek = $data->vekGodine;
        $pocetakOdrednica = $data->periodVekGodine;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;

    }

    else if(strcmp($vreme, "unosVeka")==0){

        $datovano = true;
        $pocetakGodina = null;
        $pocetakVek = $data->vekPronalaska;
        $pocetakOdrednica = $data->periodVeka;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;
    }

    else if(strcmp($vreme, "unosPeriodaOdDo")==0){
        $datovano = true;
        $pocetakGodina = $data->pocetakGodina;
        $pocetakVek = $data->pocetakVek;
        $pocetakOdrednica = $data->pocetakPeriodVeka;
        $krajGodina = $data->krajGodina;
        $krajVek = $data->krajVek;
        $krajOdrednica = $data->krajPeriodVeka;

    }

// datum kreiranja, datum poslednje izmene

    $datumKreiranja=date("Y-m-d");
    $datumPoslednjeIzmene=date("Y-m-d");

//       faza unosa
    $fazaUnosa = $data->fazaUnosa;

    //tip i ostalo
    $tip = $data->tipZnamenitosti;
    $materijal = $data->materijalZnamenitosti;
    $komentar = $data->komentar;

    //dimenzije objekta, trenutno nemamo format, prepraviti
    $dimenzije = $data->sirina;
    $dimenzije.= ':';
    $dimenzije.=$data->visina;
    $dimenzije.= ':';
    $dimenzije.=$data->duzina;

    $korisnickoIme=$data->korisnickoIme;


//    $query="INSERT INTO objekat(oznaka, jezik, tekstNatpisa, vrstaNatpisa, provincija,
//        grad, mesto, modernaDrzava,modernoMesto, tip, materijal, dimenzije, komentar, datumKreiranja,
//        datumPoslednjeIzmene, faza, pleme, ustanova, korisnickoIme)
//         VALUES ($oznaka, $jezikUpisa, $natpis, $vrstaNatpisa, $provincija,
//         $grad, $mestoNalaska, $modernoImeDrzave,$modernoMesto, $tip, $materijal, $dimenzije, $komentar, $datumKreiranja,
//         $datumPoslednjeIzmene, $fazaUnosa, $pleme, $trenutnaLokacijaZnamenitosti, 'Mirko')";
//
    $query="UPDATE objekat set oznaka = :oznaka, jezik = :jezikUpisa, tekstNatpisa = :natpis, vrstaNatpisa = :vrstaNatpisa,
        provincija = :provincija, grad = :grad, mesto = :mestoNalaska, modernaDrzava = :modernoImeDrzave,
        modernoMesto = :modernoMesto, tip = :tip, materijal = :materijal, dimenzije = :dimenzije, komentar = :komentar,
         datumKreiranja = :datumKreiranja,datumPoslednjeIzmene = :datumPoslednjeIzmene, faza = :fazaUnosa, pleme = :pleme,
          ustanova = :trenutnaLokacijaZnamenitosti, korisnickoIme = :korisnickoIme, lokalizovano = :LokalizovanPodatak,
           datovano = :datovano, pocetakGodina = :pocetakGodina, pocetakVek = :pocetakVek, pocetakOdrednica = :pocetakOdrednica,
            krajGodina = :krajGodina, krajVek = :krajVek, krajOdrednica = :krajOdrednica
           where id = :id";

//    $sth->execute(array(':calories' => $calories, ':colour' => $colour));



    $stmt = $db->prepare($query);
    $returnValue = $stmt->execute(array(':id'=>$id, ':oznaka' => $oznaka, ':jezikUpisa' => $jezikUpisa, ':natpis' => $natpis, ':vrstaNatpisa' => $vrstaNatpisa,
        ':provincija' => $provincija, ':grad' => $grad, ':mestoNalaska' => $mestoNalaska, ':modernoImeDrzave' => $modernoImeDrzave,
        ':modernoMesto' => $modernoMesto, ':tip' => $tip, ':materijal' => $materijal, ':dimenzije' => $dimenzije, ':komentar' => $komentar,
        ':datumKreiranja' => $datumKreiranja, ':datumPoslednjeIzmene' => $datumPoslednjeIzmene, ':fazaUnosa' => $fazaUnosa, ':pleme' => $pleme,
        ':trenutnaLokacijaZnamenitosti'=>$trenutnaLokacijaZnamenitosti, ':korisnickoIme' => $korisnickoIme, ':LokalizovanPodatak'=>$lokalizovanPodatak,
        ':datovano' => $datovano, ':pocetakGodina' => $pocetakGodina, ':pocetakVek' => $pocetakVek, ':pocetakOdrednica' => $pocetakOdrednica,
        ':krajGodina' => $krajGodina, ':krajVek' => $krajVek, ':krajOdrednica' => $krajOdrednica ));

    return $returnValue;



}