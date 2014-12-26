<?php

$result = new stdClass();
try{

    $db=new PDO('mysql:dbname=mydb; host=localhost', 'root', '',
        array(PDO::ATTR_PERSISTENT=>true, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));


    $query="select * from mydb.grad";

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
