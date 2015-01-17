<?php

function obrisi($id, $db){


    // prvo brisemo sve fotografije koje se odnose na objekat koji se brise...

    try{

        $query = "SELECT * FROM `fotografija`
        WHERE objekat = :objekat";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":objekat", $id, PDO::PARAM_INT);
        $stmt->execute();
        $o = $stmt->fetchAll();

        foreach($o as $row){
            $rez = unlink($row['putanja']);
            if ($rez == false)
                return false;

        }


        $db->beginTransaction();

        $query="DELETE FROM `fotografija` WHERE objekat = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $returnValue1=$stmt->execute();
        if($returnValue1==false)
            return false;

        $db->commit();

    }catch(Exception $e){

        $db->rollBack();
        return false;
    }

    //sada brisem bibliografske izvode

    $query = "SELECT * FROM `IzvodBibliografskogPodatka`
        WHERE objekat = :id";
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
             WHERE objekat = :objekat and bibliografskiPodatak = :bibliografskiPodatak
             and strana = :strana";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":objekat", $row['objekat'], PDO::PARAM_INT);
            $stmt->bindParam(":bibliografskiPodatak", $row['bibliografskiPodatak'], PDO::PARAM_INT);
            $stmt->bindParam(":strana", $row['strana'], PDO::PARAM_INT);

            $returnValue1 = $stmt->execute();
            if($returnValue1==false)
                return false;

            $db->commit();

        }catch (Exception $e){
            $db->rollback();
            return false;
        }

    }


    try{

        $db->beginTransaction();

        $query="DELETE FROM `objekat` WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $returnValue=$stmt->execute();

        $db->commit();

    }catch(Exception $e){

        $db->rollBack();
        return false;

    }


    return $returnValue;


}



?>