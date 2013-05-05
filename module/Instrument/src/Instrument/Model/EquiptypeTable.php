<?php
namespace Instrument\Model;

use Zend\Db\TableGateway\TableGateway;

class EquiptypeTable {
    
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    public function getEquiptype($iaccode) {
        $rowset = $this->tableGateway->select(array('iaccode' => $iaccode));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find equipment type code " . $iaccode);
        }
        return $row;
    }
    public function saveEquiptype(Equiptype $equiptype) {
        $data = array(
            'iaccode' => $equiptype->iaccode,
            'iacdesc' => $equiptype->iacdesc,
            'iacactive' => $equiptype->iacactive,
        );
        $this->tableGateway->insert($data);
    }

    public function updateEquiptype(Equiptype $equiptype) {
        $data = array(
            'iaccode' => $equiptype->iaccode,
            'iacdesc' => $equiptype->iacdesc,
            'iacactive' => $equiptype->iacactive,
        );

        $v_iaccode = $equiptype->iaccode;
        if ($this->getEquiptype($v_iaccode)) {
            $this->tableGateway->update($data, array('iaccode' => $v_iaccode));
        } else {
            throw new Exception('Equipment Type code could not be found');
        }
    }

    public function deleteEquiptype($x_iaccode) {
        $this->tableGateway->delete(array('iaccode' => $x_iaccode));
    }
}