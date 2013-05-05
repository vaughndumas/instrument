<?php
namespace Instrument\Model;

use Zend\Db\TableGateway\TableGateway;

class BookFeatTable {
    protected $tableGateway;
    protected $bookfeatTable;
    
    public function getBookFeatTable() {
        if (!$this->bookfeatTable) {
            $sm = $this->getServiceLocator();
            $this->bookfeatTable = $sm->get('Instrument\Model\BookFeatTable');
        }
        return $this->bookfeatTable;
    }

    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }

    public function saveBookFeat(BookFeat $bookfeat) {
        $data = array(
            'ibdbookno' => $bookfeat->ibdbookno,
            'ibdfeacode' => $bookfeat->ibdfeacode,
            'ibdvalue' => $bookfeat->ibdvalue,
            'ibdcost' => $bookfeat->ibdcost,
            'ibdused' => $bookfeat->ibdused,
        );
        $this->tableGateway->insert($data);
    }
    
    public function getBookFeat_Single($x_ibdbookno, $x_ibdfeacode) {
        $rowset = $this->tableGateway->select(array('ibdbookno' => $x_ibdbookno,
                                                    'ibdfeacode' => $x_ibdfeacode));
        $row = $rowset->current();
        if (!$row) {
            return false;
        }
        return $row;
    }

    public function deleteBookFeat($x_ibdbookno, $x_ibdfeacode) {
        $this->tableGateway->delete(array('ibdbookno' => $x_ibdbookno,
                                          'ibdfeacode' => $x_ibdfeacode));
    }
    
}

?>
