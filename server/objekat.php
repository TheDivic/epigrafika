<?php
include 'konekcija.php';
include 'dodavanje.php';
include 'azuriranje.php';
<<<<<<< HEAD
include 'obrisi.php';
=======
include 'selektovanje.php';
>>>>>>> origin/master

$result = new stdClass();
try
{
    $db=konekcija::getConnectionInstance();

    $method = $_SERVER['REQUEST_METHOD'];

    if($method === 'GET')
    {
        //Dostava podataka

        if($_GET['type'] === 'search')
        {
            //Standardna pretraga po nekim kljucnim recima
            $sl = selektovanje::getSelektor();
            $data = $_GET['podaci'];
            $result->ulazni_podaci = $data;
            $result->data = $sl->selektuj($data);
            

        }
        else if($_GET['type'] === 'byLocation')
        {
            $locationId = $_GET['locationId'];

            $query = $db->prepare( "select o.id,o.oznaka,o.tekstNatpisa
                                    from objekat o
                                    join modernomesto m on o.modernoMesto = m.id
                                    where m.id = $locationId");

            $query->execute();

            $result->error_status = false;
            $result->data = $query->fetchAll(PDO::FETCH_OBJ);
        }
        else if($_GET['type'] === 'jedinstena_oznaka')
        {
            $oznaka = $_GET['oznaka'];
            $query = $db->prepare("select * from mydb.objekat where oznaka=$oznaka" );
            $query->execute();

            $result->error_status = false;
            $result->data = $query->fetchAll();
            if(count($result->data) == 0)
                $result->isEmpty = true;
            else
                $result->isEmpty = false;
        }
    }
    else if ($method === 'POST')
    {
        //Upis novih podataka
        //Admin only?
        $data = file_get_contents('php://input');
        try {
            $result = unesi($data, $db);
        }catch (Exception $e){
            $result->error_status=true;
            $result->error_message = $e->getMessage();
        }

    }
    else if ($method === 'PUT')
    {
        //Azuriranje
        //Admin only?
        $data = file_get_contents('php://input');
        try {
            $result = azuriraj($data, $db);
        }catch (Exception $e){
            $result->error_status=true;
            $result->error_message = $e->getMessage();
        }

    }
    else if ($method === 'DELETE')
    {
        //Brisanje
        //Admin only?

        // proveriti da li se ovako uzima id iz url-a...
        $number_of_url_elements=0;

        if(isset($_SERVER['PATH_INFO'])){
            $url_elements=explode("/", $_SERVER['PATH_INFO']);
            $number_of_url_elements=count($url_elements)-1;
        }

        if($number_of_url_elements ==1) {

            $id = intval($url_elements[1]);
            try {
                $result = obrisi($id, $db);
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
}
catch(Exception $e)
{
    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>