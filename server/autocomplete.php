<?php

/* Funkcija koja prima string( rec ili deo reci) i vraca top 5 reci iz recnika koje pocinju sa tim stringom, 
npr ako je input ST funkcija vraca STo, STolica, STanje, STepen,... */

function trazi_deo_reci($string)
{
if(!is_string($string)){
error_log(__FUNCTION__.' expects first argument to be string; '.gettype($string).' received.');
/* echo __FUNCTION__.' expects first argument to be string; '.gettype($string).' received.'; */
}
else{
$servername = "localhost";
$username = "root";
$password = "";
$db = "mydb";

$conn = new mysqli($servername, $username, $password, $db);

if($conn->connect_error)
{
die("Connection failed: " . $conn->connect_error);
}





$sql = "SELECT rec FROM recnik WHERE rec LIKE '" . $string . "%' ORDER BY brojPonavljanja DESC LIMIT 5;";
/*echo $sql;*/
$result = $conn->query($sql);
$niska = array();
if($result->num_rows>0)
{
while($row = $result->fetch_assoc())
array_push($niska, $row["rec"]);
}

print_r($niska);

$result->close();
$conn->close();

return $niska;


}
}
/* Funkcija prima listu reci, i za svaku rec radi:
-ukoliko rec ne postoji u tabeli, dodaje je u tabelu i postavlja broj pojavljivanja na 1 
-ukoliko rec postoji, inkrementira broj pojavljanja te reci */

function unesi_rec($array){
if(!is_array($array)){
error_log(__FUNCTION__.' expects first argument to be array; '.gettype($array).' received.');
/* echo __FUNCTION__.' expects first argument to be array; '.gettype($array).' received.'; */
}
else{
$servername = "localhost";
$username = "root";
$password = "";
$db = "mydb";

$conn = new mysqli($servername, $username, $password, $db);

if($conn->connect_error)
{
die("Connection failed: " . $conn->connect_error);
}

foreach($array as $key)
{
$sql = "SELECT rec, brojPonavljanja FROM recnik WHERE rec LIKE '" . $key . "';";
/*echo $sql;*/
$result = $conn->query($sql);
if($result->num_rows > 0)
{
$row = $result->fetch_assoc();
/*echo "rec: " . $row["rec"] . ", brojPonavljanja: " . $row["brojPonavljanja"] . "<br>";*/
$sql_update = "UPDATE recnik SET brojPonavljanja = brojPonavljanja + 1 WHERE rec LIKE '" . $key ."';";

$conn->query($sql_update);
}
else if($result->num_rows == 0)
{
$sql_insert = "INSERT INTO recnik VALUES('" . $key . "', 1);";
$conn->query($sql_insert);
}
$result->close();
}


$conn->close();
}

}

?>

