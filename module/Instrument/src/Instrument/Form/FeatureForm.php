<?php
namespace Instrument\Form;

use Zend\Form\Form;

class FeatureForm extends Form {
    public function __construct($name = null) {
        parent::__construct('feature');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'ibacode',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Instrument Code'
            ),
        ));
        $this->add(array(
            'name' => 'ibadesc',
            'attributes' => array(
                'type' => 'text',
                'size' => 64,
            ),
            'options' => array(
                'label' => 'Description'
            ),
        ));
        $this->add(array(
            'name' => 'ibastartval',
            'attributes' => array(
                'type' => 'text',
                'size' => 11,
            ),
            'options' => array(
                'label' => 'Default Run Value'
            ),
        ));
        $this->add(array(
            'name' => 'ibacost',
            'attributes' => array(
                'type' => 'text',
                'size' => 18,
                'value' => 0.0,
            ),
            'options' => array(
                'label' => 'Cost',
            ),
        ));
        $this->add(array(
            'name' => 'ibafeatime',
            'attributes' => array(
                'type' => 'text',
                'size' => 11,
                'value' => 0,
            ),
            'options' => array(
                'label' => 'Feature Time',
            ),
        ));
        $this->add(array(
            'name' => 'ibaactive',
            'type' => 'Radio',
            'options' => array(
                'label' => 'Active',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
            ),
            'attributes' => array(
                'value' => 'Y',
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
    }
}
