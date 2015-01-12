<?php
include 'konekcija.php';

$result = new stdClass();
try{

    $db=konekcija::getConnectionInstance();
	
	$method = $_SERVER['REQUEST_METHOD'];

    if($method === 'GET')
    {
        $query="select * from mydb.podesavanja";
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
		if(property_exists($data, "vrednost"))
            $naziv = $data->vrednost;
		$query = $db->prepare("update mydb.podesavanja set vrednost='$vrednost' where id=$id");
		$query->execute();
		$broj_redova = $query->rowCount();
		if($broj_redova==1) $result->error_status = false;
		else $result->error_status = true;
    }
   

}
catch(Exception $e){

    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>
