<?php
namespace Instrument\Form;

use Instrument\Model\BKMultiBook;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class BKMultiBookFieldset extends Fieldset implements InputFilterProviderInterface {

    public function __construct() {
        // Construct for the model
        parent::__construct("bkmultibook");
        $this->setHydrator(new ClassMethodsHydrator(false))
             ->setObject(new BKMultiBook());
        
        $this->add(array(
            'name' => 'ibdbookno',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Booking number',
            ),
        ));
        
        $this->add(array(
            'name' => 'ibdfeacode',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Feature code',
            ),
        ));
        
        $this->add(array(
            'name' => 'ibdvalue',
        ));

        $this->add(array(
            'name' => 'ibdcost',
        ));

        $this->add(array(
            'name' => 'ibdused',
        ));

        $this->add(array(
            'name' => 'ibddatereq',
            'attributes' => array(
                'type' => 'date',
            ),
            'options' => array(
                'label' => 'Date requested',
            ),
        ));

        $this->add(array(
            'name' => 'ibdinsid',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Equipment ID',
            ),
        ));

        $this->add(array(
            'name' => 'v_glc',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'GLC',
            ),
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
                'value' => 'Save',
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
            'ibdbookno' => array(
                'required' => false,
            )
        );
    }
}

?>
