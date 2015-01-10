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
		if($_GET['type'] === 'jedinsten_username'){
				$ime = $_GET['user']; 
				$query = $db->prepare("select * from mydb.korisnik where korisnickoIme=$ime" );
				$query->execute();
				$result->error_status = false;
				$result->data = $query->fetchAll();
				if(count($result->data) == 0)
					$result->isEmpty = true;
				else
					$result->isEmpty = false;

		}
		if($_GET['type'] === 'login'){
				$ime = $_GET['user']; 
				$sifra=$_GET['pass'];
				$query = $db->prepare("select * from mydb.korisnik where korisnickoIme=$ime and sifra=$sifra" );
				$query->execute();
				$result->error_status = false;
				$result->data = $query->fetchAll();
				if(count($result->data) == 0)
					$result->isEmpty = true;
				else{
					$result->isEmpty = false;

		}
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