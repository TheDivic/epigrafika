<?php
include 'konekcija.php';

// Autocomplete za natpise u bazi
function autocompleteInscription($string)
{
    if(!is_string($string)){
        error_log(__FUNCTION__.' expects first argument to be string; '.gettype($string).' received.');
    }
    else{
        $result = new stdClass();
        try{
            $db=konekcija::getConnectionInstance();
            $query= "SELECT rec FROM recnik WHERE rec LIKE '" . $string . "%' ORDER BY brojPonavljanja DESC LIMIT 5;";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $result->error_status=false;
            $result->data = $stmt->fetchAll();

            return $result->data;
        }
        catch(Exception $e){
            $result->error_status=true;
            $result->error_message = $e->getMessage();
        }
    }
}

// Autocomplete za anticke gradove u bazi
function autocompleteCity($key){
    $result = new stdClass();
    try{
        $db=konekcija::getConnectionInstance();
        $query= "SELECT naziv FROM grad WHERE naziv LIKE '" . $key . "%' LIMIT 5;";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result->error_status=false;
        $result->data = $stmt->fetchAll();

        return $result->data;
    }
    catch(Exception $e){
        $result->error_status=true;
        $result->error_message = $e->getMessage();
    }
}

function autocompletePlace($key){
    $result = new stdClass();
    try{
        $db=konekcija::getConnectionInstance();
        $query= "SELECT naziv FROM mesto WHERE naziv LIKE '" . $key . "%' LIMIT 5;";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result->error_status=false;
        $result->data = $stmt->fetchAll();

        return $result->data;
    }
    catch(Exception $e){
        $result->error_status=true;
        $result->error_message = $e->getMessage();
    }
}

function autocompleteBiblio($key){
    $result = new stdClass();
    try{
        $db=konekcija::getConnectionInstance();
        $query= "SELECT skracenica,naslov FROM BibliografskiPodatak WHERE skracenica LIKE '" . $key . "%' LIMIT 5;";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $result->error_status=false;
        $result->data = $stmt->fetchAll();

        return $result->data;
    }
    catch(Exception $e){
        $result->error_status=true;
        $result->error_message = $e->getMessage();
    }
}

?>

<?php
// API
$result = [];
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    if(isset($_GET['type']) && isset($_GET['key'])) {
        if($_GET['type'] === "inscription"){
            $query_result = autocompleteInscription($_GET['key']);
            if($query_result != null)
            {
                foreach(array_values($query_result) as $temp){
                    $result['words'][] = $temp['rec'];
                }
            }
        }
        elseif($_GET['type'] === 'city'){
            $query_result = autocompleteCity($_GET['key']);
            if($query_result != null)
            {
                foreach(array_values($query_result) as $temp){
                    $result['words'][] = $temp['naziv'];
                }
            }
        }
        elseif($_GET['type'] === 'place'){
            $query_result = autocompletePlace($_GET['key']);
            if($query_result != null)
            {
                foreach(array_values($query_result) as $temp){
                    $result['words'][] = $temp['naziv'];
                }
            }
        }
        elseif($_GET['type'] === 'biblio'){
            $query_result = autocompleteBiblio($_GET['key']);
            if($query_result != null)
            {
                foreach(array_values($query_result) as $temp){
                    $result['words'][] = $temp['skracenica'];
                    $result['fullbiblio'][] = $temp['naslov'];
                }
            }
        }
    }
}
echo json_encode($result);
?>

