<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/17/2015
 * Time: 5:55 PM
 */

include 'konekcija.php';

function brisiBibliografskiPodatak($id, $db){
    $query = "SELECT count(*) FROM `BibliografskiPodatak`
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $o = $stmt->fetchAll();

    if ($o[0][0] == 0)
        return false;

    $query = "SELECT count(*) FROM `IzvodBibliografskogPodatka`
        WHERE bibliografskiPodatak = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $o = $stmt->fetchAll();

//brisem prvo sve izvode vezane za bibliografski podatak
    foreach($o as $row){
        $rez = unlink($row['putanja']);
        if ($rez == false)
            return false;

        try {
            $db->beginTransaction();
            $query = "DELETE FROM `IzvodBibliografskogPodatka`
             WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":id", $row['id'], PDO::PARAM_INT);
            $stmt->execute();
            $db->commit();

        }catch (Exception $e){
            return false;
        }

    }
    try {
        $db->beginTransaction();
        $query = "DELETE FROM `BibliografskiPodatak`
             WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $db->commit();

    }catch (Exception $e){
        return false;
    }

    return true;

}


$result = new stdClass();
try {
    $db = konekcija::getConnectionInstance();


    $rezultat = brisiBibliografskiPodatak(3, $db);
    if ($rezultat == true)
        $result->error_status = false;
    else {
        $result->error_status = true;
        $result->error_message = $e->getMessage();
    }


}
catch(Exception $e)
{
    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>