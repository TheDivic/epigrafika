<?php


function obrisi($id, $db){


    // prvo brisemo sve fotografije koje se odnose na objekat koji se brise...

    $query="DELETE FROM `fotografija` WHERE objekat = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $returnValue1=$stmt->execute();

    // sada brisemo objekat sa datim id-om...

    $query="DELETE FROM `objekat` WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $returnValue2=$stmt->execute();

    // proveriti jos u vezi sa bibliografskim podacima...

    return $returnValue1 && $returnValue2;


}

?>