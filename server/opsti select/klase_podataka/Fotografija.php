<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 12/17/2014
 * Time: 6:01 PM
 */

class Fotografija {

    private $fotografija;
    private $naziv;

    public function __construct($fotografija, $naziv){
        $this->fotografija = $fotografija;
        $this->naziv = $naziv;

    }

    /**
     * @return mixed
     */
    public function getFotografija()
    {
        return $this->fotografija;
    }

    /**
     * @return mixed
     */
    public function getNaziv()
    {
        return $this->naziv;
    }


}

?>