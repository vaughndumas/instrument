<?php
namespace Instrument\Form;

use Zend\Db\Adapter\Adapter;
use Instrument\Model\Booking;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class BookingFieldset extends Fieldset implements InputFilterProviderInterface {
    
    public $_dbAdapter;
    
    public function __construct() {
        parent::__construct("bookingfieldset");
            $this->setHydrator(new ClassMethodsHydrator(false))
                 ->setObject(new Booking());

var_dump($this);exit;
            /* Valid Equipment Codes */
            
//        $v_valid_equipment = new Booking();
//        $results = $this->_dbAdapter->query("SELECT iadid AS CodeVal, CONCAT('(', iadid, ') ', iaddesc) AS DescVal FROM iadins WHERE iadactive = 'Y'")->toArray();
//        foreach ($results as $rowlist) {
//            $v_valid_equipment[$rowlist['CodeVal']] = $rowlist['DescVal'];
//        }

        $this->add(array(
            'name' => 'ibcbookno',
            'attributes' => array(
                'type' => 'number',
                'size' => 11,
            ),
            'options' => array(
                'label' => 'Booking number',
            ),
        ));

        $this->add(array(
            'name' => 'ibcdate',
            'attributes' => array(
                'type' => 'date',
            ),
            'options' => array(
                'label' => 'Transaction date',
            ),
        ));

        $this->add(array(
            'name' => 'ibcunumber',
            'attributes' => array(
                'type' => 'text',
                'size' => 11,
            ),
            'options' => array(
                'label' => 'User',
            ),
        ));

        /* Display only */
        $this->add(array(
            'name' => 'ibclab',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Lab',
            ),
        ));

        $this->add(array(
            'name' => 'ibcglc',
            'attributes' => array(
                'type' => 'text',
                'size' => 16,
            ),
            'options' => array(
                'label' => 'GLC',
            ),
        ));

        $this->add(array(
            'name' => 'ibcdatereq',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Date',
                'size' => 11,
            ),
            'options' => array(
                'label' => 'Date required',
            ),
        ));

        $this->add(array(
            'name' => 'ibcstarttime',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Time',
                'size' => 4,
            ),
            'options' => array(
                'label' => 'Start time',
            ),
        ));

        $this->add(array(
            'name' => 'ibcendtime',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Time',
                'size' => 4,
            ),
            'options' => array(
                'label' => 'End time',
            ),
        ));

        $this->add(array(
            'name' => 'ibcqueue',
            'type' => 'radio',
            'attributes' => array(
                'value' => 'N',
            ),
            'options' => array(
                'label' => 'Queue this request',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'ibcinsid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
               'label' => 'Equipment ID',
//               'value_options' => $v_valid_equipment->get_valid_equipment(),
            ),

        ));

        $this->add(array(
            'name' => 'ibcslot',
            'attributes' => array(
                'type' => 'number',
                'size' => 4,
            ),
           'options' => array(
                'label' => 'Slot number',
            ),

        ));

        $this->add(array(
            'name' => 'availfeatures',
            'options' => array(
                'type' => 'Zend\Form\Element\Collection',
                'label' => 'Features',
                'count' => 20,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Instrument\Form\AvailFeaturesFieldset'
                )
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
        
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Cancel',
                'id' => 'cancelbutton',
            ),
        ));

        
    }

    public function getInputFilterSpecification() {
        return array(
            'ibcinsid'   => array('required' => true),
            'ibcdate'    => array('required' => true),
            'ibcunumber' => array('required' => true),
        );
    }    
    
    public function setDbAdapter(Adapter $dbAdapter) {

        $this->_dbAdapter = $dbAdapter;
    }
    public function getDbAdapter() {
        return $this->_dbAdapter;
    }

}

?>
