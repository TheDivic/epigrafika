<?php
include 'konekcija.php';

if(sizeof($argv) !== 2){
    echo "ERROR Usage: >php makeadmin.php username\n";
    die();
}

$conn = Konekcija::getConnectionInstance();

$query = $conn->prepare("UPDATE korisnik SET privilegije='admin' WHERE korisnickoIme='".$argv[1]."'");
$query->execute();

?>