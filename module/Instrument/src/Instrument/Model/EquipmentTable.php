<?php
namespace Instrument\Model;

use Zend\Db\TableGateway\TableGateway;

class EquipmentTable {
    
    protected $tableGateway;
    public $adapter;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
        $this->adapter = $this->tableGateway->getAdapter();
    }
    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    public function fetchAllValid() {
        $resultSet = $this->tableGateway->select(array('ibcactive' => 'Y'));
        return $resultSet;
    }
    public function getEquipment($iadid) {
        $rowset = $this->tableGateway->select(array('iadid' => $iadid));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find equipment ID " . $iadid);
        }
        return $row;
    }
    public function saveEquipment(Equipment $equipment) {
        $data = array(
            'iadid' => $equipment->iadid,
            'iaddesc' => $equipment->iaddesc,
            'iadbld' => $equipment->iadbld,
            'iadloc' => $equipment->iadloc,
            'iadinstype' => $equipment->iadinstype,
            'iadcat' => $equipment->iadcat,
            'iadactive' => $equipment->iadactive,
            'iadcontact' => $equipment->iadcontact,
            'iadnotes' => $equipment->iadnotes,
            'iademailonbooking' => $equipment->iademailonbooking,
            'iadslots' => $equipment->iadslots,
        );
        $this->tableGateway->insert($data);
    }

    public function updateEquipment(Equipment $equipment) {
        $data = array(
            'iadid' => $equipment->iadid,
            'iaddesc' => $equipment->iaddesc,
            'iadbld' => $equipment->iadbld,
            'iadloc' => $equipment->iadloc,
            'iadinstype' => $equipment->iadinstype,
            'iadcat' => $equipment->iadcat,
            'iadactive' => $equipment->iadactive,
            'iadcontact' => $equipment->iadcontact,
            'iadnotes' => $equipment->iadnotes,
            'iademailonbooking' => $equipment->iademailonbooking,
            'iadslots' => $equipment->iadslots,
        );

        $v_iadid = $equipment->iadid;
        if ($this->getEquipment($v_iadid)) {
            $this->tableGateway->update($data, array('iadid' => $v_iadid));
        } else {
            throw new Exception('Equipment code could not be found');
        }
    }

    public function deleteEquipment($x_iadid) {
        $this->tableGateway->delete(array('iadid' => $x_iadid));
    }
}