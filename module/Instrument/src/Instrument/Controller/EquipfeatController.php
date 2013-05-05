<?php
namespace Instrument\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Instrument\Model\Equipfeat;
use Instrument\Form\EquipfeatForm;
use Instrument\Form\CreateEquipfeat;

class EquipfeatController extends AbstractActionController {
    
    protected $equipfeatTable;
    
    public function getEquipfeatTable() {
        if (!$this->equipfeatTable) {
            $sm = $this->getServiceLocator();
            $this->equipfeatTable = $sm->get('Instrument\Model\EquipfeatTable');
        }
        return $this->equipfeatTable;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'equipfeats' => $this->getEquipfeatTable()->fetchAll(),
        ));
    }
    
    public function addAction() {
        $sl = $this->getServiceLocator();
        $v_adapter = $sl->get('Zend\Db\Adapter\Adapter');
        $form = new EquipfeatForm($v_adapter);
        $equipfeat = new Equipfeat();
        $equipfeat->setDbAdapter($v_adapter);
        
        $form->bind($equipfeat);
        // Original code
        $form->get('submit')->setValue('Save New');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $equipfeat = $this->getServiceLocator()->get('Instrument/Model/Equipfeat');
            $form->setInputFilter($equipfeat->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $equipfeat->exchangeArray($form->getData());
                $this->getEquipfeatTable()->saveEquipfeat($equipfeat);
                
                return $this->redirect()->toRoute('equipfeat');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction() {
        $v_ibbfeacode = $this->params()->fromRoute('ibbfeacode');
        $v_ibbinsid = $this->params()->fromRoute('ibbinsid');
        if (!$v_ibbfeacode || !$v_ibbinsid) {
            return $this->redirect()->toRoute('equipfeat', array(
                'action' => 'add'
            ));
        }
        $v_adapter = $this->getEquipfeatTable()->adapter;
        $form = new EquipfeatForm($v_adapter);

        $equipfeat = $this->getEquipfeatTable()->getEquipfeat($v_ibbfeacode, $v_ibbinsid);
        $equipfeat->setDbAdapter($v_adapter);

        $form->bind($equipfeat);
        $form->get('submit')->setAttribute('value', 'Save');
        
        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter($equipfeat->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->getEquipfeatTable()->updateEquipfeat($form->getData());
                
                return $this->redirect()->toRoute('equipfeat');
            }
        }
        
        return array(
            'ibbfeacode' => $v_ibbfeacode,
            'ibbinsid' => $v_ibbinsid,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $v_ibbfeacode = $this->params()->fromRoute('ibbfeacode');
        $v_ibbinsid = $this->params()->fromRoute('ibbinsid');
        if (!$v_ibbfeacode || !$v_ibbinsid) {
            return $this->redirect()->toRoute('equipfeat');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $v_iadid = $request->getPost('iadid');
                $this->getEquipfeatTable()->deleteEquipfeat($v_ibbfeacode, $v_ibbinsid);
            }

            return $this->redirect()->toRoute('equipfeat');
        }

        return array(
            'ibbfeacode' => $v_ibbfeacode,
            'ibbinsid' => $v_ibbinsid,
            'equipment' => $this->getEquipfeatTable()->getEquipfeat($v_ibbfeacode, $v_ibbinsid),
        );
    }

}