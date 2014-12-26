<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 12/17/2014
 * Time: 5:54 PM
 */

class InformacijeOZnamenitosti {
    private $tip;
    private $materijal;
    private $sirina;
    private $duzina;
    private $visina;

    public function __construct($tip, $materijal, $sirina, $duzina, $visina){
        $this->tip = $tip;
        $this->materijal = $materijal;
        $this->sirina = $sirina;
        $this->duzina = $duzina;
        $this->visina = $visina;

    }

    /**
     * @return mixed
     */
    public function getDuzina()
    {
        return $this->duzina;
    }

    /**
     * @return mixed
     */
    public function getMaterijal()
    {
        return $this->materijal;
    }

    /**
     * @return mixed
     */
    public function getSirina()
    {
        return $this->sirina;
    }

    /**
     * @return mixed
     */
    public function getTip()
    {
        return $this->tip;
    }

    /**
     * @return mixed
     */
    public function getVisina()
    {
        return $this->visina;
    }



}

?>