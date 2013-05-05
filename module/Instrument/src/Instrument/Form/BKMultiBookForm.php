<?php
namespace Instrument\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassmethodsHydrator;

class BKMultiBookForm extends Form{

    public function __construct() {
        parent::__construct('create_bkmultibook');
        
        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassmethodsHydrator(false))
             ->setInputFilter(new InputFilter());

        $this->add(array (
            'type' => 'Instrument\Form\BKMultiBookFieldset',
            'options' => array(
                'use_as_base_fieldset' => true,
            )
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save'
            )
        ));
        
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Cancel'
            )
        ));

        $this->setValidationGroup(array());
                
    }

}

?>
