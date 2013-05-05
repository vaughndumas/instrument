<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Feature implements InputFilterAwareInterface {
    public $ibacode;
    public $ibadesc;
    public $ibastartval;
    public $ibacost;
    public $ibafeatime;
    public $ibaactive;
    protected $inputFilter;
    
    public function exchangeArray($data) {
        $this->ibacode     = (isset($data['ibacode'])) ? $data['ibacode']         : null;
        $this->ibadesc     = (isset($data['ibadesc'])) ? $data['ibadesc']         : null;
        $this->ibastartval = (isset($data['ibastartval'])) ? $data['ibastartval'] : null;
        $this->ibacost     = (isset($data['ibacost'])) ? $data['ibacost']         : null;
        $this->ibafeatime  = (isset($data['ibafeatime'])) ? $data['ibafeatime']   : null;
        $this->ibaactive   = (isset($data['ibaactive'])) ? $data['ibaactive']     : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibacode',
                'required' => true,
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
                'name' => 'ibadesc',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 64,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibastartval',
                'required' => false,
                'filters' => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'ibacost',
                'required' => false,
                'filters' => array(
                    array('name' => 'StringTrim'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'ibafeatime',
                'required' => false,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name' => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min' => 1,
                            'max' => 11,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'ibaactive',
                'required' => true,
                )
            ));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }
    public function getIbacode() {
        return $this->ibacode;
    }

    public function setIbacode($ibacode) {
        $this->ibacode = $ibacode;
    }

    public function getIbadesc() {
        return $this->ibadesc;
    }

    public function setIbadesc($ibadesc) {
        $this->ibadesc = $ibadesc;
    }

    public function getIbacost() {
        return $this->ibacost;
    }

    public function setIbacost($ibacost) {
        $this->ibacost = $ibacost;
    }

    public function getIbaactive() {
        return $this->ibaactive;
    }

    public function setIbaactive($ibaactive) {
        $this->ibaactive = $ibaactive;
    }


}

?>
