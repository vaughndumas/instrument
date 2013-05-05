<?php
namespace Instrument\Form;

use Zend\Form\Form;

class BookingForm extends Form {

    public function __construct(\Zend\Db\Adapter\Adapter $x_adapter) {
        parent::__construct('create_booking');
        $this->setAttribute('method', 'post');

        /* Valid Equipment Codes */
        $v_valid_equipment = array();
        $results = $x_adapter->query("SELECT iadid AS CodeVal, CONCAT('(', iadid, ') ', iaddesc) AS DescVal FROM iadins WHERE iadactive = 'Y'", $x_adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach ($results as $rowlist) {
            $v_valid_equipment[$rowlist['CodeVal']] = $rowlist['DescVal'];
        }

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
                'min' => date('d/m/y'),
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
                'id' => 'book_unumber',
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
                'id' => 'book_glc'
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
                'min' => date('d/m/y'),
                'id' => 'book_datereq',
            ),
            'options' => array(
                'label' => 'Date required',
            ),
        ));

        $this->add(array(
            'name' => 'ibcstarttime',
            'attributes' => array(
                'type' => 'time',
                'id' => 'ins_starttime',
            ),
            'options' => array(
                'label' => 'Start time',
                'format' => 'h:i',
            ),
        ));

        $this->add(array(
            'name' => 'ibcendtime',
            'attributes' => array(
                'type' => 'time',
                'id' => 'ins_endtime',
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
            'attributes' => array(
                'id' => 'ins_select',
            ),
            'options' => array(
               'label' => 'Equipment ID',
               'value_options' => $v_valid_equipment,
            ),

        ));

        $this->add(array(
            'name' => 'ibcslot',
            'attributes' => array(
                'type' => 'number',
                'size' => 4,
                'min' => 1,
                'max' => 10,
                'value' => 1,
                'id' => 'book_slot'
            ),
           'options' => array(
                'label' => 'Slot number',
            ),

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

//        $this->add(array (
//            'type' => 'Instrument\Form\BookingFieldset',
//            'options' => array(
//                'use_as_base_fieldset' => true,
//            )
//        ));

        
    }

    public function getServiceLocator() {
        return $this->v_serviceLocator;
    }
    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->v_serviceLocator = $serviceLocator;
    }
}

?>
