<?php
require_once('db.php');

$supported_methods=array('get','post', 'put', 'delete');

//ocitavamo vrstu zahteva
$method=strtolower($_SERVER['REQUEST_METHOD']);

if(!in_array($method, $supported_methods)){


    //vratiti odgovor
    header("HTTP/1.1 400 Bad request");
    exit();
}

//ocitavamo podatke iz putanje

//neophodno zbog slucaja kada putanja nije dobra...
$number_of_url_elements=0;

/*
if(isset($_SERVER['PATH_INFO'])){
    $url_elements=explode("/", $_SERVER['PATH_INFO']);
    $number_of_url_elements=count($url_elements)-1;
}*/



/* status odgovora i podaci - u JSON formatu ako ih ima */
$status=0;
$status_text="";
$error_description="";

$data="";



/* finije prilagodjavanje odgovora je moguce analizom HTTP_ACCEPT polja
    //$accept=isset($_SERVER['HTTP_ACCEPT'])? $_SERVER['HTTP_ACCEPT']: 'application/json';

  i podrskom funkcija koje podatke prebacuju u naznaceni format

 */


try{
    $db=new DB();

    echo "bla bla";

    switch($method){
        case 'get':
            $data=json_decode(file_get_contents('php://input'));
            $response = $db->selektuj($data);
            $response=json_encode($response);
            $status = 200;
            $status_text="ok";
            break;
/*
                    $status=400;
                    $status_text="Bad request!";
  */


        case 'post':


                //citamo podatke
//                $data=json_decode(file_get_contents('php://input'));
               $data = file_get_contents('php://input');
                $response=$db->unesi($data);

//               echo $id;
/*            if($id!=-1){
                    $status=201;
                    $status_text = "Artefakt uspesno dodat";
                }
                else{
                    $status=400;

                    $status_text="Artefakt nije dodat!";
                } */

            break;
/*
        case 'put':
            if($number_of_url_elements==1 and $url_elements[1]=='books'){
                //citamo podatke
                $book_data=json_decode(file_get_contents('php://input'));
                if($db->update($book_data->id, $book_data->title, $book_data->price)){
                    $status=200;
                    $status_text="ok";
                }
                else{
                    $status=400;

                    $status_text="Bad request!";
                }
            }
            break;

        case 'delete':
            if($number_of_url_elements==2 and $url_elements[1]=='books'){
                $id=intval($url_elements[2]);
                if($db->delete($id)){
                    $status=200;
                }
                else{
                    $status=404;

                    $status_text="Book id not found!";
                }

            }
            break;
*/
    }


}catch(Exception $e){
    $status="500";

    $status_text="Server error!" . $e->getMessage() . " ";
    echo $status . " " . $status_text;

}





header("HTTP/1.1 ".$status." ".$status_text);
header("Content-Type: application/json");
header("Connection: close");
if(isset($response))
    echo $response;






/*
primer sa klasama:
$response=new HTTPResponse();
$response::status($status);
$response::setContentType("application/json");
$response::setHeader("Connection: close");
if(isset($data))
    $response::setData($data);

$response::send();
*/


?>
