<?php
namespace Instrument\Model;

use Zend\Db\TableGateway\TableGateway;

class FeatureTable {
    
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function fetchAll() {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    public function getFeature($ibacode) {
        $rowset = $this->tableGateway->select(array('ibacode' => $ibacode));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find feature code " . $ibacode);
        }
        return $row;
    }
    public function saveFeature(Feature $feature) {
        $data = array(
            'ibacode' => $feature->ibacode,
            'ibadesc' => $feature->ibadesc,
            'ibastartval' => $feature->ibastartval,
            'ibacost' => $feature->ibacost,
            'ibafeatime' => $feature->ibafeatime,
            'ibaactive' => $feature->ibaactive,
        );
        $this->tableGateway->insert($data);
/*
        $v_ibacode = $feature->ibacode;
        if (!$v_ibacode)
            $this->tableGateway->insert($data);
        else {
            if ($this->getFeature($v_ibacode)) {
                $this->tableGateway->update($data, array('ibacode' => $v_ibacode));
            } else {
                throw new Exception('Feature code could not be found');
            }
        }
 */
    }

    public function updateFeature(Feature $feature) {
        $data = array(
            'ibacode' => $feature->ibacode,
            'ibadesc' => $feature->ibadesc,
            'ibastartval' => $feature->ibastartval,
            'ibacost' => $feature->ibacost,
            'ibafeatime' => $feature->ibafeatime,
            'ibaactive' => $feature->ibaactive,
        );

        $v_ibacode = $feature->ibacode;
        if ($this->getFeature($v_ibacode)) {
            $this->tableGateway->update($data, array('ibacode' => $v_ibacode));
        } else {
            throw new Exception('Feature code could not be found');
        }
    }

    public function deleteFeature($x_ibacode) {
        $this->tableGateway->delete(array('ibacode' => $x_ibacode));
    }
}