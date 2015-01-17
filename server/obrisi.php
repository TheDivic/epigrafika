<?php

function obrisi($id, $db){


    // prvo brisemo sve fotografije koje se odnose na objekat koji se brise...

    try{

        $db->beginTransaction();

        $query="DELETE FROM `fotografija` WHERE objekat = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $returnValue1=$stmt->execute();

        $db->commit();

    }catch(Exception $e){

        $db->rollBack();
        echo "Failed: " . $e->getMessage();

    }
    // brisemo sve izvode bibliografskih podataka koje se odnose na objekat koji se brise...
    // ali prvo izdvajamo id bibliografskog podatka da bismo mogli i njega izbrisati
    // vazan je redosled


    $query="SELECT bibliografskiPodatak FROM `izvodbibliografskogpodatka` WHERE objekat = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $returnValue1=$stmt->execute();

    $bibliografskiPodatak=$stmt->fetchAll();
    if($bibliografskiPodatak) {
        $bibliografskiPodatak = $bibliografskiPodatak[0][0];

        // sada mozemo da ga obrisemo

        try{


            // brisemo bibliografski podatak koje se odnose na objekat koji se brise...

            $db->beginTransaction();

            $query = "DELETE FROM `izvodbibliografskogpodatka` WHERE objekat = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $returnValue1 = $stmt->execute();


            $db->commit();

        }catch(Exception $e){

            $db->rollBack();
            echo "Failed: " . $e->getMessage();

        }

        // brisemo bibliografski podatak koje se odnose na objekat koji se brise...

        try{

            $db->beginTransaction();

            $query = "DELETE FROM `bibliografskipodatak` WHERE id = :id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":id", $bibliografskiPodatak, PDO::PARAM_INT);
            $returnValue1 = $stmt->execute();


            $db->commit();

        }catch(Exception $e){

            $db->rollBack();
            echo "Failed: " . $e->getMessage();

        }
    }

    // sada brisemo objekat sa datim id-om...

    try{


        $db->beginTransaction();

        $query="DELETE FROM `objekat` WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $returnValue2=$stmt->execute();

        $db->commit();

    }catch(Exception $e){

        $db->rollBack();
        echo "Failed: " . $e->getMessage();

    }


    return $returnValue1 && $returnValue2;


}



?>