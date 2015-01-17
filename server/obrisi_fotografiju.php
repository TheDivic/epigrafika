<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/17/2015
 * Time: 3:35 PM
 */
include 'konekcija.php';

function obrisi($id, $db)
{
    $query = "SELECT count(*) FROM `fotografija`
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $o = $stmt->fetchAll();

    if ($o[0][0] == 0)
        return false;

    $query = "SELECT putanja FROM `fotografija`
        WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $o = $stmt->fetchAll();
    $putanja = $o[0][0];

    $rez = unlink($putanja);
    if ($rez == false)
        return false;

    try {
        $db->beginTransaction();
        $query = "DELETE FROM `fotografija`
        WHERE id = :id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $db->commit();

    }catch (Exception $e){
        return false;
    }
    return true;


}

    $result = new stdClass();
try {

    $db = konekcija::getConnectionInstance();

    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'DELETE') {

        $number_of_url_elements=0;

        if(isset($_SERVER['PATH_INFO'])){
            $url_elements=explode("/", $_SERVER['PATH_INFO']);
            $number_of_url_elements=count($url_elements)-1;
        }

        if($number_of_url_elements ==1) {

            $id = intval($url_elements[1]);
            try {
                $rezultat = brisi($id, $db);
                if($rezultat==true)
                    $result->error_status=false;
                else{
                    $result->error_status=true;
                    $result->error_message = $e->getMessage();
                }



            } catch (Exception $e) {
                $result->error_status=true;
                $result->error_message = $e->getMessage();
            }

        }
        else{
            $result->error_status=true;
            $result->error_message = 'Bad request!';

        }



    }

}catch(Exception $e){

    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
