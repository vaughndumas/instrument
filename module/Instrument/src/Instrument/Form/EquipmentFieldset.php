<?php
namespace Instrument\Form;

use Instrument\Model\Feature;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class EquipmentFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {
        parent::__construct('equipment');
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new Feature());
        
        //$this->setLabel("Equipment");
        
        $this->add(array(
            'name' => 'iadid',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Equipment ID',
                'hint' => 'Enter an 8 character code for this instrument.'
            ),
        ));
        $this->add(array(
            'name' => 'iaddesc',
            'attributes' => array(
                'type' => 'text',
                'size' => 64,
            ),
            'options' => array(
                'label' => 'Description'
            ),
        ));

        $this->add(array(
            'name' => 'iadbld',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Building'
            ),
        ));

        $this->add(array(
            'name' => 'iadloc',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Location'
            ),
        ));
        
        $this->add(array(
            'name' => 'iadinstype',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Equipment Type',
                'value' => 'BAL',
                'value_options' => $v_valid_equiptypes,
            ),
        ));

        $v_valid_categories = array('1' => 'Ops', '2' => 'Multilab with booking system');
        
        $this->add(array(
            'name' => 'iadcat',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Category',
                'value' => 1,
                'value_options' => $v_valid_categories,
            ),
        ));

        $this->add(array(
                    'id' => 'iadactive',
                    'name' => 'iadactive',
                    'type' => 'radio',
                    'value' => 'Y',
                    'attributes' => array(
                        'value' => 'Y',
                        'label' => 'Active',
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
            'name' => 'iadcontact',
            'required' => false,
            'attributes' => array(
                'type' => 'text',
                'size' => 16,
            ),
            'options' => array(
                'label' => 'Contact Person',
                'hint' => 'Enter the Uni ID of the person responsible for this instrument'
            ),
        ));


        $this->add(array(
            'name' => 'iadnotes',
            'attributes' => array(
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Notes'
            ),
        ));

        $this->add(array(
            'name' => 'iademailonbooking',
            'type' => 'Radio',
            'attributes' => array(
                'value' => 'N',
            ),
            'options' => array(
                'label' => 'Send booking email',
                'value_options' => array(
                    'Y' => 'Yes',
                    'N' => 'No',
                ),
            ),
        ));

        $this->add(array(
            'name' => 'iadslots',
            'attributes' => array(
                'type' => 'text',
                'value' => 1,
            ),
            'options' => array(
                'value' => 1,
                'label' => 'Slots'
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'feature',
            'options' => array(
                'label' => 'Please choose the features for this product',
                'count' => 2,
                'should_create_template' => true,
                'template_placeholder' => '__placeholder__',
                'allow_add' => true,
                'target_element' => array(
                    'type' => 'Instrument\Form\FeatureFieldset',
                )
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
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
