<?php
/**
 * Created by PhpStorm.
 * User: raso
 * Date: 1/10/2015
 * Time: 1:09 PM
 */
//include 'konekcija.php';

class selektovanje {

    private static $selektor = null;
    private function __construct()
    {

    }

    public function __destruct()
    {

    }
    public static function getSelektor()
    {
        if(self::$selektor == null)
        {
            self::$selektor = new selektovanje();
            return self::$selektor;
        }
        return self::$selektor;

    }

    public function podTabela($data, $tabela, $osobinaData , $osobinaBaza)
    {
        $podtabela = "";
        $whereupit = "";
        if(property_exists($data, $osobinaData))
        {
            $whereupit = " where ".$osobinaBaza." LIKE :".$osobinaData;
//            $whereupit = " where ".$osobinaBaza." = :".$osobinaData; Stari

            //$podupit = "(select * from ".$tabela." where ".$osobina." = :".$osobina.") ".$osobina
        }
        else
        {
            $whereupit = "";
        }
        $podtabela = "(select * from ".$tabela.$whereupit.") T".$osobinaData;
        return $podtabela;
    }

    public function mesto($data)
    {

        //dodajamo u where, a ne u join
        if(property_exists($data, 'mestoNalaska'))
        {
            if(property_exists($data, 'prikaziNelokalizovanePodatke') && $data->prikaziNelokalizovanePodatke == true)
            {
                return 'where (Mesto.naziv LIKE :mestoNalaska or Toznaka.lokalizovano = false) ';

            }
            else
            {
                //ne mora left join - mora da ima mesto
                return 'where Mesto.naziv LIKE :mestoNalaska ';

            }

        }
        else
            //vracamo nesto sto je uvek tacno, ali da fiksiramo gde je where
            return "where Mesto.naziv LIKE '%' ";
    }

    public function natpis($data)
    {
        $od =  new stdClass();
        if(property_exists($data, 'natpis'))
        {
            //AND, OR, AND NOT - konstante const
            if(property_exists($data, 'natpisArg') && property_exists($data, 'natpis2')
                && ((strcasecmp($data->natpisArg, 'AND') == 0) || (strcasecmp($data->natpisArg, 'OR') == 0) || (strcasecmp($data->natpisArg, 'AND NOT') == 0) ))
            {
                $od->tip = '2';
                $od->str = ' and (Toznaka.tekstNatpisa like :natpis '. $data->natpisArg .' Toznaka.tekstNatpisa like :natpis2 ) ';
            }
            else
            {
                $od->tip = '1';
                $od->str =  ' and Toznaka.tekstNatpisa like :natpis ';
            }

        }
        else
        {
            $od->tip = '0';
            $od->str = ' ';
        }

        return $od;
    }
    public function vreme($data)
    {
        $od2 = new stdClass();
        $podupit = '';

        if(property_exists($data, 'vek'))
        {
            //prvaPolovina, drugaPolovina - konstante const
            if(property_exists($data, 'periodVeka') &&
                ( strcasecmp($data->periodVeka, 'prvaPolovina') == 0 || strcasecmp($data->periodVeka, 'drugaPolovina') == 0 )
            )
            {
                $od2->tip = '2';

                //prvaPolovina, drugaPolovina - konstante const
                $podupit = ' (Toznaka.pocetakVek = :vek and Toznaka.pocetakOdrednica = :periodVeka) '.

                    'or  '
                    //izmedju dva -- pocetak i kraj
                    . ' ('.
                    'Toznaka.krajVek IS NOT NULL and '

                    //ono sto trazi o je posle pocetnog perioda
                    //prvaPolovina, drugaPolovina - konstante const
                    . '(  ( (:periodVeka = Toznaka.pocetakOdrednica or Toznaka.pocetakOdrednica = "prvaPolovina" ) and Toznaka.pocetakVek <= :vek) or Toznaka.pocetakVek < :vek) '
                    . 'and'
                    . '(  ( (:periodVeka = Toznaka.krajOdrednica or Toznaka.krajOdrednica = "drugaPolovina" ) and Toznaka.krajVek >= :vek) or Toznaka.krajVek > :vek) '
                    .' ) '

                ;
            }
            else
            {
                $od2->tip = '1';

                $podupit = ' Toznaka.pocetakVek = :vek or (Toznaka.krajVek IS NOT NULL and Toznaka.pocetakVek <= :vek and Toznaka.krajVek >= :vek )';
            }

            if(property_exists($data, 'prikaziNedatovaneNatpise') && $data->prikaziNedatovaneNatpise)
            {
                $od2->str = 'and ( (' . $podupit . ') or Toznaka.datovano = false)';
            }
            else
                $od2->str = 'and (' . $podupit . ')';
        }
        else
        {
            $od2->tip = '0';
            $od2->str = ' ';

        }
        return $od2;
    }
    public function sortiranje($data)
    {
        $podupit = '';
        if(!property_exists($data, 'sortiranje'))
            return ' ';

        if (strcasecmp($data->sortiranje, 'poVremenu') == 0)
        {
            return ' ORDER BY Toznaka.pocetakVek, Toznaka.pocetakOdrednica DESC, Toznaka.pocetakGodina, Toznaka.krajVek, Toznaka.krajOdrednica DESC, Toznaka.krajGodina ';
        }
        else
            if (strcasecmp($data->sortiranje, 'poMestuNalaska') == 0)
            {
                return ' ORDER BY Mesto.naziv ';
            }
            else
                if (strcasecmp($data->sortiranje, 'poVrstiNatpisa') == 0)
                {
                    return ' ORDER BY vrstaNatpisa.naziv ';
                }
                else
                {
                    return ' ';
                }

    }

    public function vremeUString($godina, $vek, $odrednica)
    {
        if($godina != null)
            return $godina;
        if($odrednica == null)
            return $vek . '. vek';

        return $vek . ". vek " . $odrednica;

    }

    public function selektujFotografijeObjekta($idObjekta)
    {
        $upit = 'select * from Fotografija where objekat = :idObjekta';
        $stmt=konekcija::getConnectionInstance()->prepare($upit);
        $stmt->bindParam(':idObjekta', $idObjekta , PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return  $stmt->fetchAll();

    }
    public function selektujBibliografskePodatkeObjekta($idObjekta)
    {

        $upit = 'select IzvodBibliografskogPodatka.putanja, IzvodBibliografskogPodatka.strana, BibliografskiPodatak.skracenica, BibliografskiPodatak.naslov '.
            ' from IzvodBibliografskogPodatka JOIN  BibliografskiPodatak ON IzvodBibliografskogPodatka.bibliografskiPodatak = BibliografskiPodatak.id '.
            'WHERE IzvodBibliografskogPodatka.objekat = :idObjekta';
        $stmt=konekcija::getConnectionInstance()->prepare($upit);
        $stmt->bindParam(':idObjekta', $idObjekta , PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return  $stmt->fetchAll();

    }
    public function obradiVrsta($row)
    {
        $d = new stdClass();
        $nepromenjeni = ['modernoMesto' ,'dimenzije', 'gradNalaska', 'id', 'jezik', 'komentar', 'materijal', 'mestoNalaska', 'modernoImeDrzave', 'natpis', 'oznaka', 'provincijaNalaska', 'tip', 'vrstaNatpisa' ];
        foreach($row as $key => $value)
        {
            if(in_array($key, $nepromenjeni))
            {
                if($value != null)
                    $d->$key = $value;
                else
                    $d->$key = 'nepoznato';
            }
        }
        //trenutnaLokacijaZnamenitosti
        if($row['ustanova'] == null)
        {
            if($row['modernoMesto'] == null)
                $d->trenutnaLokacijaZnamenitosti = 'nepoznato';
            else
                $d->trenutnaLokacijaZnamenitosti = $row['modernoMesto'];
        }
        else
        {
            if($row['modernoMesto'] == null)
                $d->trenutnaLokacijaZnamenitosti = $row['ustanova'];
            else
                $d->trenutnaLokacijaZnamenitosti = $row['modernoMesto'] . "   " . $row['ustanova'];
        }

        //postavljanje polja VREME
        if($row['pocetakGodina'] == null && $row['pocetakVek'] == null )
        {
            $d->vreme = 'nepoznato';
        }
        else
        if($row['krajGodina'] == null && $row['krajVek'] == null )
        {
            $d->vreme = $this->vremeUString($row['pocetakGodina'], $row['pocetakVek'], $row['pocetakOdrednica']);
        }
        else
        {
            $d->vreme = 'Od ' . $this->vremeUString($row['pocetakGodina'], $row['pocetakVek'], $row['pocetakOdrednica']) . ' do ' . $this->vremeUString($row['krajGodina'], $row['krajVek'], $row['krajOdrednica']);
        }

        //popunjavanje fotografija
        $d->fotografije = $this->selektujFotografijeObjekta($row['id']);

        //popunjavanje bibliografskih podataka
        $d->bibliografskiPodatci = $this->selektujBibliografskePodatkeObjekta($row['id']);

        return $d;
    }
    public function selektuj($data)
    {

        $zagrade = array("{", "}", "(", ")", "[", "]");

        if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true && property_exists($data, 'periodVeka'))
            $data->periodVeka = str_replace($zagrade, "", $data->periodVeka);


        // $upit = "select Objekat.oznaka, Oznaka.natpis, VrstaNatpisa.natpis, Jezik.naziv, ModernaDrzava.naziv,
        $Toznaka =
            $this->podTabela($data, "Objekat", "oznaka", "oznaka");

        /*$Tnatpis =
            $this->podTabela($data, "Objekat", "natpis", "natpis");*/

        //$TnatpisArg
        $TprovincijaNalaska = $this->podTabela($data, "Provincija", "provincijaNalaska", "naziv");

        $TgradNalaska = $this->podTabela($data, "Grad", "gradNalaska", "naziv");

        $TmodernaDrzava = $this->podTabela($data, "ModernaDrzava", "modernoImeDrzave", "naziv");

        $TmodernoMesto = $this->podTabela($data, "ModernoMesto", "modernoMesto", "naziv");

        $Tpleme = $this->podTabela($data, "Pleme", "pleme", "naziv");

        //  $upit = "select Toznaka.* from ".$Toznaka."  JOIN ".$Tnatpis." ON Toznaka.id = Tnatpis.id;";
        // echo $upit;

        $TmestoNalaska = $this->mesto($data);


        $od = $this->natpis($data); // u where dodajemo restrikcije o natpisu
        $Tnatpis = $od->str;



        $od2 = $this->vreme($data); // // u where dodajemo restrikcije o vremenu
        $Tvreme = $od2->str;

        $Tsortiranje = $this->sortiranje($data);

        $upit = "select Toznaka.oznaka, Toznaka.tekstNatpisa AS natpis" .
            ", TprovincijaNalaska.naziv AS provincijaNalaska , TgradNalaska.naziv AS gradNalaska, Mesto.naziv AS mestoNalaska ".       //provincija, grad i mesto

            ", TmodernoImeDrzave.naziv AS modernoImeDrzave ". //moderno ime drzave i
            ", vrstaNatpisa.naziv AS vrstaNatpisa ".
            ", jezik.naziv AS jezik  ".
            " , Toznaka.tip, Toznaka.materijal, Toznaka.dimenzije  ".   //grupa tip spomenika
            " , Toznaka.komentar  ".
            " , Ustanova.naziv AS ustanova, TmodernoMesto.naziv AS modernoMesto  ". //trenutnaLokacijaZnamenitosti
            " , Toznaka.pocetakGodina, Toznaka.pocetakVek, Toznaka.pocetakOdrednica , Toznaka.krajGodina, Toznaka.krajVek, Toznaka.krajOdrednica ".
            " , Toznaka.id  ".
            //", TmodernoImeDrzave.*". ", TmodernoMesto.*, Tpleme.*".
            " FROM ".
            $Toznaka .
            " JOIN ".$TprovincijaNalaska. " ON Toznaka.provincija = TprovincijaNalaska.id " .
            " JOIN ".$TgradNalaska. " ON Toznaka.grad = TgradNalaska.id " .
            " JOIN ".$TmodernaDrzava. " ON Toznaka.modernaDrzava = TmodernoImeDrzave.id ".
            " JOIN ".$TmodernoMesto. " ON Toznaka.modernoMesto = TmodernoMesto.id ".
            " JOIN ".$Tpleme. " ON Toznaka.pleme = Tpleme.id ".
            " LEFT JOIN Mesto ON Toznaka.mesto = Mesto.id "
            //" JOIN ".$TmestoNalaska. " ON Toznaka.id = TmestoNalaska.id"
            ." LEFT JOIN vrstaNatpisa ON Toznaka.vrstaNatpisa = vrstaNatpisa.id "
            ." LEFT JOIN jezik ON Toznaka.jezik = jezik.id "
            . " LEFT JOIN ustanova on Toznaka.ustanova = Ustanova.id"
            . " "
            .$TmestoNalaska
            .$Tnatpis
            .$Tvreme
            .$Tsortiranje
        ;


        //echo $upit;
        //echo "\n";

        $stmt=konekcija::getConnectionInstance()->prepare($upit);




        //$ozn = "O1";
        //$stmt->bindParam(':oznaka', $ozn, PDO::PARAM_STR);
        if(property_exists($data, 'oznaka'))
        {
            $ozn = $data->oznaka . '%';

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $ozn = str_replace($zagrade, "", $ozn);

            $stmt->bindParam(':oznaka', $ozn, PDO::PARAM_STR);
        }

        if(property_exists($data, 'provincijaNalaska'))
        {
            $prN = $data->provincijaNalaska . "%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $prN = str_replace($zagrade, "",  $prN);

            $stmt->bindParam(':provincijaNalaska', $prN, PDO::PARAM_STR);

        }

        if(property_exists($data, 'gradNalaska'))
        {
            $grN = $data->gradNalaska . "%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $grN = str_replace($zagrade, "",  $grN);

            $stmt->bindParam(':gradNalaska', $grN, PDO::PARAM_STR);

        }

        if(property_exists($data, 'modernoImeDrzave'))
        {
            $mID = $data->modernoImeDrzave . "%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $mID = str_replace($zagrade, "",   $mID);

            $stmt->bindParam(':modernoImeDrzave', $mID, PDO::PARAM_STR);
        }

        if(property_exists($data, 'modernoMesto'))
        {
            $mM = $data->modernoMesto . "%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $mM = str_replace($zagrade, "",   $mM);

            $stmt->bindParam(':modernoMesto', $mM, PDO::PARAM_STR);
        }


        if(property_exists($data, 'pleme'))
        {
            $pl = $data->pleme."%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $pl = str_replace($zagrade, "",   $pl);

            $stmt->bindParam(':pleme', $pl , PDO::PARAM_STR);

        }

        if(property_exists($data, 'mestoNalaska'))
        {
            $mN = $data->mestoNalaska."%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $mN = str_replace($zagrade, "",   $mN);


            $stmt->bindParam(':mestoNalaska', $mN , PDO::PARAM_STR);
        }


        //bind-ujem natpis
        if($od->tip == '1' || $od->tip == '2')
        {
            $ntp ="%". $data->natpis."%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $ntp = str_replace($zagrade, "",   $ntp);

            $stmt->bindParam(':natpis', $ntp , PDO::PARAM_STR);
        }
        if( $od->tip == '2')
        {
            $ntp2 ="%". $data->natpis2."%";

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $ntp2 = str_replace($zagrade, "",   $ntp2);

            $stmt->bindParam(':natpis2', $ntp2 , PDO::PARAM_STR);
        }

        //bind-ujem vreme
        //Tu ne koristim LIKE
        if($od2->tip == '1' || $od2->tip == '2')
        {
            $vek =$data->vek;

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $vek = str_replace($zagrade, "",   $vek);

            $stmt->bindParam(':vek', $vek , PDO::PARAM_INT);
        }
        if( $od2->tip == '2')
        {
            $prV = $data->periodVeka;

            if(property_exists($data, 'rezimIgnorisanjaZagrada') && $data->rezimIgnorisanjaZagrada == true)
                $prV = str_replace($zagrade, "",   $prV);

            $stmt->bindParam(':periodVeka', $prV , PDO::PARAM_STR);
        }

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        //return json_encode( $stmt->fetchAll());

        if(property_exists($data, 'offset'))
        {
            $i = 0;

            $offs = $data->offset;
          //  echo $offs . "---\n";

            while($i <  $offs &&  $stmt->fetch() )
            {
                //$row = $stmt->fetch();
               // echo json_encode( $row);
               // echo $i . "---\n";
                $i = $i + 1;
            }



            $povratna = [];
            $i = 0;
            while(($row = $stmt->fetch()) && $i<5 )  //MAKSIMALNO VRACENIH
            {
             //   echo json_encode( $row);
               // echo "\n";
                $row = $this->obradiVrsta($row);
                array_push($povratna, $row);
                $i = $i+1;
            }
            return $povratna;

        }
        $povratna = [];
        while($row = $stmt->fetch())
        {
            $row = $this->obradiVrsta($row);
            array_push ($povratna, $row);
        }
        //return $stmt->fetchAll();
        return $povratna;
    }
    public function selektujeObjekat($idObjekta)
    {
        $upit = "select Toznaka.oznaka, Toznaka.tekstNatpisa AS natpis, TprovincijaNalaska.naziv AS provincijaNalaska , TgradNalaska.naziv AS gradNalaska, Mesto.naziv AS mestoNalaska , TmodernoImeDrzave.naziv AS modernoImeDrzave , vrstaNatpisa.naziv AS vrstaNatpisa , jezik.naziv AS jezik   , Toznaka.tip, Toznaka.materijal, Toznaka.dimenzije   , Toznaka.komentar   , Ustanova.naziv AS ustanova, TmodernoMesto.naziv AS modernoMesto   , Toznaka.pocetakGodina, Toznaka.pocetakVek, Toznaka.pocetakOdrednica , Toznaka.krajGodina, Toznaka.krajVek, Toznaka.krajOdrednica  , Toznaka.id   FROM (select * from Objekat) Toznaka JOIN (select * from Provincija) TprovincijaNalaska ON Toznaka.provincija = TprovincijaNalaska.id  JOIN (select * from Grad) TgradNalaska ON Toznaka.grad = TgradNalaska.id  JOIN (select * from ModernaDrzava) TmodernoImeDrzave ON Toznaka.modernaDrzava = TmodernoImeDrzave.id  JOIN (select * from ModernoMesto) TmodernoMesto ON Toznaka.modernoMesto = TmodernoMesto.id  JOIN (select * from Pleme) Tpleme ON Toznaka.pleme = Tpleme.id  LEFT JOIN Mesto ON Toznaka.mesto = Mesto.id  LEFT JOIN vrstaNatpisa ON Toznaka.vrstaNatpisa = vrstaNatpisa.id  LEFT JOIN jezik ON Toznaka.jezik = jezik.id  LEFT JOIN ustanova on Toznaka.ustanova = Ustanova.id where Toznaka.id = :idObjekta ";
        $stmt=konekcija::getConnectionInstance()->prepare($upit);
        $stmt->bindParam(':idObjekta', $idObjekta , PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $d =  $stmt->fetch();
        return $this->obradiVrsta($d);
    }

}
//$sl = new selektovanje();

//$a =  new stdClass();
/*
$a->oznaka = 'O(1]';
$a->provincijaNalaska = 'Thracia[';
$a->gradNalaska = 'Aleksandrovac['; //Kreljevo Aleksandrovac
$a->modernoImeDrzave = 'Srbija';
$a->modernoMesto = 'Beog';
$a->pleme = 'Apa';

$a->mestoNalaska = 'Beograd';
$a->prikaziNelokalizovanePodatke = true;


$a->natpis = 'N]';
$a->natpisArg = 'OR'; // OR, AND, AND NOT
$a->natpis2 = '1)';

$a->vek = 21;
$a->periodVeka = 'drugaPolovina';

$a->rezimIgnorisanjaZagrada = true;
*/
/*
$a->offset = 2;
$sl = selektovanje::getSelektor();

$odg = $sl->selektuj($a);
echo json_encode($odg);*/
//*/
/*
$sl = selektovanje::getSelektor();
$odg = $sl->selektujeObjekat(1);
echo json_encode($odg);
*/
?>
