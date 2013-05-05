<?php
namespace Instrument\Model;

class AvailFeatures {
    public $ibacode;
    public $ibadesc;
    public $ibastartval;
    public $ibacost;
    public $ibafeatime;
    
    public function getIbacode() {
        return $this->ibacode;
    }

    public function setIbacode($ibacode) {
        $this->ibacode = $ibacode;
        return $this;
    }

    public function getIbadesc() {
        return $this->ibadesc;
    }

    public function setIbadesc($ibadesc) {
        $this->ibadesc = $ibadesc;
        return $this;
    }

    public function getIbastartval() {
        return $this->ibastartval;
    }

    public function setIbastartval($ibastartval) {
        $this->ibastartval = $ibastartval;
        return $this;
    }

    public function getIbacost() {
        return $this->ibacost;
    }

    public function setIbacost($ibacost) {
        $this->ibacost = $ibacost;
        return $this;
    }


}

?>
