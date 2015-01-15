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

                $sifra=str_replace('"',"",$sifra);

                $sifraCrypt=crypt($sifra, '$2a$10$dfgbdfgbt5y56gtbftrty6');

                $query = $db->prepare("select * from mydb.korisnik where korisnickoIme=$ime");
				$query->execute();
				$result->error_status = false;

                $data = $query->fetchAll();

                $result->data = $data;

                if(count($data) == 0)
                    $result->isEmpty = true;

				else{
                    if($sifraCrypt===$data[0]['sifra'])
					   $result->isEmpty = false;
                    else {
                        $result->data = null;
                        $result->isEmpty = true;
                    }
		}
            }
        if($_GET['type'] === 'zaboravljenaSifra'){
            //TO DO - SLANJE MAILA na email korisnika sa sifrom.
            $ime = $_GET['user'];

            $query = $db->prepare("select * from mydb.korisnik where korisnickoIme=$ime" );
            $query->execute();
            $result->error_status = false;
            $data = $query->fetch(PDO::FETCH_OBJ);

            if($data == NULL){
                $result->message = "Ne postoji korisnicko ime.";
            }
            else {

                $email = $data->email;

                $headers = "From: noreply@epigrafika.com\r\nReply-To: noreply@epigrafika.com\r\nX-Mailer: PHP/" . phpversion();
                $subject="Nova lozinka";
                $password=rand_passwd();
                $message="Postovani, \n vasa nova lozinka je: ".$password."\n";

                if(mail($email, $subject, $message, $headers))
                    $result->message = "Poslat mejl na adresu.";
                else
                    $result->message = "Greska pri slanju mejla";

                $ime1=$data->korisnickoIme;

                $passwordCrypt=crypt($password, '$2a$10$dfgbdfgbt5y56gtbftrty6');

                $q = $db->prepare("UPDATE `mydb`.`korisnik` SET `sifra` = ? WHERE `korisnik`.`korisnickoIme` = ? ");
                $q->execute(array($passwordCrypt, $ime1));


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
		if ($_GET['type'] === 'chart'){
			$stmt = $db->prepare("select count(*) as novi, datumRegistrovanja, '#0D52D1' as boja from mydb.korisnik group by datumRegistrovanja,boja");
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$result->error_status=false;
			$result->data = $stmt->fetchAll();
			$result->num=count($result->data);
			}
	
}
else if($method === 'POST')
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
		if(property_exists($data, "status"))
            $status = $data->status;
		if(property_exists($data, "privilegije"))
            $privilegije = $data->privilegije;
        $datum=date("Y-d-m");


        $passwordCrypt=crypt($password,'$2a$10$dfgbdfgbt5y56gtbftrty6');


        $query = $db->prepare("INSERT INTO `mydb`.`korisnik` (`korisnickoIme`, `sifra`, `ime`,`prezime`,`email`,`institucija`,`dodatneInformacije`,`privilegije`,`datumRegistrovanja`,`status`) VALUES ('$username','$passwordCrypt', '$ime', '$prezime', '$email', '$institucija', '$info', '$privilegije', $datum, '$status' )");
		$query->execute();  
        $broj_redova = $query->rowCount();
		if($broj_redova==1) 
                    $result->error_status = false;
		else 
                    $result->error_status = true;
		}
    else if($method === 'DELETE')
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
else if($method === 'PUT')
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
		if(property_exists($data, "privilegije"))
                    $privilegije = $data->privilegije;
		if(property_exists($data, "stat"))
                    $stat= $data->stat;
		$query = $db->prepare("UPDATE mydb.korisnik SET privilegije = '$privilegije', status = '$stat', ime='$ime', prezime='$prezime', email='$email',institucija='$institucija'  WHERE korisnickoIme = 'Mirko'");
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

function rand_passwd() {
    $length = rand(8,12);
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_0123456789';
    return substr( str_shuffle( $chars ), 0, $length );
}

echo json_encode($result);
?>