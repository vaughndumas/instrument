<?php
namespace Instrument\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Instrument\Model\Equiptype;
use Instrument\Form\EquiptypeForm;

class EquiptypeController extends AbstractActionController {
    
    protected $equiptypeTable;
    
    public function getEquiptypeTable() {
        if (!$this->equiptypeTable) {
            $sm = $this->getServiceLocator();
            $this->equiptypeTable = $sm->get('Instrument\Model\EquiptypeTable');
        }
        return $this->equiptypeTable;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'equiptypes' => $this->getEquiptypeTable()->fetchAll(),
        ));
    }
    
    public function addAction() {
        $form = new EquiptypeForm();
        $form->get('submit')->setValue('Save');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $equiptype = new Equiptype();
            $form->setInputFilter($equiptype->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $equiptype->exchangeArray($form->getData());
                $this->getEquiptypeTable()->saveEquiptype($equiptype);
                
                return $this->redirect()->toRoute('equiptype');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction() {
        $v_iaccode = $this->params()->fromRoute('iaccode');
        if (!$v_iaccode) {
            return $this->redirect()->toRoute('equiptype', array(
                'action' => 'add'
            ));
        }
        $equiptype = $this->getEquiptypeTable()->getEquiptype($v_iaccode);
        
        $form = new EquiptypeForm();
        $form->bind($equiptype);
        $form->get('submit')->setAttribute('value', 'Save');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($equiptype->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->getEquiptypeTable()->updateEquiptype($form->getData());
                
                return $this->redirect()->toRoute('equiptype');
            }
        }
        
        return array(
            'iaccode' => $v_iaccode,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $v_iaccode = $this->params()->fromRoute('iaccode');
        if (!$v_iaccode) {
            return $this->redirect()->toRoute('equiptype');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $v_iaccode = $request->getPost('iaccode');
                $this->getEquiptypeTable()->deleteEquiptype($v_iaccode);
            }

            return $this->redirect()->toRoute('equiptype');
        }

        return array(
            'iaccode'    => $v_iaccode,
            'equiptype' => $this->getEquiptypeTable()->getEquiptype($v_iaccode)
        );
    }

}