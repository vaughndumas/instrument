<?php
namespace Instrument\Model;

use Zend\Db\TableGateway\TableGateway;

class BookingTable {
    
    protected $tableGateway;
    protected $bookingTable;
    
    
    public function getBookingTable() {
        if (!$this->bookingTable) {
            $sm = $this->getServiceLocator();
            $this->bookingTable = $sm->get('Instrument\Model\BookingTable');
        }
        return $this->bookingTable;
    }
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    public function fetchAll() {
        $resultSet = $this->tableGateway->select(array('ADDTIME(ibcdatereq, ibcstarttime) > NOW()'));
        return $resultSet;
    }
    public function getBooking($ibcbookno) {
        $rowset = $this->tableGateway->select(array('ibcbookno' => $ibcbookno));
        $row = $rowset->current();
        if (!$row) {
            throw new Exception("Could not find booking " . $ibcbookno);
        }
        return $row;
    }

    public function saveBooking(Booking $booking) {
        $data = array(
            'ibcdate' => date('Y/m/d H:i:s'),
            'ibcunumber' => $booking->ibcunumber,
            'ibclab' => $booking->ibclab,
            'ibcglc' => $booking->ibcglc,
            'ibcdatereq' => $booking->ibcdatereq,
            'ibcstarttime' => $booking->ibcstarttime,
            'ibcendtime' => $booking->ibcendtime,
            'ibcqueue' => $booking->ibcqueue,
            'ibcinsid' => $booking->ibcinsid,
            'ibcslot' => $booking->ibcslot,
        );
        $this->tableGateway->insert($data);
    }

    
}

?>
