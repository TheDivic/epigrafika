<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 1/18/2015
 * Time: 10:50 AM
 */
$oznaka = "hello12ewqewqeeqeweweqweqw";
if(strlen($oznaka)>=15 || ctype_alnum($oznaka)==false)
       echo "ne prolazi oznaka, ";
$natpis = "hello'(sadas) , .sad";
if (!preg_match("#^[a-zA-Z0-9 \.\(\)\'\,\.]+$#", $natpis))
    echo "ne prolazi natpis, ";

$mestoNalaska = trim(null);
if(preg_match("#^[a-zA-Z ]*$#", $mestoNalaska));
    echo "mesto  prolazi, ";


$nesto = trim(null);
echo $nesto;

$duzina = trim(null);
if(is_numeric($duzina))
    echo "JEEEEEEEEEEJ";