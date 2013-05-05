<?php
namespace Instrument\Form;

use Zend\form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CreateEquipfeat extends Form {
    
    public function __construct() {
        parent::__construct('create_equipfeat');
        
        $this->setAttribute('method', 'post')
             ->setHydrator(new ClassMethodsHydrator(false))
             ->setInputFilter(new InputFilter());
        
      $this->add(array(
          'type' => 'Instrument\Form\EquipfeatFieldset',
          'options' => array(
              'use_as_base_fieldset' => true
          )
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

?>
