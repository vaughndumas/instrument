<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class BookFeat implements InputFilterAwareInterface {
    
    public $ibdbookno;
    public $ibdfeacode;
    public $ibdvalue;
    public $ibdcost;
    public $ibdused;
    protected $inputFilter;
    protected $dbAdapter;
    
    public function exchangeArray($data) {
        $this->ibdbookno  = (isset($data['ibdbookno']))  ? $data['ibdbookno']  : null;
        $this->ibdfeacode = (isset($data['ibdfeacode'])) ? $data['ibdfeacode'] : null;
        $this->ibdvalue   = (isset($data['ibdvalue']))   ? $data['ibdvalue']   : null;
        $this->ibdcost    = (isset($data['ibdcost']))    ? $data['ibdcost']    : null;
        $this->ibdused    = (isset($data['ibdused']))    ? $data['ibdused']    : null;
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

        $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
  
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }
    
    public function getIbdbookno() {
        return $this->ibdbookno;
    }

    public function setIbdbookno($ibdbookno) {
        $this->ibdbookno = $ibdbookno;
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

    public function getDbAdapter() {
        return $this->dbAdapter;
    }

    public function setDbAdapter($dbAdapter) {
        $this->dbAdapter = $dbAdapter;
    }


}

?>
