<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/6/2015
 * Time: 10:22 PM
 */

include '../settings.php';
class Konekcija extends PDO
{
    private static $db = null;

    public static function getConnectionInstance(){
        if(self::$db==null){
            $settings = $GLOBALS['settings'];
            self::$db = new PDO('mysql:dbname='.$settings['mysql_db'].'; host='.$settings['mysql_host'], $settings['mysql_user'], $settings['mysql_password'],
            array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return self::$db;
    }

    /*
    public static function disconnect(){
        self::$db=null;
    } */

}
$kon = Konekcija::getConnectionInstance();

?>
