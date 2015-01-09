<?php
include 'konekcija.php';

$result = new stdClass();
try{

    $db=konekcija::getConnectionInstance();

    $method = $_SERVER['REQUEST_METHOD'];
	
    if($method === 'GET')
    {
        $query="select * from mydb.provincija";

	$stmt = $db->prepare($query);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);

	$result->error_status=false;
	$result->data = $stmt->fetchAll();
    }
    else if($method === 'PUT')
    {
	$result->message = "Primljen zahtev za promenu objekta";
	$data=json_decode(file_get_contents('php://input'));
	$result->ulazniPodaci = $data;
	$id = intval($_GET["id"]);
	if(property_exists($data, "naziv"))
            $naziv = $data->naziv;
	if(property_exists($data, "pocetak"))
            $pocetak= $data->pocetak;
	if(property_exists($data, "kraj"))
            $kraj = $data->kraj;
		
	$query = $db->prepare("update mydb.provincija set naziv='$naziv', pocetak='$pocetak', kraj='$kraj' where id=$id");
	$query->execute();
            
	$broj_redova = $query->rowCount();
	if($broj_redova==1)
	{
            $result->error_status = false;
	}
	else
	{
            $result->error_status = true;
	}
		
    }
    else if($method === 'DELETE')
    {
        $result->message = "Primljen zahtev za brisanje";
	if(isset($_GET["id"])){
            $id = intval($_GET["id"]);
	$query = $db->prepare("delete from mydb.provincija where id=$id");
	$query->execute();
        $broj_redova = $query->rowCount();
	if($broj_redova!=0)
        {
            $result->error_status = false;
            $result->poruka="Objekat je obrisan iz baze.";
	}
	else
        {
            $result->error_status = true;
	}
	}
    }

}
catch(Exception $e){

    $result->error_status=true;
    $result->error_message = $e->getMessage();
	$result->poruka="Objekat nije moguce izbrisati iz baze zbog veza sa drugim tabelama.";

}

echo json_encode($result);
?>
