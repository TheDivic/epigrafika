<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 12/17/2014
 * Time: 4:57 PM
 */
//kljucna rec je promeni
class DB{

    public static $connection;


    public function __construct(){
        //promeni konekciju na bazu,kad dobijes kredencijale
        if(!isset(self::$connection))
            self::$connection=new PDO('mysql:host=localhost;dbname=mydb', 'root', '',
                array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    }

    public function __destruct(){
        self::$connection=null;

    }

// bibliografski podaci je niz
    public function unesi($oznaka, $jezik, $natpis, $vrsta_natpisa, IzvornoMestoNalaska $izvorno_mesto_nalaska,
    $moderno_ime_drzave, $trenutna_lokacija_znamenitosti, Vreme $vreme,
    InformacijeOZnamenitosti $informacije_o_znamenitosti,
    ArrayObject $bibliografski_podaci, $komentar, ArrayObject $fotografije_i_nazivi, $faza_unosa){

$objekat = $_GET['drzava'];
}

public function podTabela($data, $tabela, $osobina)
{
    $podtabela = "";
    $whereupit = "";
    if(property_exists($data, $osobina))
    {
        $whereupit = " where ".$osobina." = :".$osobina;
        //$podupit = "(select * from ".$tabela." where ".$osobina." = :".$osobina.") ".$osobina
    }
    else
    {
        $whereupit = "";
    }
    $podtabela = "(select * from ".$tabela.$whereupit.") T".$osobina;
    return $podtabela;
}
public function selektuj($data)
{
   // $upit = "select Objekat.oznaka, Oznaka.natpis, VrstaNatpisa.natpis, Jezik.naziv, ModernaDrzava.naziv,
    $Toznaka =
      $this->podTabela($data, "Objekat", "oznaka");
    $Tnatpis =
     $this->podTabela($data, "Objekat", "natpis");

    $upit = "select Toznaka.* from ".$Toznaka."  JOIN ".$Tnatpis." ON Toznaka.id = Tnatpis.id;";
   // echo $upit;

    $stmt=self::$connection->prepare($upit);
    $ozn = "O1";
    $stmt->bindParam(':oznaka', $ozn, PDO::PARAM_STR);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    echo json_encode( $stmt->fetchAll());
}

    /*
     (SELECT c.id
               COUNT(*) 'num'
          FROM TABLE c
         WHERE c.column = 'a'
      GROUP BY c.id) ta
     */

  //  $oznaka_podupit = "select * from"



//
//    public function read(){
//
//        $query="select id, title, price from books";
//
//        $stmt=self::$connection->query($query);
//
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
//
//    }
//
//    public function read_single($id){
//        $query="select id, title, price from books where id=:id";
//
//        $stmt=self::$connection->prepare($query);
//
//        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
//
//        $stmt->execute();
//
//        $result=$stmt->fetchObject();
//
//        return $result;
//
//    }
//
//
//    public function insert($new_title, $new_price){
//        $query="insert into books values ('', :new_title, :new_price)";
//
//        $stmt=self::$connection->prepare($query);
//
//        $stmt->bindParam(":new_title", $new_title, PDO::PARAM_STR);
//        $stmt->bindParam(":new_price", $new_price, PDO::PARAM_INT);
//
//        if($stmt->execute()){
//            return self::$connection->lastInsertId();
//        }
//
//        return -1;
//    }
//
//    public function update($id, $new_title, $new_price){
//        $query="update books set title=:new_title, price=:new_price where id=:id";
//
//        $stmt=self::$connection->prepare($query);
//
//        $stmt->bindParam(":new_title", $new_title, PDO::PARAM_STR);
//        $stmt->bindParam(":new_price", $new_price, PDO::PARAM_INT);
//        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
//
//        return $stmt->execute();
//    }
//
//    public function delete($id){
//        $query="delete from books where id=:id";
//
//        $stmt=self::$connection->prepare($query);
//
//        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
//
//        return $stmt->execute();
//    }
}
$db = new DB();
//$a = array('oznaka' => 'ozn1');
$a->oznaka = 'ozn1';
//var_dump(property_exists($a, 'oznaka'));
//echo $db->podTabela($a, "Objekat", "oznaka");
$db->selektuj($a);

?>