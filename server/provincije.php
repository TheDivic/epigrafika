<?php
include 'konekcija.php';

$result = new stdClass();
try{

    $db=konekcija::getConnectionInstance();

    $method = $_SERVER['REQUEST_METHOD'];
	
    if($method === 'GET')
    {
        $query="select * from mydb.provincija where id!=-1";

        $stmt = $db->prepare($query);
        $stmt->execute();
        $query_result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $remaining = 0;
        $limit = 10;
        $result->data = [];

        if(isset($_GET['offset'])) {
            $offset = intval($_GET['offset']);
            
            for($i = $offset; $i < sizeof($query_result) && $i < $offset + $limit; $i++){
                $result->data[] = $query_result[$i];
            }
            $remaining = (sizeof($query_result) - $offset - $limit) > 0 ? (sizeof($query_result) - $offset - $limit) : 0;
        }
        else {
            $result->data = $query_result;
        }

        $result->remaining = $remaining;
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
	else if($method==='POST')
	{
		$result->message = "Primljen zahtev za unos objekta";
		$data=json_decode(file_get_contents('php://input'));
		$result->ulazniPodaci = $data;
		if(property_exists($data, "naziv"))
            $naziv = $data->naziv;
		if(property_exists($data, "pocetak"))
            $pocetak= $data->pocetak;
		if(property_exists($data, "kraj"))
            $kraj = $data->kraj;
		
		$query = $db->prepare("insert into mydb.provincija(naziv,pocetak,kraj) values('$naziv','$pocetak','$kraj')");
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

}
catch(Exception $e){

    $result->error_status=true;
    $result->error_message = $e->getMessage();
	$result->poruka="Objekat nije moguce izbrisati iz baze zbog veza sa drugim tabelama.";

}

echo json_encode($result);
?>
