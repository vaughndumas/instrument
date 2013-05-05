<?php
namespace Instrument\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Instrument\Model\Category;
use Instrument\Form\CategoryForm;

class CategoryController extends AbstractActionController {
    
    protected $categoryTable;
    
    public function getCategoryTable() {
        if (!$this->categoryTable) {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Instrument\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
    
    public function indexAction() {
        return new ViewModel(array(
            'categories' => $this->getCategoryTable()->fetchAll(),
        ));
    }
    
    public function addAction() {
        $form = new CategoryForm();
        $form->get('submit')->setValue('Save');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $category = new Category();
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $category->exchangeArray($form->getData());
                $this->getCategoryTable()->saveCategory($category);
                
                return $this->redirect()->toRoute('category');
            }
        }
        return array('form' => $form);
    }
    
    public function editAction() {
        $v_iabcode = $this->params()->fromRoute('iabcode');
        if (!$v_iabcode) {
            return $this->redirect()->toRoute('category', array(
                'action' => 'add'
            ));
        }
        $category = $this->getCategoryTable()->getCategory($v_iabcode);
        
        $form = new CategoryForm();
        $form->bind($category);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($category->getInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $this->getCategoryTable()->updateCategory($form->getData());
                
                return $this->redirect()->toRoute('category');
            }
        }
        
        return array(
            'iabcode' => $v_iabcode,
            'form' => $form,
        );
    }

    public function deleteAction() {
        $v_iabcode = $this->params()->fromRoute('iabcode');
        if (!$v_iabcode) {
            return $this->redirect()->toRoute('category');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $v_iabcode = $request->getPost('iabcode');
                $this->getCategoryTable()->deleteCategory($v_iabcode);
            }

            return $this->redirect()->toRoute('category');
        }

        return array(
            'iabcode'    => $v_iabcode,
            'category' => $this->getCategoryTable()->getCategory($v_iabcode)
        );
    }

}