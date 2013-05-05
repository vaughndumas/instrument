<?php
namespace Instrument\Form;

use Instrument\Model\Equipfeat;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class EquipfeatFieldset extends Fieldset implements InputFilterProviderInterface {
    
    public function __construct() {
        parent::__construct('equipfeat');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new Equipfeat());
        
        $this->add(array(
            'name' => 'ibbinsid',
//            'type' => 'Zend\Form\Element\Select',
            'type' => 'text',
            'options' => array(
                'label' => 'Equipment ID',
//                'value_options' => $v_valid_equipment,
            ),
        ));

        $this->add(array(
            'name' => 'ibbstartval',
            'attributes' => array(
                'type' => 'text',
                'size' => 11,
            ),
            'options' => array(
                'label' => 'Feature amount'
            ),
        ));

        $this->add(array(
            'id' => 'ibbactive',
            'name' => 'ibbactive',
            'type' => 'radio',
            'attributes' => array(
                'label' => 'Active',
                'value' => 'Y',
            ),
            'options' => array(
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
            ),
        ));
        
        // Add the Feature Fieldset
        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'equipfeat',
            'options' => array(
                'label' => 'Please choose the features for this equipment',
                'count' => 2,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Instrument\Form\FeatureFieldset'
                )
            )
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
