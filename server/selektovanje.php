<?php
/**
 * Created by PhpStorm.
 * User: raso
 * Date: 1/10/2015
 * Time: 1:09 PM
 */
include 'konekcija.php';

class selektovanje {

    private static $selektor = null;
    private function __construct()
    {

    }

    private function __destruct()
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
        if(property_exists($data, 'mestoNalaska'))
        {
            if(property_exists($data, 'prikaziNelokalizovanePodatke') && $data->prikaziNelokalizovanePodatke == true)
            {
                return 'where Mesto.naziv LIKE :mestoNalaska or Toznaka.lokalizovano = false';

            }
            else
            {
                //ne mora left join - mora da ima mesto
                return 'where Mesto.naziv LIKE :mestoNalaska';

            }

        }
        else
            return "where Mesto.naziv LIKE '%'";
    }

    public function selektuj($data)
    {
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

        $upit = "select Toznaka.*".
            ", TmodernoImeDrzave.*". ", TmodernoMesto.*, Tpleme.*".
            " FROM ".
            $Toznaka .
            " JOIN ".$TprovincijaNalaska. " ON Toznaka.provincija = TprovincijaNalaska.id " .
            " JOIN ".$TgradNalaska. " ON Toznaka.grad = TgradNalaska.id " .
            " JOIN ".$TmodernaDrzava. " ON Toznaka.modernaDrzava = TmodernoImeDrzave.id ".
            " JOIN ".$TmodernoMesto. " ON Toznaka.modernoMesto = TmodernoMesto.id ".
            " JOIN ".$Tpleme. " ON Toznaka.pleme = Tpleme.id ".
            " LEFT JOIN Mesto ON Toznaka.mesto = Mesto.id "
            //" JOIN ".$TmestoNalaska. " ON Toznaka.id = TmestoNalaska.id"
            .$TmestoNalaska
            ;


        echo $upit;
        echo "\n";

        $stmt=konekcija::getConnectionInstance()->prepare($upit);


        //$ozn = "O1";
        //$stmt->bindParam(':oznaka', $ozn, PDO::PARAM_STR);
        if(property_exists($data, 'oznaka'))
        {
            $ozn = $data->oznaka . '%';
            $stmt->bindParam(':oznaka', $ozn, PDO::PARAM_STR);
        }

        if(property_exists($data, 'provincijaNalaska'))
        {
            $prN = $data->provincijaNalaska . "%";
            $stmt->bindParam(':provincijaNalaska', $prN, PDO::PARAM_STR);

        }

        if(property_exists($data, 'gradNalaska'))
        {
            $grN = $data->gradNalaska . "%";
            $stmt->bindParam(':gradNalaska', $grN, PDO::PARAM_STR);

        }

        if(property_exists($data, 'modernoImeDrzave'))
        {
            $mID = $data->modernoImeDrzave . "%";
            $stmt->bindParam(':modernoImeDrzave', $mID, PDO::PARAM_STR);
        }

        if(property_exists($data, 'modernoMesto'))
        {
            $mM = $data->modernoMesto . "%";
            $stmt->bindParam(':modernoMesto', $mM, PDO::PARAM_STR);
        }


        if(property_exists($data, 'pleme'))
        {
            $pl = $data->pleme."%";
            $stmt->bindParam(':pleme', $pl , PDO::PARAM_STR);

        }

        if(property_exists($data, 'mestoNalaska'))
        {
            $mN = $data->mestoNalaska."%";
            $stmt->bindParam(':mestoNalaska', $mN , PDO::PARAM_STR);
        }
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        echo json_encode( $stmt->fetchAll());
    }

}
//$sl = new selektovanje();
//$a->oznaka = 'O1';
$a =  new stdClass();
//$a->oznaka = 'O1';
//$a->provincijaNalaska = 'Thracia';
//$a->gradNalaska = 'Aleksandrovac'; //Kreljevo Aleksandrovac
$a->modernoImeDrzave = 'Srbija';
$a->modernoMesto = 'Beog';
$a->pleme = 'Apa';

$a->mestoNalaska = 'Beograd';
$a->prikaziNelokalizovanePodatke = true;


$sl = selektovanje::getSelektor();
$sl->selektuj($a);

?>
