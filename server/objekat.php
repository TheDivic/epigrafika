<?php
include 'konekcija.php';
include 'dodavanje.php';

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
        }
        else if($_GET['type'] === 'radiusSearch')
        {	
            //Pretraga preko mape
            
            $epsilon = 1e-4;
            $latMin = floatval($_GET['latMin']);
            $latMax = floatval($_GET['latMax']);
            $lngMin = floatval($_GET['lngMin']);
            $lngMax = floatval($_GET['lngMax']); 

            //Trazimo samo objekte cije tacke poligona
            //upadaju u opseg prosledjen GET parametrom
            $query = $db->prepare(  "select * from objekat o 
                                    join modernomesto m on o.modernoMesto = m.id 
                                    join geomesto g on g.mesto = m.id 
                                    join poligon p on g.poligon = p.id
                                    join tackepoligona tp on tp.poligon = p.id
                                    join tacka t on tp.koordinata = t.id
                                    where t.latituda between ? and ?
                                    and t.longituda between ? and ?
                                    group by o.id");
                                    
            $query->bindParam(1, $latMin-$epsilon, PDO::PARAM_STR);
            $query->bindParam(2, $latMax+$epsilon, PDO::PARAM_STR);
            $query->bindParam(3, $lngMin-$epsilon, PDO::PARAM_STR);
            $query->bindParam(4, $lngMax+$epsilon, PDO::PARAM_STR);

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
        $result = unesi($data, $db);

    }
    else if ($method === 'UPDATE')
    {
        //Azuriranje
        //Admin only?
    }
    else if ($method === 'DELETE')
    {
        //Brisanje
        //Admin only?
    }
}
catch(Exception $e)
{
    $result->error_status=true;
    $result->error_message = $e->getMessage();
}

echo json_encode($result);
?>