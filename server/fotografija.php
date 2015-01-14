<?php
include 'konekcija.php';

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
			
            $query = $db->prepare( "select distinct putanja from fotografija where objekat = $objectId");

            $query->execute();

            $result->error_status = false;
            $result->data = $query->fetchAll(PDO::FETCH_OBJ);
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