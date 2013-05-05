<?php
namespace Instrument\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Instrument\Model\EFMultiEquip;
use Instrument\Form\EFMultiEquipForm;

class EFMultiEquipController extends AbstractActionController {
    
    public function addefmeAction() {
        $form = new EFMultiEquipForm();
        $equipment_features = new EFMultiEquip();
        $form->bind($equipment_features);
        
        if ($this->request->isPost()) {
            $v_instrument_code = $this->params()->fromRoute('instrument_code');
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
}

?>
