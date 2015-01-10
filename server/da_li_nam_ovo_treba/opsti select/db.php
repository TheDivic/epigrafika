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
    public function unesi($data){

        $podaci = json_decode($data);

        $oznaka = $podaci->oznaka;
        $natpis = $podaci->natpis;

        /*dobijamo ime jezika pa spajamo sa bazom da bismo dobili id */
        $jezik = $podaci->jezik;
        $query="SELECT id FROM `jezik` WHERE naziv=:jezik";
        $stmt = self::$connection->prepare($query);
        $stmt->bindParam(":jezik", $jezik, PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $jezik= $o[0][0];


        //Potrebno je odrediti id vrsteNatpisa
        $vrstaNatpisa = $podaci->vrstaNatpisa;
        $query="SELECT id FROM `vrstanatpisa` WHERE naziv=:vrstaNatpisa";
        $stmt = self::$connection->prepare($query);
        $stmt->bindParam(":vrstaNatpisa", $vrstaNatpisa, PDO::PARAM_STR);
        $stmt->execute();
        $o=$stmt->fetchAll();
        $vrstaNatpisa=$o[0][0];

        $lokalizovano = $podaci->lokalizovano;
        if($lokalizovano==true){
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

        }





















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