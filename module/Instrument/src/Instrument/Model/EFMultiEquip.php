<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;

class EFMultiEquip implements InputFilterAwareInterface {
    public $iadid;
    public $featureset;
    public $availfeatures;  // Available features
    protected $inputFilter;
    protected $_dbAdapter;
    
    public function exchangeArray($data) {
        $this->equipment = (isset($data['iadid'])) ? $data['iadid'] : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    
    public function getInputFilter(){
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'iadid',
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
            
        $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }

    public function getIadid() {
        return $this->iadid;
    }

    public function setIadid($iadid) {
        $this->iadid = $iadid;
        return $this;
    }

    public function getFeatureset() {
        return $this->featureset;
    }

    public function setFeatureset(array $featureset) {
        $this->featureset = $featureset;
        return $this;
    }
    
    public function getAvailfeatures() {
        return $this->availfeatures;
    }
    
    public function setAvailfeatures(array $availfeatures) {
        $this->availfeatures = $availfeatures;
        return $this;
    }

    public function setDbAdapter(Adapter $adapter) {
        $this->_dbAdapter = $adapter;
    }
    
    public function getDbAdapter() {
        return $this->_dbAdapter;
    }
}

