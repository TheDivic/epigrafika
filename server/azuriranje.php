<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/11/2015
 * Time: 11:10 PM
 */
function azuriraj($data, $db){
    date_default_timezone_set("Europe/Belgrade");

    $data = json_decode($data);

//    $oznaka = $data->oznaka;
//    $oznaka=($oznaka);
    $id = $data->id;
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

            try{

                $db->beginTransaction();

                $query = "insert into mesto (naziv) values(:mestoNalaska)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(":mestoNalaska", $mestoNalaska, PDO::PARAM_STR);
                $stmt->execute();

                $db->commit();

            }catch(Exception $e){

                $db->rollBack();
                return false;
            }

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

        try{

            $db->beginTransaction();


            $query="INSERT INTO  `ustanova` (naziv, modernoMesto) VALUES (:trenutnaLokacijaZnamenitosti, :trenutnoModernoMesto)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":trenutnaLokacijaZnamenitosti", trim($trenutnaLokacijaZnamenitosti), PDO::PARAM_STR);
            $stmt->bindParam(":trenutnoModernoMesto", $trenutnoModernoMesto, PDO::PARAM_INT);
            $stmt->execute();


            $db->commit();

        }catch(Exception $e){

            $db->rollBack();
            return false;
        }


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

        try{

            $db->beginTransaction();

            $query="INSERT INTO  `pleme` (naziv) VALUES (:pleme)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
            $stmt->execute();

            $db->commit();

        }catch(Exception $e){

            $db->rollBack();
            return false;
        }


    }
    $query = "SELECT id FROM `pleme` WHERE naziv=:pleme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":pleme", trim($pleme), PDO::PARAM_STR);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $pleme = $o[0][0];

//        echo "<br>Id plemena: ".$o[0][0];

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



    $query="UPDATE objekat set oznaka = :oznaka, jezik = :jezikUpisa, tekstNatpisa = :natpis, vrstaNatpisa = :vrstaNatpisa,
        provincija = :provincija, grad = :grad, mesto = :mestoNalaska, modernaDrzava = :modernoImeDrzave,
        modernoMesto = :modernoMesto, tip = :tip, materijal = :materijal, dimenzije = :dimenzije, komentar = :komentar,
         datumKreiranja = :datumKreiranja,datumPoslednjeIzmene = :datumPoslednjeIzmene, faza = :fazaUnosa, pleme = :pleme,
          ustanova = :trenutnaLokacijaZnamenitosti, korisnickoIme = :korisnickoIme, lokalizovano = :LokalizovanPodatak,
           datovano = :datovano, pocetakGodina = :pocetakGodina, pocetakVek = :pocetakVek, pocetakOdrednica = :pocetakOdrednica,
            krajGodina = :krajGodina, krajVek = :krajVek, krajOdrednica = :krajOdrednica
           where id = :id";

//    $sth->execute(array(':calories' => $calories, ':colour' => $colour));

try{

    $db->beginTransaction();

    $stmt = $db->prepare($query);
    $returnValue = $stmt->execute(array(':id'=>$id, ':jezikUpisa' => $jezikUpisa, ':natpis' => $natpis, ':vrstaNatpisa' => $vrstaNatpisa,
        ':provincija' => $provincija, ':grad' => $grad, ':mestoNalaska' => $mestoNalaska, ':modernoImeDrzave' => $modernoImeDrzave,
        ':modernoMesto' => $modernoMesto, ':tip' => $tip, ':materijal' => $materijal, ':dimenzije' => $dimenzije, ':komentar' => $komentar,
        ':datumKreiranja' => $datumKreiranja, ':datumPoslednjeIzmene' => $datumPoslednjeIzmene, ':fazaUnosa' => $fazaUnosa, ':pleme' => $pleme,
        ':trenutnaLokacijaZnamenitosti'=>$trenutnaLokacijaZnamenitosti, ':korisnickoIme' => $korisnickoIme, ':LokalizovanPodatak'=>$lokalizovanPodatak,
        ':datovano' => $datovano, ':pocetakGodina' => $pocetakGodina, ':pocetakVek' => $pocetakVek, ':pocetakOdrednica' => $pocetakOdrednica,
        ':krajGodina' => $krajGodina, ':krajVek' => $krajVek, ':krajOdrednica' => $krajOdrednica ));

}catch(Exception $e){

    $db->rollBack();
    return false;
}

    //azuriranje fotografija, odnosno dodavanje novih
    $fotografije=$data->fotografije;

    if(count($data->fotografije)) {

        for ($i = 0; $i < count($data->fotografije); $i++) {

            // odredjujemo path iz url/path

            $putanja = $data->fotografije[$i];

            $arr = explode('/', $putanja);
            $naziv = $arr[count($arr) - 1];
            $naziv = explode('.', $naziv);
            $naziv = $naziv[0];

            try{

                $db->beginTransaction();

                $query = "INSERT INTO `fotografija` (naziv, putanja, objekat)
        VALUES (:naziv, :putanja, :objekat)";
                $stmt = $db->prepare($query);

                $returnValue1 = $stmt->execute(array(':naziv' => $naziv, ':putanja' => $putanja, ':objekat' => $id));
                if($returnValue1==false)
                    return false;

                $db->commit();

            }catch(Exception $e){

                $db->rollBack();
                return false;
            }


        }
    }

    return $returnValue;



}