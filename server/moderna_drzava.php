<?php
include 'konekcija.php';

$result = new stdClass();
try{

    $db=konekcija::getConnectionInstance();

    $query="select * from mydb.modernadrzava";

    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    $result->error_status=false;
    $result->data = $stmt->fetchAll();


}
catch(Exception $e){

    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>
