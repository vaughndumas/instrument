<?php
namespace Instrument\Form;

use Instrument\Model\EFMultiEquip;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class EFMultiEquipFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {
        // Construct for the model
        parent::__construct("efmultiequip");
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new EFMultiEquip());
        
        $this->add(array(
            'name' => 'iadid',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Equipment ID',
            ),
        ));
        
        $this->add(array(
            'name' => 'featureset',
            'options' => array(
                'type' => 'Zend\Form\Element\Collection',
                'label' => 'Feature',
                'count' => 2,
                'should_create_template' => true,
                'template_placeholder' => '__placeholder__',
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Instrument\Form\EFMultiFieldset',
                )
            )
        ));
        
        $this->add(array(
            'name' => 'availfeatures',
            'options' => array(
                'type' => 'Zend\Form\Element\Collection',
                'label' => 'Features',
                'count' => 20,
                'should_create_template' => true,
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Instrument\Form\AvailFeaturesFieldset'
                )
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go and Save',
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

        
    }
    
    
    public function getInputFilterSpecification() {
        return array(
            'iadid' => array(
                'required' => true,
            )
        );
    }    
}

?>
