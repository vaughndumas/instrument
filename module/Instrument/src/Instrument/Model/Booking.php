<?php
namespace Instrument\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\AdapterAwareInterface;
use Instrument\Model\EquipmentTable;

class Booking implements InputFilterAwareInterface {
    public $ibcbookno;     // Booking bumber
    public $ibcdate;       // Date booking was made
    public $ibcunumber;    // Uni ID of contact person
    public $ibclab;        // Lab
    public $ibcglc;        // General ledger code
    public $ibcdatereq;    // Date on which equipment is required
    public $ibcstarttime;  // Start time
    public $ibcendtime;    // End time
    public $ibcqueue;      // Queue this booking - start and end times are null
    public $ibcinsid;      // Equipment ID
    public $ibcslot;       // Slot required
    public $availfeatures; // Available features
    protected $inputFilter;
    protected $_dbAdapter;
    protected $equipmentTable;
    protected $serviceLocator;

    public function getServiceLocator() {
        return $this->serviceLocator;
    }
    public function getEquipmentTable() {
        if (!$this->equipmentTable) {
            $this->equipmentTable = $this->getServiceLocator()->get('Instrument\Model\equipmentTable');
        }
        return $this->equipmentTable;
    }
    
    public function get_valid_equipment() {
      $resultset = $this->getEquipmentTable()->fetchAllValid();
      return $resultset;    
    }


    public function exchangeArray($data) {
        $this->ibcbookno    = (isset($data['ibcbookno']))    ? $data['ibcbookno']    : null;
        $this->ibcdate      = (isset($data['ibcdate']))      ? $data['ibcdate']      : null;
        $this->ibcunumber   = (isset($data['ibcunumber']))   ? $data['ibcunumber']   : null;
        $this->ibclab       = (isset($data['ibclab']))       ? $data['ibclab']       : null;
        $this->ibcglc       = (isset($data['ibcglc']))       ? $data['ibcglc']       : null;
        $this->ibcdatereq   = (isset($data['ibcdatereq']))   ? $data['ibcdatereq']   : null;
        $this->ibcstarttime = (isset($data['ibcstarttime'])) ? $data['ibcstarttime'] : null;
        $this->ibcendtime   = (isset($data['ibcendtime']))   ? $data['ibcendtime']   : null;
        $this->ibcqueue     = (isset($data['ibcqueue']))     ? $data['ibcqueue']     : null;
        $this->ibcinsid     = (isset($data['ibcinsid']))     ? $data['ibcinsid']     : null;
        $this->ibcslot      = (isset($data['ibcslot']))      ? $data['ibcslot']      : null;
    }
    
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    public function getInputFilter() {

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibcbookno',
                'required' => false,
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
                'name' => 'ibcdate',
                'required' => false,
//                'filters' => array(
//                    array('name' => 'StripTags'),
//                    array('name' => 'StringTrim'),
//                ),
//                'validators' => array(
//                    array(
//                        'name' => 'StringLength',
//                        'options' => array(
//                            'encoding' => 'UTF-8',
//                            'min' => 1,
//                            'max' => 64,
//                        ),
//                    ),
//                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibcunumber',
                'required' => false,
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name' => 'ibclab',
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
                'name' => 'ibcglc',
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
                'name' => 'ibcdatereq',
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
                            'max' => 11,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
              'name' => 'ibcstarttime',
              'required' => true,
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
              'name' => 'ibcendtime',
              'required' => true,
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
              'name' => 'ibcqueue',
              'options' => array(
                'label' => 'Queue',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
              ),
            )));

            $inputFilter->add($factory->createInput(array(
              'name' => 'ibcinsid',
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
                            'table' => 'iadins',
                            'field' => 'iadid',
                            'adapter' => $this->_dbAdapter,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name' => 'ibcslot',
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
    public function getIbcbookno() {
        return $this->ibcbookno;
    }

    public function setIbcbookno($ibcbookno) {
        $this->ibcbookno = $ibcbookno;
    }

    public function getIbcdate() {
        return $this->ibcdate;
    }

    public function setIbcdate($ibcdate) {
        $this->ibcdate = $ibcdate;
    }

    public function getIbcunumber() {
        return $this->ibcunumber;
    }

    public function setIbcunumber($ibcunumber) {
        $this->ibcunumber = $ibcunumber;
    }

    public function getIbclab() {
        return $this->ibclab;
    }

    public function setIbclab($ibclab) {
        $this->ibclab = $ibclab;
    }

    public function getIbcglc() {
        return $this->ibcglc;
    }

    public function setIbcglc($ibcglc) {
        $this->ibcglc = $ibcglc;
    }

    public function getIbcdatereq() {
        return $this->ibcdatereq;
    }

    public function setIbcdatereq($ibcdatereq) {
        $this->ibcdatereq = $ibcdatereq;
    }

    public function getIbcstarttime() {
        return $this->ibcstarttime;
    }

    public function setIbcstarttime($ibcstarttime) {
        $this->ibcstarttime = $ibcstarttime;
    }

    public function getIbcendtime() {
        return $this->ibcendtime;
    }

    public function setIbcendtime($ibcendtime) {
        $this->ibcendtime = $ibcendtime;
    }

    public function getIbcqueue() {
        return $this->ibcqueue;
    }

    public function setIbcqueue($ibcqueue) {
        $this->ibcqueue = $ibcqueue;
    }

    public function getIbcinsid() {
        return $this->ibcinsid;
    }

    public function setIbcinsid($ibcinsid) {
        $this->ibcinsid = $ibcinsid;
    }

    public function getIbcslot() {
        return $this->ibcslot;
    }

    public function setIbcslot($ibcslot) {
        $this->ibcslot = $ibcslot;
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
