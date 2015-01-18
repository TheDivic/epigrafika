<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/11/2015
 * Time: 11:10 PM
 */
if(!isset($_SESSION))
{
    session_start();
}

function azuriraj($data, $db){
    date_default_timezone_set("Europe/Belgrade");

    $data = json_decode($data);

    $id = $data->id;

    $natpis = $data->natpis;
    $natpis=trim($natpis);
    if (!preg_match("#^[a-zA-Z0-9 \.\(\)\'\,\.]+$#", $natpis))
        return false;



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
        if(!preg_match("#^[a-zA-Z ]+$#", $mestoNalaska))
            return false;

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
                $returnValue1 = $stmt->execute();
                if(!$returnValue1)
                    return false;

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
    $trenutnaLokacijaZnamenitosti=trim($trenutnaLokacijaZnamenitosti);
    if(!preg_match("#^[a-zA-Z ]+$#", $trenutnaLokacijaZnamenitosti))
        return false;


    $query="SELECT count(*) FROM `ustanova` WHERE naziv=:trenutnaLokacijaZnamenitosti";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":trenutnaLokacijaZnamenitosti", $trenutnaLokacijaZnamenitosti, PDO::PARAM_STR);
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
            $returnValue1 = $stmt->execute();
            if(!$returnValue1)
                return false;

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
    $pleme=trim($pleme);
    if(!preg_match("#^[a-zA-Z ]+$#", $pleme))
        return false;


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
            $returnValue1 = $stmt->execute();
            if(!$returnValue1)
                return false;

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

//        radimo sa vremenom, dovrsiti
    $vreme = $data->vreme;

    if($vreme ==0){

        $datovano = 0;

        $pocetakGodina = null;
        $pocetakVek = null;
        $pocetakOdrednica = null;
        $krajGodina = null;
        $krajVek = null;
        $krajOdrednica = null;

    }
    //velika mogucnost greske


    else if($vreme==1){
        $datovano = true;
        $pocetakGodina = $data->pocetakGodina;
        $pocetakVek = $data->pocetakVek;
        $pocetakOdrednica = $data->pocetakPeriodVeka;
        $krajGodina = $data->krajGodina;
        $krajVek = $data->krajVek;
        $krajOdrednica = $data->krajPeriodVeka;


    }

//  datum poslednje izmene

    $datumPoslednjeIzmene=date("Y-m-d");

//       faza unosa
    $fazaUnosa = $data->fazaUnosa;

    //tip i ostalo
    $tip = trim($data->tipZnamenitosti);
    if(!preg_match("#^[a-zA-Z ]*$#", $tip))
        return false;


    $materijal = trim($data->materijalZnamenitosti);
    if(!preg_match("#^[a-zA-Z ]*$#", $materijal))
        return false;


    $komentar = trim($data->komentar);
    if (!preg_match("#^[a-zA-Z0-9 \.\(\)\'\,\.]*$#", $komentar))
        return false;



    //dimenzije objekta, trenutno nemamo format, prepraviti
    $dimenzije = $data->sirina;
    if($data->sirina!=null && !is_numeric($data->sirina))
        return false;
    $dimenzije.= ':';
    $dimenzije.=$data->visina;
    if($data->sirina!=null && !is_numeric($data->visina))
        return false;

    $dimenzije.= ':';
    $dimenzije.=$data->duzina;
    if($data->sirina!=null && !is_numeric($data->duzina))
        return false;

    $korisnickoIme=$_SESSION['korisnickoIme'];

    if(!preg_match("#^[a-zA-Z_0-9]+$#", $korisnickoIme))
        return false;

    $query = "SELECT status FROM korisnik WHERE korisnickoIme=:korisnickoIme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":korisnickoIme", $korisnickoIme, PDO::PARAM_STR);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $status = $o[0][0];

    $query = "SELECT privilegije FROM korisnik WHERE korisnickoIme=:korisnickoIme";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":korisnickoIme", $korisnickoIme, PDO::PARAM_STR);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $privilegije = $o[0][0];

    if(strcmp($status, "aktivan")!=0 || strcmp($privilegije, "admin")!=0)
        return false;





    $query="UPDATE objekat set jezik = :jezikUpisa, tekstNatpisa = :natpis, vrstaNatpisa = :vrstaNatpisa,
        provincija = :provincija, grad = :grad, mesto = :mestoNalaska, modernaDrzava = :modernoImeDrzave,
        modernoMesto = :modernoMesto, tip = :tip, materijal = :materijal, dimenzije = :dimenzije, komentar = :komentar,
         datumPoslednjeIzmene = :datumPoslednjeIzmene, faza = :fazaUnosa, pleme = :pleme,
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
         ':datumPoslednjeIzmene' => $datumPoslednjeIzmene, ':fazaUnosa' => $fazaUnosa, ':pleme' => $pleme,
        ':trenutnaLokacijaZnamenitosti'=>$trenutnaLokacijaZnamenitosti, ':korisnickoIme' => $korisnickoIme, ':LokalizovanPodatak'=>$lokalizovanPodatak,
        ':datovano' => $datovano, ':pocetakGodina' => $pocetakGodina, ':pocetakVek' => $pocetakVek, ':pocetakOdrednica' => $pocetakOdrednica,
        ':krajGodina' => $krajGodina, ':krajVek' => $krajVek, ':krajOdrednica' => $krajOdrednica ));
    if($returnValue==false)
        return false;

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

    //sada bibliografski podaci


    if($data->bibliografskoPoreklo!=null || $data->bibliografskoPorekloSkracenica!=null
        || count($data->bibliografskiPdfLinkovi)!=0) {

        if($data->bibliografskoPoreklo!=null)
            $bibliografskoPoreklo = trim($data->bibliografskoPoreklo);
        else
            $bibliografskoPoreklo = '';
        if($data->bibliografskoPorekloSkracenica!=null)
            $bibliografskoPorekloSkracenica = trim($data->bibliografskoPorekloSkracenica);
        else
            $bibliografskoPorekloSkracenica = '';

        $bibliografskiPdfLinkovi = $data->bibliografskiPdfLinkovi;

        //ovo promeniti ako se nekad organizuje po folderima, za sad ce dobro ici ovako
        $putanja = '../uploads/biblio';

        $idBP = $data->idBibliografskogPodatka;
        //ako se promeni to, radi ovako nesto
        /*    if(count($data->bibliografskiPdfLinkovi)) {
            $url = $data->bibliografskiPdfLinkovi[0];

            $arr = explode('/', $url);

            $length = count($arr);

            $url = '';

            for ($i = 0; $i < $length - 1; $i++)
                $url .= $arr[$i] . '/';


            $putanja = $bibliografskiPdfLinkovi[0];
        }

        else $url='';
    */

        //u slucaju da ne postoji bibliografski podatak
        if($idBP==null) {

            $query = "SELECT count(*) FROM `BibliografskiPodatak`
        WHERE skracenica=:bibliografskoPorekloSkracenica and naslov = :bibliografskoPoreklo";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":bibliografskoPorekloSkracenica", $bibliografskoPorekloSkracenica, PDO::PARAM_STR);
            $stmt->bindParam(":bibliografskoPoreklo", $bibliografskoPoreklo, PDO::PARAM_STR);
            $stmt->execute();
            $o = $stmt->fetchAll();

            if ($o[0][0] == 0) {

                try {

                    $db->beginTransaction();

                    // sada vrsimo unos u tabelu bibliografski podatak
                    $query = "INSERT INTO `bibliografskipodatak` (skracenica, naslov, putanja) VALUES (:skracenica, :naslov, :putanja)";
                    $stmt = $db->prepare($query);
                    $returnValue1 = $stmt->execute(array(':skracenica' => $bibliografskoPorekloSkracenica, ':naslov' => $bibliografskoPoreklo, 'putanja' => $putanja));

                    if ($returnValue1 == false)
                        return false;

                    $db->commit();

                } catch (Exception $e) {

                    $db->rollBack();
                    return false;

                }


            }
        }
        //u slucaju da postoji, update-ujemo ga
        else{
            $query = "UPDATE BibliografskiPodatak SET skracenica = :skracenica, naslov = :naslov
                      WHERE id = :id";

            try{
                $db->beginTransaction();
                $stmt = $db->prepare($query);
                $returnValue1 = $stmt->exectute(array(':id' => $idBP, ':skracenica' => $bibliografskoPorekloSkracenica,
                ':naslov' => $bibliografskoPoreklo));
                if(!$returnValue1)
                    return false;

            }catch (Exception $e){
                $db->rollback();
                return false;
            }


        }

        //sada radimo sa izvodomBibliografskog podatka

        if(count($bibliografskiPdfLinkovi)> 0) {
            //nalazenje id BibPodatka
            $query = "SELECT id FROM `BibliografskiPodatak`
        WHERE skracenica=:bibliografskoPorekloSkracenica and naslov = :bibliografskoPoreklo";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":bibliografskoPorekloSkracenica", $bibliografskoPorekloSkracenica, PDO::PARAM_STR);
            $stmt->bindParam(":bibliografskoPoreklo", $bibliografskoPoreklo, PDO::PARAM_STR);
            $stmt->execute();
            $o = $stmt->fetchAll();
            $idBibliografskogPodatka = $o[0][0];




            for ($i = 0; $i < count($data->bibliografskiPdfLinkovi); $i++) {

                //izracunavamo broj nove strane
                $query = "SELECT MAX(strana) FROM IzvodBibliografskogPodatka
                          where objekat = :objekat and bibliografskiPodatak=:bibliografskiPodatak";
                $stmt= $db->preprare($query);
                $stmt->execute(array(':objekat' => $id, ':bibliografskiPodatak' => $idBibliografskogPodatka));
                $o = $stmt->fetchAll();

                $strana = $o[0][0] + 1;
                // odredjujemo path iz url/path

                $putanja = $data->bibliografskiPdfLinkovi[$i];

                try{

                    $db->beginTransaction();


                    $query = "INSERT INTO `izvodbibliografskogpodatka` (objekat, bibliografskiPodatak, strana, putanja)
        VALUES (:objekat, :bibliografskiPodatak, :strana, :putanja)";
                    $stmt = $db->prepare($query);
                    $returnValue1 = $stmt->execute(array(':objekat' => $id, ':bibliografskiPodatak' => $idBibliografskogPodatka,
                        ':strana' => $strana, ':putanja' => $putanja));
                    if($returnValue1 = false)
                        return false;

                    $db->commit();

                }catch(Exception $e){

                    $db->rollBack();
                    return false;

                }


            }
        }
    }



    return true;



}