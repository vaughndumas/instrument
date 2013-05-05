<?php
namespace Instrument\Form;

use Instrument\Model\Feature;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class FeatureFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {
        parent::__construct('feature');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new Feature());
        
        $this->setLabel("Equipment Features");
        
        $this->add(array(
            'name' => 'ibacode',
            'options' => array(
                'label' => 'Feature Code:'
            ),
            'attributes' => array(
                'required' => true,
            ),
        ));

    }
    public function getInputFilterSpecification() {
        return array(
            'ibacode' => array(
                'required' => true,
            )
        );
    }
}
