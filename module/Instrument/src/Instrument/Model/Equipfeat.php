<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;

use Instrument\Model\Feature;
use Instrument\Model\Equipfeat;

class Equipfeat implements InputFilterAwareInterface {
    public $ibbfeacode;  // Feature Code
    public $ibbinsid;    // Equipment ID
    public $ibbstartval; // Default value
    public $ibbactive;   // Active
    public $features;    // Feature set for this equipment
    protected $inputFilter;
    protected $_dbAdapter;
    
    public function exchangeArray($data) {
        $this->ibbfeacode  = (isset($data['ibbfeacode'])) ? $data['ibbfeacode']   : null;
        $this->ibbinsid    = (isset($data['ibbinsid'])) ? $data['ibbinsid']       : null;
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
                    array(
                        'name' => 'Db\RecordExists',
                        'options' => array(
                            'table' => 'ibafea',
                            'field' => 'ibacode',
                            'adapter' => $this->_dbAdapter,
                        ),
                    ),

                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibbinsid',
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
                    array(
                        'name' => 'Db\RecordExists',
                        'options' => array(
                            'table' => 'iadins',
                            'field' => 'iadid',
                            'adapter' => $this->_dbAdapter,
                        ),
                    ),
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

    public function getIbbinsid() {
        return $this->ibbinsid;
    }

    public function setIbbinsid($ibbinsid) {
        $this->ibbinsid = $ibbinsid;
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

    public function setFeatures(array $x_features) {
        $this->features = $x_features;
        return $this;
    }
    
    public function getFeatures() {
        return $this->features;
    }
         
}

?>
