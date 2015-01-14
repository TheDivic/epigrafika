<?php
/* Funkcija prima listu reci, i za svaku rec radi:
-ukoliko rec ne postoji u tabeli, dodaje je u tabelu i postavlja broj pojavljivanja na 1 
-ukoliko rec postoji, inkrementira broj pojavljanja te reci */
function insertWordsIntoDictionary($array){
    if(!is_array($array)){
        error_log(__FUNCTION__.' expects first argument to be array; '.gettype($array).' received.');
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

function populateDictionary($inscription) {
    $tok = strtok($inscription, " \n");

    while($tok !== false){
        $words[] = $tok;
        $tok = strtok(" \n.!?,");
    }

    insertWordsIntoDictionary($words);
}
?>