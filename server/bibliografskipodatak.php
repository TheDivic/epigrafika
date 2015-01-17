<?php
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

    $query = "SELECT * FROM `IzvodBibliografskogPodatka`
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
             WHERE objekat = :objekat and bibliografskiPodatak = :bibliografskiPodatak
             and strana = :strana";
            $stmt = $db->prepare($query);
            $stmt->bindParam(":objekat", $row['objekat'], PDO::PARAM_INT);
            $stmt->bindParam(":bibliografskiPodatak", $row['bibliografskiPodatak'], PDO::PARAM_INT);
            $stmt->bindParam(":strana", $row['strana'], PDO::PARAM_INT);

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
try
{
    $db=konekcija::getConnectionInstance();

    $method = $_SERVER['REQUEST_METHOD'];

    if($method === 'GET')
    {
        //Dostava podataka

        if($_GET['type'] === 'byObject')
        {
			//Vrati sve putanje do slika za dati objekat
			$objectId = $_GET['objectId'];
			
            $query = $db->prepare( 	"select b.naslov, ib.strana, ib.path
									from bibliografskipodatak b join izvodbibliografskogpodatka ib 
									on b.id = ib.bibliografskiPodatak
									where ib.objekat = $objectId");

            $query->execute();

            $result->error_status = false;
            $result->data = $query->fetchAll(PDO::FETCH_OBJ);
        }
    }

    if ($method === 'DELETE') {

        $number_of_url_elements=0;

        if(isset($_SERVER['PATH_INFO'])){
            $url_elements=explode("/", $_SERVER['PATH_INFO']);
            $number_of_url_elements=count($url_elements)-1;
        }

        if($number_of_url_elements ==1) {

            $id = intval($url_elements[1]);
            try {
                $rezultat = brisiBibliografskiPodatak($id, $db);
                if($rezultat==true)
                    $result->error_status=false;
                else{
                    $result->error_status=true;
                    $result->error_message = $e->getMessage();
                }



            } catch (Exception $e) {
                $result->error_status=true;
                $result->error_message = $e->getMessage();
            }

        }
        else{
            $result->error_status=true;
            $result->error_message = 'Bad request!';

        }



    }
}
catch(Exception $e)
{
    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>