<?php
namespace Instrument\Form;

use Instrument\Model\EFMulti;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class EFMultiFieldset extends Fieldset implements InputFilterProviderInterface {
    
    public function __construct() {
        parent::__construct('EFMulti');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new EFMulti());
        
        $this->setLabel("Equipment Features");
        
        $this->add(array(
            'name' => 'ibbfeacode',
            'options' => array(
                'label' => 'Feature Code:'
            ),
            'attributes' => array(
                'required' => false,
            ),
        ));
        
    }

    
    public function getInputFilterSpecification() {
        return array(
            'ibbfeacode' => array(
                'required' => false,
            )
        );
    }
}
