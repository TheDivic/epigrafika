<?php
include 'konekcija.php';
include 'dodavanje.php';
include 'azuriranje.php';
include 'obrisi.php';
include 'selektovanje.php';


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
            $data1 = $_GET['podaci'];

            $data1 = json_decode($data1);
            $data = new stdClass();
            foreach($data1 as $key => $value)
            {
                if($value != null || $value ===0)
                {
                    if(is_string($value))
                        $value = trim($value);

                    if($key == 'natpisArg' && $value == 'andNot')
                    {
                        $data->$key = 'AND NOT';
                    }
                  /*  else
                        if($key == 'periodVeka' && $value == 'prvaPolovinaVeka')
                        {
                            $data->$key = 'prvaPolovina';
                        }
                    else
                        if($key == 'periodVeka' && $value == 'drugaPolovinaVeka')
                        {
                            $data->$key = 'drugaPolovina';
                        }*/
                    else
                    {
                      /*  if(is_string($value))
                            $data->$key = trim($value);
                        else*/
                            $data->$key = $value;
                    }

                }

            }
           // echo json_encode($data);
           // echo '        ';
            //$result->ulazni_podaci = $data;
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
        else if($_GET['type'] === 'byId')
        {
            $objectId = $_GET['objectId'];

            $sl = selektovanje::getSelektor();
			$result->error_status = false;
            $result->data = $sl->selektujeObjekat($objectId);
            /*
            $query = $db->prepare(  "select o.id, o.oznaka, o.tekstNatpisa, 
                                    vn.naziv as 'vrstaNatpisa', j.naziv as 'jezik', pr.naziv as 'provincija', g.naziv as 'grad', pl.naziv as 'pleme', 
                                    md.naziv as 'modernaDrzava', mm.naziv as 'modernoMesto', u.naziv as 'ustanova', 
                                    o.pocetakGodina, o.pocetakVek, o.pocetakOdrednica, o.krajGodina, o.krajVek, o.krajOdrednica, o.tip, 
                                    o.materijal, o.dimenzije, o.komentar, o.faza, o.datumKreiranja, o.datumPoslednjeIzmene, o.datovano, o.lokalizovano
                                    from objekat o join vrstanatpisa vn on o.vrstaNatpisa = vn.id
                                    join jezik j on o.jezik = j.id
                                    join provincija pr on o.provincija = pr.id
                                    join grad g on o.grad = g.id
                                    join mesto m on o.mesto = m.id
                                    join pleme pl on o.pleme = pl.id
                                    join modernadrzava md on o.modernaDrzava = md.id
                                    join modernoMesto mm on o.modernoMesto = mm.id
                                    join ustanova u on o.ustanova = u.id
                                    where o.id = $objectId");
            $query->execute();
            $result->error_status = false;
            $result->data = $query->fetchAll(PDO::FETCH_OBJ);*/
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
            $rezultat = unesi($data, $db);
            if($rezultat == true){
                $result->error_status = false;

            }
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
            $rezultat = azuriraj($data, $db);

            if($rezultat == true){
                $result->error_status = false;
            }

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