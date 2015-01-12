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
if($method === 'POST')
    {
        $result->message = "Primljen zahtev za unos korisnika.";
	$data=json_decode(file_get_contents('php://input'));
	$result->ulazniPodaci = $data;
        if(property_exists($data, "ime"))
            $ime = $data->ime;
        if(property_exists($data, "prezime"))
            $prezime = $data->prezime;
        if(property_exists($data, "email"))
            $email = $data->email;
        if(property_exists($data, "institucija"))
            $institucija = $data->institucija;
        if(property_exists($data, "username"))
            $username = $data->username;
        if(property_exists($data, "password"))
            $password = $data->password;
        if(property_exists($data, "info"))
            $info = $data->info;
        
        $mod = "nepoznat";
        $datum=date("Y-d-m");
        $status="nepoznat";
        
        $query = $db->prepare("INSERT INTO `mydb`.`korisnik` (`korisnickoIme`, `sifra`, `ime`,`prezime`,`email`,`institucija`,`dodatneInformacije`,`mod`,`datumRegistrovanja`,`status`) VALUES ('$username','$password', '$ime', '$prezime', '$email', '$institucija', '$info', '$mod', $datum, '$status' )");
	$query->execute();  
        $broj_redova = $query->rowCount();
	if($broj_redova==1) 
            $result->error_status = false;
	else 
            $result->error_status = true;
    }
}
catch(Exception $e)
{
    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>