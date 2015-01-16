<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/11/2015
 * Time: 7:01 PM
 */
include 'dictionary.php';

function unesi($data, $db){

//    $db=konekcija::getConnectionInstance();
    date_default_timezone_set("Europe/Belgrade");

    $data = json_decode($data);

    $oznaka = $data->oznaka;
    $oznaka=($oznaka);
    $natpis = $data->natpis;
    $natpis=($natpis);

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

        $mestoNalaska = trim($data->mestoNalaska);
        $query = "select count(*) from mesto where naziv=:mestoNalaska";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":mestoNalaska", $mestoNalaska, PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $brojMesta = $o[0][0];

        if($brojMesta == 0){
            $query = "insert into mesto (naziv) values(:mestoNalaska)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":mestoNalaska", $mestoNalaska, PDO::PARAM_STR);
            $stmt->execute();

        }

        //Potrebno je odrediti id Mesta
        $query="SELECT id FROM `mesto` WHERE naziv=:mesto";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":mesto", trim($mestoNalaska), PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $mestoNalaska=$o[0][0];



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


    }
    else{


        $provincija = -1;
        $grad = -1;
        $mestoNalaska = -1;

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
    $trenutnaLokacijaZnamenitosti=($trenutnaLokacijaZnamenitosti);

    $query="SELECT count(*) FROM `ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();


        if($o[0][0]==0){
//        $trenutnaLokacijaZnamenitosti = -1;
        $trenutnoModernoMesto = -1;
        $query="INSERT INTO  `ustanova` (naziv, modernoMesto) VALUES (:trenutnaLokacijaZnamenitosti, :trenutnoModernoMesto)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
        $stmt->bindParam(":trenutnoModernoMesto", $trenutnoModernoMesto, PDO::PARAM_INT);
        $stmt->execute();


    }
        $query = "SELECT id FROM `ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
        $stmt->execute();
        $o = $stmt->fetchAll();
        $trenutnaLokacijaZnamenitosti = $o[0][0];


//Potrebno je odrediti id plemena
    $pleme = $data->pleme;
    $pleme=($pleme);

    $query="SELECT count(*) FROM `pleme` WHERE naziv=:pleme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
    $stmt->execute();
    $o=$stmt->fetchAll();

    if($o[0][0]==0) {

        $query="INSERT INTO  `pleme` (naziv) VALUES (:pleme)";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
        $stmt->execute();

    }
    $query = "SELECT id FROM `pleme` WHERE naziv=:pleme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $pleme = $o[0][0];

//        echo "<br>Id plemena: ".$o[0][0];

//        radimo sa vremenom, dovrsiti
    $vreme = $data->vreme;

    if(strcmp($vreme, "nedatovan")==0){
        $datovano = 0;

        $pocetakGodina = null;
        $pocetakVek = null;
        $pocetakOdrednica = null;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;

    }
    //velika mogucnost greske

    else if(strcmp($vreme, "godina")==0){
        $datovano = 1;
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

    $tip=($tip);
    $materijal=($materijal);
    $komentar=($komentar);

    //dimenzije objekta, trenutno nemamo format, prepraviti
    $dimenzije = $data->sirina;
    $dimenzije.= ':';
    $dimenzije.=$data->visina;
    $dimenzije.= ':';
    $dimenzije.=$data->duzina;
    $korisnickoIme=$data->korisnickoIme;

   // $trenutniId =

    //deo za fotografije
    //$fotografije = $data->fotografije;



//    $query="INSERT INTO objekat(oznaka, jezik, tekstNatpisa, vrstaNatpisa, provincija,
//        grad, mesto, modernaDrzava,modernoMesto, tip, materijal, dimenzije, komentar, datumKreiranja,
//        datumPoslednjeIzmene, faza, pleme, ustanova, korisnickoIme)
//         VALUES ($oznaka, $jezikUpisa, $natpis, $vrstaNatpisa, $provincija,
//         $grad, $mestoNalaska, $modernoImeDrzave,$modernoMesto, $tip, $materijal, $dimenzije, $komentar, $datumKreiranja,
//         $datumPoslednjeIzmene, $fazaUnosa, $pleme, $trenutnaLokacijaZnamenitosti, 'Mirko')";
//
    $query="INSERT INTO objekat(oznaka, jezik, tekstNatpisa, vrstaNatpisa, provincija,
        grad, mesto, modernaDrzava,modernoMesto, tip, materijal, dimenzije, komentar, datumKreiranja,
        datumPoslednjeIzmene, faza, pleme, ustanova, korisnickoIme, lokalizovano, datovano,
        pocetakGodina, pocetakVek, pocetakOdrednica, krajGodina, krajVek, krajOdrednica)
         VALUES (:oznaka, :jezikUpisa, :natpis, :vrstaNatpisa, :provincija,
         :grad, :mestoNalaska, :modernoImeDrzave,:modernoMesto, :tip, :materijal, :dimenzije, :komentar, :datumKreiranja,
         :datumPoslednjeIzmene, :fazaUnosa, :pleme, :trenutnaLokacijaZnamenitosti, :korisnickoIme, :lokalizovanPodatak,
         :datovano, :pocetakGodina, :pocetakVek, :pocetakOdrednica, :krajGodina, :krajVek, :krajOdrednica)";
//    $sth->execute(array(':calories' => $calories, ':colour' => $colour));

    // Unosenje reci iz natpisa u recnik, potrebno za autocomplete
    populateDictionary($natpis);

    $stmt = $db->prepare($query);
    $returnValue = $stmt->execute(array(':oznaka' => $oznaka, ':jezikUpisa' => $jezikUpisa, ':natpis' => $natpis, ':vrstaNatpisa' => $vrstaNatpisa,
        ':provincija' => $provincija, ':grad' => $grad, ':mestoNalaska' => $mestoNalaska, ':modernoImeDrzave' => $modernoImeDrzave,
        ':modernoMesto' => $modernoMesto, ':tip' => $tip, ':materijal' => $materijal, ':dimenzije' => $dimenzije, ':komentar' => $komentar,
        ':datumKreiranja' => $datumKreiranja, ':datumPoslednjeIzmene' => $datumPoslednjeIzmene, ':fazaUnosa' => $fazaUnosa, ':pleme' => $pleme,
        ':trenutnaLokacijaZnamenitosti'=>$trenutnaLokacijaZnamenitosti, ':korisnickoIme' => $korisnickoIme, ':lokalizovanPodatak'=>$lokalizovanPodatak,
        ':datovano' => $datovano, ':pocetakGodina' => $pocetakGodina, ':pocetakVek' => $pocetakVek, ':pocetakOdrednica' => $pocetakOdrednica,
        ':krajGodina' => $krajGodina, ':krajVek' => $krajVek, ':krajOdrednica' => $krajOdrednica));

    //odavde krece novi kod

    $bibliografskoPoreklo=$data->bibliografskoPoreklo;
    $bibliografskoPorekloSkracenica=$data->bibliografskoPorekloSkracenica;
    $bibliografskiPdfLinkovi=$data->bibliografskiPdfLinkovi;



    // objekat

    $query="SELECT max(id) FROM `objekat` WHERE 1";
    $stmt=$db->prepare($query);
    $returnValue=$stmt->execute();
    $obj=$stmt->fetchAll();
    $obj=$obj[0][0]+1;

    // bibliografski podatak

    $query="SELECT max(id) FROM `bibliografskipodatak` WHERE 1";
    $stmt=$db->prepare($query);
    $returnValue=$stmt->execute();
    $bibl=$stmt->fetchAll();
    $bibl=$bibl[0][0];


    for($i=0;$i<count($data->bibliografskiPdfLinkovi);$i++) {

        // odredjujem broj strane
        $query = "SELECT count(*) FROM `izvodbibliografskogpodatka` WHERE objekat=:objekat AND bibliografskiPodatak=:bibliografskiPodatak";
        $stmt = $db->prepare($query);
        $returnValue = $stmt->execute(array(':objekat'=>$obj, ':bibliografskiPodatak'=>$bibl));
        $strana = $stmt->fetchAll();
        $strana = intval($strana[0][0]) + 1;


        // odredjujemo path iz url/path

        $path=$data->bibliografskiPdfLinkovi[$i];

        $arr=explode('/',$path);
        $path=$arr[count($arr)-1];


        $query="INSERT INTO `izvodbibliografskogpodatka` (objekat, bibliografskiPodatak, strana, putanja)
        VALUES (:objekat, :bibliografskiPodatak, :strana, :putanja)";
        $stmt=$db->prepare($query);
        $returnValue=$stmt->execute(array(':objekat'=>$obj, ':bibliografskiPodatak'=>$bibl, ':strana'=>$strana, ':putanja'=>$path));


    }

    // sada vrsimo unos i fotografija

    $fotografije=$data->fotografije;

    if(count($data->fotografije)) {
        $url = $data->fotografije[0];

        $arr = explode('/', $url);

        $length = count($arr);

        $url = '';

        for ($i = 0; $i < $length - 1; $i++)
            $url .= $arr[$i] . '/';


        $putanja = $bibliografskiPdfLinkovi[0];


        for ($i = 0; $i < count($data->fotografije); $i++) {

            // odredjujemo path iz url/path

            $path = $data->fotografije[$i];

            $arr = explode('/', $path);
            $path = $arr[count($arr) - 1];


            $query = "INSERT INTO `fotografija` (naziv, putanja, objekat)
        VALUES (:naziv, :putanja, :objekat)";
            $stmt = $db->prepare($query);
            $returnValue = $stmt->execute(array(':naziv' => $path, ':putanja' => $url, ':objekat' => $obj));


        }
    }



    return $returnValue;
}