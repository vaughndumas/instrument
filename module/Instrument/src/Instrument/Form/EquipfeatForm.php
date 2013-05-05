<?php
namespace Instrument\Form;

use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use DluTwBootstrapDemo\Form\BlockForm;

class EquipfeatForm extends Form implements ServiceLocatorAwareInterface {

    protected $v_serviceLocator;
    protected $v_equipfeaTable;
  
       public function __construct(\Zend\Db\Adapter\Adapter $x_adapter) {
        parent::__construct('equipfeat');
        $this->setAttribute('method', 'post');

        /* Valid Features */
        $v_valid_features = array();
        $results = $x_adapter->query("SELECT ibacode AS CodeVal, CONCAT('(',ibacode,') ',ibadesc) as DescVal FROM ibafea WHERE ibaactive = 'Y'", $x_adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach ($results as $rowlist) {
            $v_valid_features[$rowlist['CodeVal']] = $rowlist['DescVal'];
        }
    
        /* Valid Equipment Codes */
        $v_valid_equipment = array();
        $results = $x_adapter->query("SELECT iadid AS CodeVal, CONCAT('(', iadid, ') ', iaddesc) AS DescVal FROM iadins WHERE iadactive = 'Y'", $x_adapter::QUERY_MODE_EXECUTE)->toArray();
        foreach ($results as $rowlist) {
            $v_valid_equipment[$rowlist['CodeVal']] = $rowlist['DescVal'];
        }
        
        $this->add(array(
            'name' => 'ibbfeacode',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Feature',
                'value_options' => $v_valid_features,
            ),
        ));
        $this->add(array(
            'name' => 'ibbinsid',
            'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Equipment ID',
                'value_options' => $v_valid_equipment,
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
