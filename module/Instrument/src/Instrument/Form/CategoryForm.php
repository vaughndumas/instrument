<?php
namespace Instrument\Form;

use Zend\Form\Form;

class CategoryForm extends Form {
    public function __construct($name = null) {
        parent::__construct('category');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'iabcode',
            'attributes' => array(
                'type' => 'text',
                'size' => 8,
            ),
            'options' => array(
                'label' => 'Category Name'
            ),
        ));
        $this->add(array(
            'name' => 'iabdesc',
            'attributes' => array(
                'type' => 'text',
                'style' => 'width: 15em;',
            ),
            'options' => array(
                'label' => 'Description'
            ),
        ));
        $this->add(array(
            'name' => 'iabcolour',
            'attributes' => array(
                'type' => 'color',
                'size' => 7,
                'style' => 'width:7em;',
            ),
            'options' => array(
                'label' => 'Category Colour'
            ),
        ));
        
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }
}
