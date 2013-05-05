<?php
namespace Instrument\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Instrument\Model\Equipment;
use Instrument\Form\EquipmentForm;
use Instrument\Form\CreateEquipment;
use Instrument\Model\EFMultiEquip;
use Instrument\Form\EFMultiEquipForm;
use Instrument\Model\Equipfeat;
use Instrument\Model\EquipfeatTable;

class EquipmentController extends AbstractActionController {
    
    protected $equipmentTable;
    protected $featureTable;
    protected $equipfeatTable;
    
    public function getEquipmentTable() {
        if (!$this->equipmentTable) {
            $sm = $this->getServiceLocator();
            $this->equipmentTable = $sm->get('Instrument\Model\EquipmentTable');
        }
        return $this->equipmentTable;
    }
    
    public function getEquipfeatTable() {
        if (!$this->equipfeatTable) {
            $sm = $this->getServiceLocator();
            $this->equipfeatTable = $sm->get('Instrument\Model\EquipfeatTable');
        }
        return $this->equipfeatTable;
    }

    public function getFeatureTable() {
        if (!$this->featureTable) {
            $sm = $this->getServiceLocator();
            $this->featureTable = $sm->get('Instrument\Model\FeatureTable');
        }
        return $this->featureTable;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'equipments' => $this->getEquipmentTable()->fetchAll(),
        ));
    }
    
    public function addefmeAction() {
        
        $form = new EFMultiEquipForm();
        $equipment = new EFMultiEquip();

        $v_instrument_code = $this->params()->fromRoute('iadid');
        if (!$v_instrument_code) {
            return $this->redirect()->toRoute('equipment', array(
                        'action' => 'index'
            ));
        }

        // Get all the available features
        $v_featureset = $this->getFeatureTable()->fetchAll();
        $v_tmp = array();
        foreach ($v_featureset as $v_features) {
            $v_chosen = 0;
            $v_equipfeat = $this->getEquipfeatTable()->getEquipfeat($v_features->ibacode, $v_instrument_code, 2);
            if (gettype($v_equipfeat) == 'array') {
                if ($v_equipfeat['ibbfeacode'] == '-1')
                  $v_chosen = 0;
            } else
              $v_chosen = 1;
            $v_tmp[] = array(
                'ibacode' => $v_features->ibacode,
                'ibadesc' => $v_features->ibadesc,
                'ibacost' => $v_features->ibacost,
                'ibastartval' => $v_features->ibastartval,
                'chosen'      => $v_chosen
            );
        }
        $equipment->setAvailfeatures(array('featureset' => $v_tmp));
        
        $equipment->setIadid($v_instrument_code);
        $form->bind($equipment);

        if ($this->request->isPost()) {
            $v_instrument_code = $this->params()->fromRoute('iadid');
            if (!$v_instrument_code) {
                return $this->redirect()->toRoute('equipment', array(
                            'action' => 'index'
                ));
            }

            $form->setData($this->request->getPost());

            if ($form->isValid()) {
               return $this->redirect()->toRoute('equipment');
            } else {
                echo "Form not valid<br />";
                $form->getMessages();
                exit;
            }
        }
        return array(
            'form' => $form
        );
    }
    
    public function exeaddefmeAction() {
        
        $form = new EFMultiEquipForm();
        $equipment = new EFMultiEquip();
        $form->bind($equipment);
        
        $sl = $this->getServiceLocator();
        $v_adapter = $sl->get('Zend\Db\Adapter\Adapter');
        $equipfeat = new Equipfeat();
        $equipfeat->setDbAdapter($v_adapter);
        $equipfeat = $this->getServiceLocator()->get('Instrument/Model/Equipfeat');

        $request = $this->getRequest();
        if ($request->isPost()) {
          $cancelButton = $request->getPost('cancel');
          $submitButton = $request->getPost('submit');

          if ($cancelButton) {
              return $this->redirect()->toRoute('equipment');
          }
          $form->setData($request->getPost());
          if ($form->isValid()) {
              $equipment = $request->getPost();
              foreach ($equipment as $v_row=>$v_value) {
                  if (substr($v_row, 0, 7) == 'ibacode') {
                    $v_underscore = strpos($v_row, '_');
                    $v_chosen = "chosen_".substr($v_row, $v_underscore + 1);
                    $v_isFeatureSet = $equipment[$v_chosen];

                    $equipfeat->setIbbactive('Y');
                    $equipfeat->setIbbinsid($equipment['efmultiequip']['iadid']);
                    $equipfeat->setIbbfeacode($v_value);
                    $v_feature = $this->getFeatureTable()->getFeature($v_value);
                    $equipfeat->setIbbstartval($v_feature->ibastartval);

                    $this->getEquipfeatTable()->deleteEquipfeat($v_value, $equipment['efmultiequip']['iadid']);

                    if ($v_isFeatureSet == 1)
                      $this->getEquipfeatTable()->saveEquipfeat($equipfeat);
                  }
              }
              return $this->redirect()->toRoute('equipment');
          }
        }
        return array('form' => $form);
    }

    public function addAction() {
        
        $sl = $this->getServiceLocator();
        $v_adapter = $sl->get('Zend\Db\Adapter\Adapter');
        $form = new EquipmentForm($v_adapter);
        $form->get('submit')->setValue('Save');
        
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $equipment = $this->getServiceLocator()->get('Instrument/Model/Equipment');
            $form->setInputFilter($equipment->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $equipment->exchangeArray($form->getData());
                $this->getEquipmentTable()->saveEquipment($equipment);
                
                return $this->redirect()->toRoute('equipment');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction() {
        $v_iadid = $this->params()->fromRoute('iadid');
        if (!$v_iadid) {
            return $this->redirect()->toRoute('equipment', array(
                'action' => 'add'
            ));
        }
        $v_adapter = $this->getEquipmentTable()->adapter;
        $form = new EquipmentForm($v_adapter);

        $equipment = $this->getEquipmentTable()->getEquipment($v_iadid);
        $equipment->setDbAdapter($v_adapter);

        $form->bind($equipment);
        $form->get('submit')->setAttribute('value', 'Save');
        
        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setInputFilter($equipment->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->getEquipmentTable()->updateEquipment($form->getData());
                
                return $this->redirect()->toRoute('equipment');
            }
        }
        
        return array(
            'iadid' => $v_iadid,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $v_iadid = $this->params()->fromRoute('iadid');
        if (!$v_iadid) {
            return $this->redirect()->toRoute('equipment');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $v_iadid = $request->getPost('iadid');
                $this->getEquipmentTable()->deleteEquipment($v_iadid);
            }

            return $this->redirect()->toRoute('equipment');
        }

        return array(
            'iadid'    => $v_iadid,
            'equipment' => $this->getEquipmentTable()->getEquipment($v_iadid),
        );
    }

}