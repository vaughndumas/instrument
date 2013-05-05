<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Adapter\Adapter;

class Equiptype implements InputFilterAwareInterface {
    public $iaccode;
    public $iacdesc;
    public $iacactive;
    protected $inputFilter;
    
    public function exchangeArray($data) {
        $this->iaccode   = (isset($data['iaccode'])) ? $data['iaccode']     : null;
        $this->iacdesc   = (isset($data['iacdesc'])) ? $data['iacdesc']     : null;
        $this->iacactive = (isset($data['iacactive'])) ? $data['iacactive'] : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'iaccode',
                'required' => true,
                'filters' => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                    array('name' => 'StringToUpper'),
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
                'name' => 'iacdesc',
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
                'name' => 'iacactive',
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
                            'max' => 1,
                        ),
                    ),
                ),

                )
            ));
            
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }
    
//    public function getValidCodes($form, $context = null) {
//        
//        $v_select = "SELECT iaccode as ValidCode, iacdesc AS ValidDesc FROM iaceqt WHERE iacactive = 'Y'";
//        $v_statement = $this->
//        $v_result = $v_statement->execute();
//        
//        $v_return = array();
//        foreach ($v_result as $key=>$value) {
//          $v_return[] = array('value' => $key, 'label' => $value);
//        }
//        return $v_return;
//    }
}

?>
