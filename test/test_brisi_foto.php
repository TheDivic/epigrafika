<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/17/2015
 * Time: 4:12 PM
 */
include "konekcija.php";
function obrisi($id, $db)
{
    $query = "SELECT count(*) FROM `fotografija`
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $o = $stmt->fetchAll();

    if ($o[0][0] == 0)
        return false;
    else
        $query = "SELECT putanja FROM `fotografija`
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $putanja = $o[0][0];

    $rez = unlink($putanja);
    if ($rez == false)
        return false;

    $db->beginTransaction();
    $query = "DELETE FROM `fotografija`
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    return $stmt->execute();


}

$result = new stdClass();
try {

    $db = konekcija::getConnectionInstance();
    echo obrisi(4, $db);
}catch(Exception $e){

    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
