<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class EFMulti implements InputFilterAwareInterface {
    public $ibbfeacode;  // Feature Code
    public $ibbstartval; // Default value
    public $ibbactive;   // Active
    protected $inputFilter;
    protected $_dbAdapter;
    
    public function exchangeArray($data) {
        $this->ibbfeacode  = (isset($data['ibbfeacode'])) ? $data['ibbfeacode']   : null;
        $this->ibbstartval = (isset($data['ibbstartval'])) ? $data['ibbstartval'] : null;
        $this->ibbactive   = (isset($data['ibbactive'])) ? $data['ibbactive']     : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibbfeacode',
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
//                    array(
//                        'name' => 'Db\RecordExists',
//                        'options' => array(
//                            'table' => 'ibafea',
//                            'field' => 'ibacode',
//                            'adapter' => $this->_dbAdapter,
//                        ),
//                    ),

                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibbstartval',
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
                            'max' => 8,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
              'name' => 'ibbactive',
              'required' => true,
              'options' => array(
                'label' => 'Active',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
              ),
            )));

        $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }
    
    public function setDbAdapter(Adapter $adapter) {
        $this->_dbAdapter = $adapter;
    }
    
    public function getDbAdapter() {
        return $this->_dbAdapter;
    }
    public function getIbbfeacode() {
        return $this->ibbfeacode;
    }

    public function setIbbfeacode($ibbfeacode) {
        $this->ibbfeacode = $ibbfeacode;
    }

    public function getIbbstartval() {
        return $this->ibbstartval;
    }

    public function setIbbstartval($ibbstartval) {
        $this->ibbstartval = $ibbstartval;
    }

    public function getIbbactive() {
        return $this->ibbactive;
    }

    public function setIbbactive($ibbactive) {
        $this->ibbactive = $ibbactive;
    }
        
}

?>
