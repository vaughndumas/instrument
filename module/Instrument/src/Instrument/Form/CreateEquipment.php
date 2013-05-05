<?php
namespace Instrument\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassmethodsHydrator;

class CreateEquipment extends Form {
    
    public function __construct() {
        parent::__construct('create_equipment');
        
        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassmethodsHydrator(false))
             ->setInputFilter(new InputFilter());
        
        $this->add(array(
            'type' => 'Instrument\Form\EquipmentFieldset',
            'options' => array(
                'use_as_base_fieldset' => true
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf'
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Send'
            )
        ));
    }
}

