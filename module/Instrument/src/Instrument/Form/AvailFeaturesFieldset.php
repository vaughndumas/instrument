<?php
namespace Instrument\Form;

use Instrument\Model\AvailFeatures;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class AvailFeaturesFieldset extends Fieldset implements InputFilterProviderInterface {
    
    public function __construct() {
        parent::__construct('availfeatures');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new AvailFeatures());
        
        $this->setLabel("Available Features");
        
        $this->add(array(
            'name' => 'ibacode',
            'options' => array(
                'label' => 'Feature code:',
            ),
            'attributes' => array(
                'required' => false,
            ),
        ));
        $this->add(array(
            'name' => 'ibadesc',
            'options' => array(
                'label' => 'Description:'
            ),
        ));
        $this->add(array(
            'name' => 'ibastartval',
            'options' => array(
                'label' => 'Feature value:'
            ),
        ));
        $this->add(array(
            'name' => 'ibacost',
            'options' => array(
                'label' => 'Feature cost:'
            ),
        ));
        $this->add(array(
            'name' => 'chosen',
        ));
    }
    
    public function getInputFilterSpecification() {
        return array(
            'ibacode' => array(
                'required' => false,
            )
        );
    }
}
