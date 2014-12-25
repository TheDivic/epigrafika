<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 12/17/2014
 * Time: 5:29 PM
 */

class IzvornoMestoNalaska {
    private $provincija;
    private $grad;
    private $mesto;

    public function __construct($provincija, $grad, $mesto){
        $this->provincija=$provincija;
        $this->grad=$grad;
        $this->mesto=$mesto;
    }

    /**
     * @return mixed
     */
    public function getGrad()
    {
        return $this->grad;
    }

    /**
     * @return mixed
     */
    public function getMesto()
    {
        return $this->mesto;
    }

    /**
     * @return mixed
     */
    public function getProvincija()
    {
        return $this->provincija;
    }


}

?>