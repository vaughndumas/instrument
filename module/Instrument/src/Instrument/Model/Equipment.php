<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;

class Equipment implements InputFilterAwareInterface {
    public $iadid;         // Equipment Identifier
    public $iaddesc;       // Description
    public $iadbld;        // Building
    public $iadloc;        // Location
    public $iadinstype;    // Equipment Type
    public $iadcat;        // Equipment category
    public $iadactive;     // Is this equipment active
    public $iadcontact;    // Uni ID of the contact person
    public $iadnotes;      // Any notes associated with this equipment
    public $iademailonbooking;  // Must the contact person be emailed when a booking is made
    public $iadslots;      // Number of slots available
    public $feature;       // Equipment features
    public $availfeatures; // Available features
    protected $inputFilter;
    protected $_dbAdapter;
    
    public function exchangeArray($data) {
        $this->iadid      = (isset($data['iadid'])) ? $data['iadid']           : null;
        $this->iaddesc    = (isset($data['iaddesc'])) ? $data['iaddesc']       : null;
        $this->iadbld     = (isset($data['iadbld'])) ? $data['iadbld']         : null;
        $this->iadloc     = (isset($data['iadloc'])) ? $data['iadloc']         : null;
        $this->iadinstype = (isset($data['iadinstype'])) ? $data['iadinstype'] : null;
        $this->iadcat     = (isset($data['iadcat'])) ? $data['iadcat']         : null;
        $this->iadactive  = (isset($data['iadactive'])) ? $data['iadactive']   : null;
        $this->iadcontact = (isset($data['iadcontact'])) ? $data['iadcontact'] : null;
        $this->iadnotes   = (isset($data['iadnotes'])) ? $data['iadnotes']     : null;
        $this->iademailonbooking = (isset($data['iademailonbooking'])) ? $data['iademailonbooking'] : null;
        $this->iadslots   = (isset($data['iadslots'])) ? $data['iadslots']     : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getInputFilter() {

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
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'iaddesc',
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
                'name' => 'iadbld',
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
                'name' => 'iadloc',
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
                'name' => 'iadinstype',
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
                            'max' => 8,
                        ),
                    ),
//                    array(
//                        'name' => 'Db\RecordExists',
//                        'options' => array(
//                            'table' => 'iaceqt',
//                            'field' => 'iaccode',
//                            'adapter' => $this->_dbAdapter,
//                        ),
//                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'iadcat',
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
                            'max' => 8,
                        ),
                    ),
//                    array(
//                        'name' => 'Db\RecordExists',
//                        'options' => array(
//                            'table' => 'iabcat',
//                            'field' => 'iabcode',
//                            'adapter' => $this->_dbAdapter,
//                        ),
//                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
              'name' => 'iadactive',
              'required' => true,
              'options' => array(
                'label' => 'Active',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
              ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'iadcontact',
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
                            'max' => 16,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
              'name' => 'iademailonbooking',
              'options' => array(
                'label' => 'Active',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
              ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'iadslots',
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
                            'max' => 2,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'iadnotes',
                'required' => FALSE,
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
    
    public function setDbAdapter(Adapter $adapter) {
        $this->_dbAdapter = $adapter;
    }
    
    public function getDbAdapter() {
        return $this->_dbAdapter;
    }
    public function getIadid() {
        return $this->iadid;
    }

    public function setIadid($iadid) {
        $this->iadid = $iadid;
        return $this;
    }

    public function getIaddesc() {
        return $this->iaddesc;
    }

    public function setIaddesc($iaddesc) {
        $this->iaddesc = $iaddesc;
        return $this;
    }

    public function getIadbld() {
        return $this->iadbld;
    }

    public function setIadbld($iadbld) {
        $this->iadbld = $iadbld;
        return $this;
    }

    public function getIadloc() {
        return $this->iadloc;
    }

    public function setIadloc($iadloc) {
        $this->iadloc = $iadloc;
        return $this;
    }

    public function getIadinstype() {
        return $this->iadinstype;
    }

    public function setIadinstype($iadinstype) {
        $this->iadinstype = $iadinstype;
        return $this;
    }

    public function getIadcat() {
        return $this->iadcat;
    }

    public function setIadcat($iadcat) {
        $this->iadcat = $iadcat;
        return $this;
    }

    public function getIadactive() {
        return $this->iadactive;
    }

    public function setIadactive($iadactive) {
        $this->iadactive = $iadactive;
        return $this;
    }

    public function getIadcontact() {
        return $this->iadcontact;
    }

    public function setIadcontact($iadcontact) {
        $this->iadcontact = $iadcontact;
        return $this;
    }

    public function getIadnotes() {
        return $this->iadnotes;
    }

    public function setIadnotes($iadnotes) {
        $this->iadnotes = $iadnotes;
        return $this;
    }

    public function getIademailonbooking() {
        return $this->iademailonbooking;
    }

    public function setIademailonbooking($iademailonbooking) {
        $this->iademailonbooking = $iademailonbooking;
        return $this;
    }

    public function getIadslots() {
        return $this->iadslots;
    }

    public function setIadslots($iadslots) {
        $this->iadslots = $iadslots;
        return $this;
    }

    public function getFeature() {
        return $this->feature;
    }

    public function setFeature(array $feature) {
        $this->feature = $feature;
        return $this;
    }

    public function getAvailfeatures() {
        return $this->availfeatures;
    }

    public function setAvailfeatures(array $availfeatures) {
        $this->availfeatures = $availfeatures;
        return $this;
    }
              
}

?>
