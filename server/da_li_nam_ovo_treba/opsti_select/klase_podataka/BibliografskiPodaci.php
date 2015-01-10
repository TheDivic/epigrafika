<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 12/17/2014
 * Time: 5:58 PM
 */

class BibliografskiPodaci {

    private $ime;
    private $skracenica;
    private $pdf_dokument;

    public function __construct($ime, $skracenica, $pdf_dokument){
        $this->ime = $ime;
        $this->skracenica = $skracenica;
        $this->pdf_dokument = $pdf_dokument;

    }

    /**
     * @return mixed
     */
    public function getIme()
    {
        return $this->ime;
    }

    /**
     * @return mixed
     */
    public function getPdfDokument()
    {
        return $this->pdf_dokument;
    }

    /**
     * @return mixed
     */
    public function getSkracenica()
    {
        return $this->skracenica;
    }




}

?>