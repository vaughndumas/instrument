<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class BKMultiBook implements InputFilterAwareInterface {
    
    public $ibdbookno;
    public $ibdfeacode;
    public $ibdvalue;
    public $ibdcost;
    public $ibdused;
    public $ibdinsid;
    public $ibddatereq;
    public $v_glc;
    protected $availfeatures;
    protected $inputFilter;
    protected $_dbAdapter;

    public function exchangeArray($data) {
        $this->bookingno = (isset($data['ibdbookno'])) ? $data['ibdbookno'] : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibdbookno',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'PregReplace',
                        'options' => array(
                            'pattern' => '/\//',
                            'replacement' => '')
                        ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibdfeacode',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'PregReplace',
                        'options' => array(
                            'pattern' => '/\//',
                            'replacement' => '')
                        ),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 8,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibdvalue',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'ibdcost',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'ibdused',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
            )));

            // Display only
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibdinsid',
                'required' => false,
            )));

            // Display only
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibddatereq',
                'required' => false,
            )));

            // Display purposes only
            $inputFilter->add($factory->createInput(array(
                'name' => 'v_glc',
                'required' => false,
            )));

        $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
  
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }    
    
    
    public function getAvailfeatures() {
        return $this->availfeatures;
    }
    
    public function setAvailfeatures(array $availfeatures) {
        $this->availfeatures = $availfeatures;
        return $this;
    }
    
    public function getIbdbookno() {
        return $this->ibdbookno;
    }

    public function setIbdbookno($ibdbookno) {
        $this->ibdbookno = $ibdbookno;
    }

    public function getIbdinsid() {
        return $this->ibdinsid;
    }

    public function setIbdinsid($ibdinsid) {
        $this->ibdinsid = $ibdinsid;
    }

    public function getIbddatereq() {
        return $this->ibddatereq;
    }

    public function setIbddatereq($ibddatereq) {
        $this->ibddatereq = $ibddatereq;
    }
    public function getV_glc() {
        return $this->v_glc;
    }

    public function setV_glc($v_glc) {
        $this->v_glc = $v_glc;
    }

    public function getIbdfeacode() {
        return $this->ibdfeacode;
    }

    public function setIbdfeacode($ibdfeacode) {
        $this->ibdfeacode = $ibdfeacode;
    }

    public function getIbdvalue() {
        return $this->ibdvalue;
    }

    public function setIbdvalue($ibdvalue) {
        $this->ibdvalue = $ibdvalue;
    }

    public function getIbdcost() {
        return $this->ibdcost;
    }

    public function setIbdcost($ibdcost) {
        $this->ibdcost = $ibdcost;
    }

    public function getIbdused() {
        return $this->ibdused;
    }

    public function setIbdused($ibdused) {
        $this->ibdused = $ibdused;
    }


}

?>
