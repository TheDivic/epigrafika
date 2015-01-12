<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/6/2015
 * Time: 10:22 PM
 */
class Konekcija extends PDO
{

    private static $db = null;

    public static function getConnectionInstance(){
        if(self::$db==null){
            self::$db = new PDO('mysql:dbname=mydb; host=localhost', 'root', "",
            array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$db;
    }

    /*
    public static function disconnect(){
        self::$db=null;
    } */

}

?>
