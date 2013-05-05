<?php
namespace Instrument\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use DluTwBootstrapDemo\Form\BlockForm;

class EquipmentForm extends Form implements ServiceLocatorAwareInterface {

    protected $v_serviceLocator;
    protected $v_equiptypeTable;
  
       public function __construct(\Zend\Db\Adapter\Adapter $x_adapter) {
        parent::__construct('equipment');
        $this->setAttribute('method', 'post');

        /* Valid Equipment Types */
        $v_valid_equiptypes = array();
        $results = $x_adapter->query("SELECT iaccode AS CodeVal, CONCAT('(', iaccode, ') ', iacdesc) AS DescVal FROM iaceqt", $x_adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach ($results as $equiptype) {
            $v_valid_equiptypes[$equiptype['CodeVal']] = $equiptype['DescVal'];
        }
        
        /* Valid Equipment Categories */
        $v_valid_categories = array();
        $results = $x_adapter->query("SELECT iabcode AS CodeVal, CONCAT('(',iabcode,') ',iabdesc) as DescVal FROM iabcat", $x_adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach ($results as $rowlist) {
            $v_valid_categories[$rowlist['CodeVal']] = $rowlist['DescVal'];
        }
    
        $this->add(array(
            'name' => 'iadid',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Equipment Name '
            ),
        ));
        $this->add(array(
            'name' => 'iaddesc',
            'attributes' => array(
                'type' => 'text',
                'size' => 64,
            ),
            'options' => array(
                'label' => 'Description '
            ),
        ));

        $this->add(array(
            'name' => 'iadbld',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Building '
            ),
        ));

        $this->add(array(
            'name' => 'iadloc',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Location '
            ),
        ));
        
        $this->add(array(
            'name' => 'iadinstype',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Equipment Type ',
                'value_options' => $v_valid_equiptypes,
            ),
            'attributes' => array(
                'style' => 'width:250px;',
            )
        ));

        $this->add(array(
            'name' => 'iadcat',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Category ',
                'value_options' => $v_valid_categories,
            ),
            'attributes' => array(
                'style' => 'width:250px;',
            )
        ));

        $this->add(array(
                    'id' => 'iadactive',
                    'name' => 'iadactive',
                    'type' => 'radio',
                    'attributes' => array(
                        'value' => 'Y',
                        'label' => 'Active ',
                    ),
                    'options' => array(
                        'label' => 'Active ',
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
                'label' => 'Contact Person '
            ),
        ));


        $this->add(array(
            'name' => 'iadnotes',
            'attributes' => array(
                'type' => 'textarea',
            ),
            'options' => array(
                'label' => 'Notes '
            ),
        ));

        $this->add(array(
            'name' => 'iademailonbooking',
            'type' => 'Radio',
            'attributes' => array(
                'value' => 'N',
            ),
            'options' => array(
                'label' => 'Send booking email ',
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
                'label' => 'Slots '
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
        $this->add(array(
            'name' => 'cancel',
            'attributes' => array(
                'type' => 'cancel',
                'value' => 'Cancel',
                'id' => 'cancelbutton',
            ),
        ));
    }

    public function getServiceLocator() {
        return $this->v_serviceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
        $this->v_serviceLocator = $serviceLocator;
    }

}
