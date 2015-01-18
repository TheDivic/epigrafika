<?php
session_start();
$_SESSION['privilegije']=null;
$_SESSION['status']=null;
header('Location: ../client/pocetna.php');

?>