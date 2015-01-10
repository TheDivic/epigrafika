<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 12/17/2014
 * Time: 5:31 PM
 */

//treba ispraviti gettere u odnosu na c da se ne bi pristupalo nepostojecim podacima
//treba videti za racunanje vekova


class Vreme {
    private $c;
//0-nedatovan natpis,
//1- tekstualno polje za unos konkretne godine cijim se unosom automatski preracunava
//odgovarajuci vek i informacija da li je u pitanju prva ili druga polovina veka
//2- tekstulano polje ze unos veka i serija radio dugmadi za izbor prve ili druge polovine veka
//ciji je izbor opcion
//3- dva tekstualna polja za unos godine pocetka i godine kraja perioda – i u ovom slucaju
//automatski treba preracunati odgovarajuce vekove i informacije o prvoj ili drugoj polovini
//veka ( 50ta godina pripada drugoj polovini)

    private $nedatovan_natpis;
    private $godina;
    private $vek;
    private $polovina_veka;
    private $godina_pocetka;
    private $godina_kraja;

    public function __construct($c, $arg1, $arg2){
        $this->c = $c;
        if($c==0){
            $this->nedatovan_natpis = $arg1;
        }
        else if($c==1){
            $this->godina = $arg1;

        }
        else if($c==2){
            $this->vek = $arg1;
            $this->polovina_veka = $arg2;
        }

        else if($c==3){
            $this->godina_pocetka = $arg1;
            $this->godina_kraja = $arg2;
        }
    }

    /**
     * @return mixed
     */
    public function getC()
    {
        return $this->c;
    }

    /**
     * @return mixed
     */
    public function getGodina()
    {
        return $this->godina;
    }

    /**
     * @return mixed
     */
    public function getGodinaKraja()
    {
        return $this->godina_kraja;
    }

    /**
     * @return mixed
     */
    public function getGodinaPocetka()
    {
        return $this->godina_pocetka;
    }

    /**
     * @return mixed
     */
    public function getNedatovanNatpis()
    {
        return $this->nedatovan_natpis;
    }

    /**
     * @return mixed
     */
    public function getPolovinaVeka()
    {
        return $this->polovina_veka;
    }

    /**
     * @return mixed
     */
    public function getVek()
    {
        return $this->vek;
    }





}

?>