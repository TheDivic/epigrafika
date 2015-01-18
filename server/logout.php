<?php
session_start();
$_SESSION['privilegije']=null;
$_SESSION['status']=null;
$_SESSION['korisnickoIme']=null;
header('Location: ../client/pocetna.php');

?>