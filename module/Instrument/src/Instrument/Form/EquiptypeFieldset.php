<?php
namespace Instrument\Form;

use Inventory\Model;
use Zend\Form\Element;
use Zend\Form\Fieldset;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\InputFilter\InputFilterProviderInterface;

use Instrument\Model\EquiptypeTable;
use Instrument\Model\Equiptype;

class EquiptypeFieldset extends Fieldset implements ServiceLocatorAwareInterface {

    protected $serviceLocator;
    protected $equiptypeTable;
    
    public function init() {
        parent::__construct('Equipment Type Code');
        $this->setLabel('Type Code');
        $this->setName("iadinstype");
        $equiptypes = $this->getEquiptypeTable()->fetchAll();
        
        $select = new Element\Select('iadinstype');
        $options = array();
        foreach ($equiptypes as $equiptype) {
            $options[$equiptype->iaccode] = $equiptype->iacdesc;
        }
        $select->setValueOptions($options);
    }
    public function getServiceLocator() {
        return $this->serviceLocator;
    }

    public function setServiceLocator(ServiceLocatorInterface $serviceLocator) {
        $this->serviceLocator = $serviceLocator;
    }  
    
    public function getEquiptypeTable() {
        if (!$this->equiptypeTable) {
            $sm = $this->getServiceLocator();
            $this->equiptypeTable = $sm->get('Instrument\Model\EquiptypeTable');
        }
        return $this->equiptypeTable;
    }
}

?>
