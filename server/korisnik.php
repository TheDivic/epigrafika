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
            if($_GET['type'] === 'zaboravljenaSifra'){
                    //TO DO - SLANJE MAILA na email korisnika sa sifrom.
                    $ime = $_GET['user']; 
                    $query = $db->prepare("select * from mydb.korisnik where korisnickoIme=$ime" );
                    $query->execute();
                    $result->error_status = false;
                    $data = $query->fetch(PDO::FETCH_OBJ);
                    if($data === NULL){
                        $result->message = "ne postoji korisnicko ime.";
                    }
                    else{
						$result->message = "Poslat mail na adresu.";
                    }
                    
                    $email = $data->email;
                    $headers = "From: noreply@example.com\r\nReply-To: noreply@example.com\r\nX-Mailer: PHP/".phpversion();
                        if(mail($email, "Subjekat", "Neki tekst neke poruke", $headers)){
                            echo "Success";
                        }
                        else {
                            echo "Fail!";
                        }
                }
			if($_GET['type'] === 'view'){
				$user= $_GET['korisnickoIme'];
				$query = $db->prepare("select * from mydb.korisnik where korisnickoIme='$user'" );
				$query->execute();
				$result->error_status = false;
				$result->data = $query->fetchAll();
				if(count($result->data) == 0)
					$result->isEmpty = true;
				else{
					$result->isEmpty = false;

				}
		}
		if ($_GET['type'] === 'all'){
			$stmt = $db->prepare("select * from mydb.korisnik");
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$result->error_status=false;
			$result->data = $stmt->fetchAll();
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
        
        $mod = "korisnik";
        $datum=date("Y-d-m");
        $status="aktivan";
        
        $query = $db->prepare("INSERT INTO `mydb`.`korisnik` (`korisnickoIme`, `sifra`, `ime`,`prezime`,`email`,`institucija`,`dodatneInformacije`,`mod`,`datumRegistrovanja`,`status`) VALUES ('$username','$password', '$ime', '$prezime', '$email', '$institucija', '$info', '$mod', $datum, '$status' )");
	$query->execute();  
        $broj_redova = $query->rowCount();
	if($broj_redova==1) 
            $result->error_status = false;
	else 
            $result->error_status = true;
    }
	if($method === 'DELETE')
		{
			$result->message = "Primljen zahtev za brisanje";
			if(isset($_GET['korisnickoIme'])){
            $ime = $_GET['korisnickoIme']; 
			$query = $db->prepare("delete from mydb.korisnik where korisnickoIme=$ime" );
			$query->execute();
			$broj_redova = $query->rowCount();
			if($broj_redova!=0)
			{
				$result->error_status = false;
				$result->poruka="Objekat je obrisan iz baze.";
			}
			else $result->error_status = true;
	
		}
    }
	if($method === 'PUT')
    {
		$result->message = "Primljen zahtev za promenu objekta";
		$data=json_decode(file_get_contents('php://input'));
		$result->ulazniPodaci = $data;
		if(property_exists($data, "korisnickoIme"))
            $korisnickoIme = $data->korisnickoIme;
		if(property_exists($data, "ime"))
            $ime = $data->ime;
		if(property_exists($data, "prezime"))
            $prezime = $data->prezime;
		if(property_exists($data, "email"))
            $email= $data->email;
		if(property_exists($data, "institucija"))
            $institucija = $data->institucija;
		if(property_exists($data, "mod"))
            $mod = $data->mod;
		if(property_exists($data, "stat"))
            $stat= $data->stat;
		
		$query = $db->prepare("update mydb.korisnik set ime='$ime', prezime='$prezime', email='$email', institucija='$institucija',mod='$mod', status='$stat' WHERE korisnickoIme='$korisnickoIme'");
		$query->execute();
		$br = $query->rowCount();
		if($br==1) $result->error_status = false;
		else $result->error_status = true;
    }
}
catch(Exception $e)
{
    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>