<?php
include 'konekcija.php';

// Prihvata JSON koji sadrzi rec
// vraca JSON sa ponudjenim recima za autocomplete
function autocompleteInscription()
{
    $json = file_get_contents('php://input',true);
    $string =  json_decode($json);
    $niska = current($string);

    $query_result = searchDictionary($niska);

    if($query_result != null)
    {
        foreach(array_values($query_result) as $temp){
            $out['words'][] = $temp['rec'];
        }
        $result = json_encode($out);
        return $result;
    }
    else {
        return json_encode([]);
    }
}

/* Funkcija koja prima string( rec ili deo reci) i vraca top 5 reci iz recnika koje pocinju sa tim stringom, 
npr ako je input ST funkcija vraca STo, STolica, STanje, STepen,... */
function searchDictionary($string)
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

/* Funkcija prima listu reci, i za svaku rec radi:
-ukoliko rec ne postoji u tabeli, dodaje je u tabelu i postavlja broj pojavljivanja na 1 
-ukoliko rec postoji, inkrementira broj pojavljanja te reci */
function insertWordsIntoDictionary($array){
    if(!is_array($array)){
        error_log(__FUNCTION__.' expects first argument to be array; '.gettype($array).' received.');
        /* echo __FUNCTION__.' expects first argument to be array; '.gettype($array).' received.'; */
    }
    else{

        try{
            $result = new stdClass();
            $db=konekcija::getConnectionInstance();

            foreach($array as $key)
            {
                $query = "SELECT rec, brojPonavljanja FROM recnik WHERE rec LIKE '" . $key . "';";
                $stmt = $db->prepare($query);
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);
                $result->error_status=false;
                $result->data = $stmt->fetchAll();

                if($result->data)
                {
                    $sql_update = "UPDATE recnik SET brojPonavljanja = brojPonavljanja + 1 WHERE rec LIKE '" . $key ."';";
                    $stmt = $db->prepare($sql_update);
                    $stmt->execute();
                }
                else
                {
                    $sql_insert = "INSERT INTO recnik VALUES('" . $key . "', 1);";
                    $stmt = $db->prepare($sql_insert);
                    $stmt->execute();
                }
            }
        }
        catch(Exception $e){
            $result->error_status=true;
            $result->error_message = $e->getMessage();
        }
    }
}
?>


<?php
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    echo autocompleteInscription();
}
?>

