<?php
namespace Instrument\Model;

use Zend\Db\TableGateway\TableGateway;

class EquipfeatTable {
    
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
    public function getEquipfeat($ibbfeacode, $ibbinsid, $x_throwerror = 1) {
        $rowset = $this->tableGateway->select(array('ibbfeacode' => $ibbfeacode, 
                                                    'ibbinsid' => $ibbinsid));
        $row = $rowset->current();
        if (!$row and ($x_throwerror == 1)) {
            throw new \Exception("Could not find equipment feature information " . $ibbfeacode. " : ".$ibbinsid);
        } elseif (!$row and ($x_throwerror == 2)) {
          $row['ibbfeacode'] = '-1';
        }
        return $row;
    }
    
    public function getEquipfeat_Equipcode($ibbinsid, $x_throwerror = 1) {
        $rowset = $this->tableGateway->select(array('ibbinsid' => $ibbinsid,
                                                    'ibbactive' => 'Y'));
//        foreach ($rowset as $row) {
//            print_r($row);
//            echo "<hr />";
//        }
//        $row = $rowset->current();
//        if (!row and ($x_throwerror == 1)) {
//            throw new \Exception("Could not find equipment features for " . $ibbinsid);
//        } elseif (!$row and ($x_throwerror == 2)) {
//            $row['ibbfeacode'] = '-1';
//        }
        return $rowset;
    }
    
    public function saveEquipfeat(Equipfeat $equipfeat) {
        $data = array(
            'ibbfeacode'  => $equipfeat->ibbfeacode,
            'ibbinsid'    => $equipfeat->ibbinsid,
            'ibbstartval' => (Int) $equipfeat->ibbstartval,
            'ibbactive'   => $equipfeat->ibbactive,
        );
        $this->tableGateway->insert($data);
    }

    public function updateEquipfeat(Equipfeat $equipfeat) {
        $data = array(
            'ibbfeacode'  => $equipfeat->ibbfeacode,
            'ibbinsid'    => $equipfeat->ibbinsid,
            'ibbstartval' => (Int) $equipfeat->ibbstartval,
            'ibbactive'   => $equipfeat->ibbactive,
        );

        $v_ibbfeacode = $equipfeat->ibbfeacode;
        $v_ibbinsid = $equipfeat->ibbinsid;
        if ($this->getEquipfeat($v_ibbfeacode, $v_ibbinsid)) {
            $this->tableGateway->update($data, array('ibbfeacode' => $v_ibbfeacode,
                                                     'ibbinsid' => $v_ibbinsid));
        } else {
            throw new Exception('Equipment feature could not be found');
        }
    }

    public function deleteEquipfeat($x_ibbfeacode, $x_ibbinsid) {
        $this->tableGateway->delete(array('ibbfeacode' => $x_ibbfeacode,
                                          'ibbinsid' => $x_ibbinsid));
    }
}