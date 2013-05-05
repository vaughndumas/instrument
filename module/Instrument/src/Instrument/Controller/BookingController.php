<?php
namespace Instrument\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Instrument\Model\Booking;
use Instrument\Form\BookingForm;
use Instrument\Model\BookingTable;
use Instrument\Form\BKMultiBookForm;
use Instrument\Model\BKMultiBook;
use Instrument\Model\BookFeat;
use Instrument\Model\BookFeatTable;

class BookingController extends AbstractActionController {

    protected $bookingTable;
    protected $equipfeatTable;
    protected $bookfeatTable;
    
    public function getEquipfeatTable() {
        if (!$this->equipfeatTable) {
            $sm = $this->getServiceLocator();
            $this->equipfeatTable = $sm->get('Instrument\Model\EquipfeatTable');
        }
        return $this->equipfeatTable;
    }

    
    public function getBookingTable() {
        if (!$this->bookingTable) {
            $sm = $this->getServiceLocator();
            $this->bookingTable = $sm->get('Instrument\Model\BookingTable');
        }
        return $this->bookingTable;
    }
    
    public function getBookFeatTable() {
        if (!$this->bookfeatTable) {
            $sm = $this->getServiceLocator();
            $this->bookfeatTable = $sm->get('Instrument\Model\BookFeatTable');
        }
        return $this->bookfeatTable;
    }

    public function indexAction() {
        return new ViewModel(array(
            'booking' => $this->getBookingTable()->fetchAll(),
        ));
    }
    
    public function addAction() {
        $booking = new Booking();
        
        $sl = $this->getServiceLocator();
        $v_adapter = $sl->get('Zend\Db\Adapter\Adapter');
        $form = new BookingForm($v_adapter);

        $request = $this->getRequest();
        if ($request->isPost()) {

            $booking = $this->getServiceLocator()->get('Instrument/Model/Booking');
            $form->setInputFilter($booking->getInputFilter());
            $form->setData($request->getPost());

            $v_submit = false;
            $v_submit = $request->getPost()->get('submit');
            if ($v_submit != false) {
                if ($form->isValid()) {
                    $booking->exchangeArray($form->getData());
                    $this->getBookingTable()->saveBooking($booking);

                    return $this->redirect()->toRoute('booking');
                } else {
                    var_dump($v_cancel);
                    var_dump($form->getMessages());
                    exit;
                }
            } else
                return $this->redirect()->toRoute('booking');
        }
        return array('form' => $form);
    }
    
    public function addbfmeAction() {
        
        $form = new BKMultiBookForm();
        $booking = new BKMultiBook();

        $v_booking_number = $this->params()->fromRoute('ibcbookno');
        if (!$v_booking_number) {
            return $this->redirect()->toRoute('booking', array(
                        'action' => 'index'
            ));
        }
        
        // Get the booking number and details for this booking 
        $v_booking = $this->getBookingTable()->getBooking($v_booking_number);
        
        // Now get all the features linked to this equipment
        $v_equipfeat = $this->getEquipfeatTable()->getEquipfeat_Equipcode($v_booking->ibcinsid, 2);
        $v_tmp = array();
        foreach ($v_equipfeat as $v_feature_row) {
            
            // Check if the current record already exists.
            // If it does, then mark this record as chosen (1)
            $v_exists = false;
            $v_chosen_value = 0;
            $v_featurevalue = $v_feature_row->ibbstartval;
            $v_exists = $this->getBookFeatTable()->getBookFeat_Single($v_booking_number, $v_feature_row->ibbfeacode);
            if ($v_exists != FALSE) {
                $v_chosen_value = 1;
                $v_featurevalue = $v_exists->ibdvalue;
            }
            $v_tmp[] = array(
                'ibbfeacode' => $v_feature_row->ibbfeacode,
                'ibbstartval' => $v_featurevalue,
                'chosen' => $v_chosen_value,
            );
        }
        
        $booking->setAvailfeatures(array('featureset' => $v_tmp));
        $booking->setIbdbookno($v_booking_number);
        $booking->setIbdinsid($v_booking->ibcinsid);
        $booking->setIbddatereq($v_booking->ibcdatereq);
        $booking->setV_glc($v_booking->ibcglc);
        $form->bind($booking);

        return array('form' => $form);
    }
    
    public function exeaddbfmeAction() {
        $form = new BKMultiBookForm();
        $booking = new BKMultiBook();
        $v_bookfeat = new BookFeat();
        $form->bind($booking);
        
        $sl = $this->getServiceLocator();
        $v_adapter = $sl->get('Zend\Db\Adapter\Adapter');
        $v_bookfeat = new BookFeat();
        $v_bookfeat->setDbAdapter($v_adapter);
        $v_bookfeat = $this->getServiceLocator()->get('Instrument/Model/BookFeat');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
          $cancelButton = $request->getPost('cancel');
          $submitButton = $request->getPost('submit');

          if ($cancelButton) {
              return $this->redirect()->toRoute('booking');
          }
          $form->setData($request->getPost());

          if ($form->isValid()) {
              $booking = $request->getPost();
              foreach ($booking as $v_row=>$v_value) {

                if ( ($v_row != 'bkmultibook') && ($v_row != 'submit')) {
                    $v_underscore = strpos($v_row, '_');
                    $v_chosen = "chosen_".substr($v_row, $v_underscore + 1);
                    $v_isFeatureSet = $booking[$v_chosen];
                    
                    $v_tst = substr($v_row, 0, 7);
                    if ($v_tst == "ibdbook")
                      $v_bookfeat->ibdbookno = $v_value;
                    elseif ($v_tst == "ibdfeac")
                      $v_bookfeat->ibdfeacode = $v_value;
                    elseif ($v_tst == "ibdvalu")
                      $v_bookfeat->ibdvalue = $v_value;
                    elseif ($v_tst == "ibdcost")
                      $v_bookfeat->ibdcost = $v_value;
                    elseif ($v_tst == "ibdused")
                      $v_bookfeat->ibdused = $v_value;
                    elseif ($v_tst == "chosen_") {
                        // Delete the current booking
                        $this->getBookFeatTable()->deleteBookFeat($v_bookfeat->ibdbookno, 
                                                                  $v_bookfeat->ibdfeacode);
                        if ($v_isFeatureSet == 1) {
                            // Get the cost of the current feature
                            // ToDo
                            $v_bookfeat->ibdcost = 0;

                            $v_bookfeat->ibdused = 'N';
                            $this->getBookFeatTable()->saveBookFeat($v_bookfeat);
                        }
                    }
                }
              }
              return $this->redirect()->toRoute('booking');
          } else {
             echo "Form is not valid<br />";
             exit;
          }
        }
        return array('form' => $form);

    }

}

?>
