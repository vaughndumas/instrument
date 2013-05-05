<?php
namespace Instrument\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Instrument\Model\Feature;
use Instrument\Form\FeatureForm;

class FeatureController extends AbstractActionController {
    
    protected $featureTable;
    
    public function getFeatureTable() {
        if (!$this->featureTable) {
            $sm = $this->getServiceLocator();
            $this->featureTable = $sm->get('Instrument\Model\FeatureTable');
        }
        return $this->featureTable;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'features' => $this->getFeatureTable()->fetchAll(),
        ));
    }
    
    public function addAction() {
        $form = new FeatureForm();
        $form->get('submit')->setValue('Save');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $feature = new Feature();
            $form->setInputFilter($feature->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $feature->exchangeArray($form->getData());
                $this->getFeatureTable()->saveFeature($feature);
                
                return $this->redirect()->toRoute('feature');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction() {
        $v_ibacode = $this->params()->fromRoute('ibacode');
        if (!$v_ibacode) {
            return $this->redirect()->toRoute('feature', array(
                'action' => 'add'
            ));
        }
        $feature = $this->getFeatureTable()->getFeature($v_ibacode);
        
        $form = new FeatureForm();
        $form->bind($feature);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($feature->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->getFeatureTable()->updateFeature($form->getData());
                
                return $this->redirect()->toRoute('feature');
            }
        }
        
        return array(
            'ibacode' => $v_ibacode,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $v_ibacode = $this->params()->fromRoute('ibacode');
        if (!$v_ibacode) {
            return $this->redirect()->toRoute('feature');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $v_ibacode = $request->getPost('ibacode');
                $this->getFeatureTable()->deleteFeature($v_ibacode);
            }

            return $this->redirect()->toRoute('feature');
        }

        return array(
            'ibacode'    => $v_ibacode,
            'feature' => $this->getFeatureTable()->getFeature($v_ibacode)
        );
    }

}