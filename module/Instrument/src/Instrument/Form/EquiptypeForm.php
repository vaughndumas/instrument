<?php
namespace Instrument\Form;

use Zend\Form\Form;

class EquiptypeForm extends Form {
    public function __construct($name = null) {
        parent::__construct('equiptype');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'iaccode',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Type Name '
            ),
        ));
        $this->add(array(
            'name' => 'iacdesc',
            'attributes' => array(
                'type' => 'text',
                'size' => 64,
                'style' => 'width:20em;'
            ),
            'options' => array(
                'label' => 'Description '
            ),
        ));
        $this->add(array(
            'name' => 'iacactive',
            'type' => 'Radio',
            'attributes' => array(
                'value' => 'Y',
            ),
            'options' => array(
                'label' => 'Active',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
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
    }
}
