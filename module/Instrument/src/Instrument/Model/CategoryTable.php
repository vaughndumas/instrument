<?php
namespace Instrument\Model;

use Zend\Db\TableGateway\TableGateway;

class CategoryTable {
    
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    public function getCategory($iabcode) {
        $rowset = $this->tableGateway->select(array('iabcode' => $iabcode));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find category code " . $iabcode);
        }
        return $row;
    }
    public function saveCategory(Category $category) {
        $data = array(
            'iabcode' => $category->iabcode,
            'iabdesc' => $category->iabdesc,
            'iabcolour' => $category->iabcolour,
        );
        $this->tableGateway->insert($data);
    }

    public function updateCategory(Category $category) {
        $data = array(
            'iabcode' => $category->iabcode,
            'iabdesc' => $category->iabdesc,
            'iabcolour' => $category->iabcolour,
        );

        $v_iabcode = $category->iabcode;
        if ($this->getCategory($v_iabcode)) {
            $this->tableGateway->update($data, array('iabcode' => $v_iabcode));
        } else {
            throw new Exception('Category code could not be found');
        }
    }

    public function deleteCategory($x_iabcode) {
        $this->tableGateway->delete(array('iabcode' => $x_iabcode));
    }
}